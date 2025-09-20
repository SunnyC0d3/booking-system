<?php

namespace App\Services;

use App\Models\Enquiry;
use App\Models\CalendarSyncLog;
use App\Models\EnquiryStatusHistory;
use App\Jobs\ProcessCalendarEvent;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Exception;

class WebhookHandlerService
{
    protected Microsoft365Service $microsoftService;
    protected CalendarEventService $calendarEventService;
    protected EnquiryService $enquiryService;

    public function __construct(
        Microsoft365Service $microsoftService,
        CalendarEventService $calendarEventService,
        EnquiryService $enquiryService
    ) {
        $this->microsoftService = $microsoftService;
        $this->calendarEventService = $calendarEventService;
        $this->enquiryService = $enquiryService;
    }

    /**
     * Handle calendar event created webhook.
     */
    public function handleEventCreated(string $eventId, array $notification): void
    {
        Log::info('Processing event created webhook', [
            'event_id' => $eventId,
            'notification' => $notification
        ]);

        ProcessCalendarEvent::dispatch($eventId, 'created', $notification);
    }

    /**
     * Handle calendar event updated webhook.
     */
    public function handleEventUpdated(string $eventId, array $notification): void
    {
        Log::info('Processing event updated webhook', [
            'event_id' => $eventId,
            'notification' => $notification
        ]);

        $enquiry = Enquiry::where('microsoft_event_id', $eventId)->first();

        if (!$enquiry) {
            Log::info('Event update for non-enquiry event, ignoring', [
                'event_id' => $eventId
            ]);
            return;
        }

        ProcessCalendarEvent::dispatch($eventId, 'updated', $notification);
    }

    /**
     * Handle calendar event deleted webhook.
     */
    public function handleEventDeleted(string $eventId, array $notification): void
    {
        Log::info('Processing event deleted webhook', [
            'event_id' => $eventId,
            'notification' => $notification
        ]);

        $enquiry = Enquiry::where('microsoft_event_id', $eventId)->first();

        if (!$enquiry) {
            Log::info('Event deletion for non-enquiry event, ignoring', [
                'event_id' => $eventId
            ]);
            return;
        }

        $this->processEventDeletion($enquiry, $notification);
    }

    /**
     * Process calendar event creation.
     */
    public function processEventCreation(string $eventId, array $notification): void
    {
        try {
            $eventDetails = $this->getEventDetails($eventId);

            if (!$eventDetails) {
                Log::info('Event not found or inaccessible', ['event_id' => $eventId]);
                return;
            }

            $enquiry = $this->findMatchingEnquiry($eventDetails);

            if ($enquiry && $enquiry->isApproved() && !$enquiry->hasMicrosoftEvent()) {
                $this->linkEventToEnquiry($enquiry, $eventId, $eventDetails);

                Log::info('Event linked to existing enquiry', [
                    'event_id' => $eventId,
                    'enquiry_id' => $enquiry->id
                ]);
            } else {
                Log::info('Event creation does not match any enquiry', [
                    'event_id' => $eventId,
                    'event_subject' => $eventDetails['subject'] ?? 'Unknown'
                ]);
            }

        } catch (Exception $e) {
            Log::error('Failed to process event creation', [
                'event_id' => $eventId,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Process calendar event update.
     */
    public function processEventUpdate(string $eventId, array $notification): void
    {
        try {
            $enquiry = Enquiry::where('microsoft_event_id', $eventId)->first();

            if (!$enquiry) {
                Log::info('Event update for non-enquiry event', ['event_id' => $eventId]);
                return;
            }

            $eventDetails = $this->getEventDetails($eventId);

            if (!$eventDetails) {
                Log::warning('Updated event not found', [
                    'event_id' => $eventId,
                    'enquiry_id' => $enquiry->id
                ]);
                return;
            }

            $this->logWebhookSync($enquiry, 'updated', $notification, $eventDetails);

            $this->calendarEventService->syncEnquiryFromEvent($eventId, $eventDetails);

            Log::info('Enquiry updated from calendar event', [
                'event_id' => $eventId,
                'enquiry_id' => $enquiry->id
            ]);

        } catch (Exception $e) {
            Log::error('Failed to process event update', [
                'event_id' => $eventId,
                'error' => $e->getMessage()
            ]);

            if (isset($enquiry)) {
                $this->logWebhookSync($enquiry, 'updated', $notification, [], $e->getMessage());
            }
        }
    }

    /**
     * Process calendar event deletion.
     */
    public function processEventDeletion(Enquiry $enquiry, array $notification): void
    {
        try {
            $oldStatus = $enquiry->status;

            $this->logWebhookSync($enquiry, 'deleted', $notification);

            if ($enquiry->isApproved()) {
                $this->enquiryService->declineEnquiry(
                    $enquiry,
                    'Calendar event deleted',
                    'The calendar event was removed, so this enquiry has been declined.'
                );

                Log::info('Enquiry declined due to calendar event deletion', [
                    'enquiry_id' => $enquiry->id,
                    'event_id' => $enquiry->microsoft_event_id,
                    'previous_status' => $oldStatus
                ]);
            }

            $enquiry->update([
                'microsoft_event_id' => null,
                'microsoft_event_data' => null,
                'calendar_sync_status' => Enquiry::SYNC_PENDING,
            ]);

            EnquiryStatusHistory::logStatusChange(
                $enquiry->id,
                $enquiry->status,
                $oldStatus,
                EnquiryStatusHistory::CHANGED_BY_WEBHOOK,
                'calendar_event_deleted',
                ['event_id' => $enquiry->microsoft_event_id]
            );

        } catch (Exception $e) {
            Log::error('Failed to process event deletion', [
                'enquiry_id' => $enquiry->id,
                'event_id' => $enquiry->microsoft_event_id,
                'error' => $e->getMessage()
            ]);

            $this->logWebhookSync($enquiry, 'deleted', $notification, [], $e->getMessage());
        }
    }

    /**
     * Get event details from Microsoft Graph.
     */
    protected function getEventDetails(string $eventId): ?array
    {
        try {
            $ownerEmail = config('enquiry.owner_email');
            return $this->microsoftService->getCalendarEvent($ownerEmail, $eventId);
        } catch (Exception $e) {
            Log::warning('Failed to get event details', [
                'event_id' => $eventId,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Find enquiry that matches the calendar event.
     */
    protected function findMatchingEnquiry(array $eventDetails): ?Enquiry
    {
        $subject = $eventDetails['subject'] ?? '';
        $startDateTime = $eventDetails['start']['dateTime'] ?? null;

        if (preg_match('/Enquiry ID: (\d+)/', $eventDetails['body']['content'] ?? '', $matches)) {
            return Enquiry::find($matches[1]);
        }

        if ($startDateTime) {
            $eventDate = Carbon::parse($startDateTime)->toDateString();

            return Enquiry::where('preferred_date', $eventDate)
                ->where('status', Enquiry::STATUS_APPROVED)
                ->whereNull('microsoft_event_id')
                ->where(function ($query) use ($subject) {
                    $query->whereHas('resource', function ($q) use ($subject) {
                        $q->where('name', 'like', '%' . explode(' - ', $subject)[0] . '%');
                    });
                })
                ->first();
        }

        return null;
    }

    /**
     * Link calendar event to enquiry.
     */
    protected function linkEventToEnquiry(Enquiry $enquiry, string $eventId, array $eventDetails): void
    {
        $enquiry->update([
            'microsoft_event_id' => $eventId,
            'microsoft_event_data' => $eventDetails,
            'calendar_sync_status' => Enquiry::SYNC_SYNCED,
            'calendar_synced_at' => now(),
        ]);

        $this->logWebhookSync($enquiry, 'created', [], $eventDetails);

        EnquiryStatusHistory::logStatusChange(
            $enquiry->id,
            $enquiry->status,
            $enquiry->status,
            EnquiryStatusHistory::CHANGED_BY_WEBHOOK,
            'calendar_event_linked',
            ['event_id' => $eventId]
        );
    }

    /**
     * Log webhook sync activity.
     */
    protected function logWebhookSync(
        Enquiry $enquiry,
        string $eventType,
        array $notification,
        array $eventDetails = [],
        ?string $error = null
    ): void {
        CalendarSyncLog::create([
            'enquiry_id' => $enquiry->id,
            'event_type' => 'webhook_received',
            'microsoft_event_id' => $enquiry->microsoft_event_id,
            'sync_direction' => CalendarSyncLog::DIRECTION_FROM_MICROSOFT,
            'status' => $error ? CalendarSyncLog::STATUS_FAILED : CalendarSyncLog::STATUS_SUCCESS,
            'request_data' => [
                'webhook_type' => $eventType,
                'notification' => $notification
            ],
            'response_data' => $eventDetails,
            'error_message' => $error,
            'synced_at' => $error ? null : now()
        ]);
    }

    /**
     * Validate webhook notification structure.
     */
    public function validateWebhookNotification(array $notification): bool
    {
        $required = ['changeType', 'resourceData'];

        foreach ($required as $field) {
            if (!isset($notification[$field])) {
                Log::warning('Invalid webhook notification structure', [
                    'notification' => $notification,
                    'missing_field' => $field
                ]);
                return false;
            }
        }

        return true;
    }

    /**
     * Check if webhook is for calendar events.
     */
    public function isCalendarEventWebhook(array $notification): bool
    {
        $resourceData = $notification['resourceData'] ?? [];
        $resourceType = $resourceData['@odata.type'] ?? '';

        return str_contains($resourceType, 'event') ||
            str_contains($notification['resource'] ?? '', '/events');
    }

    /**
     * Get webhook processing statistics.
     */
    public function getWebhookStatistics(\Carbon\Carbon $from, \Carbon\Carbon $to): array
    {
        $logs = CalendarSyncLog::where('event_type', 'webhook_received')
            ->where('sync_direction', CalendarSyncLog::DIRECTION_FROM_MICROSOFT)
            ->whereBetween('created_at', [$from, $to])
            ->get();

        return [
            'total_webhooks' => $logs->count(),
            'successful' => $logs->where('status', CalendarSyncLog::STATUS_SUCCESS)->count(),
            'failed' => $logs->where('status', CalendarSyncLog::STATUS_FAILED)->count(),
            'by_event_type' => $logs->groupBy('request_data.webhook_type')->map->count(),
            'processing_times' => [
                'average_seconds' => $logs->avg(function ($log) {
                    return $log->synced_at ? $log->created_at->diffInSeconds($log->synced_at) : null;
                }),
                'max_seconds' => $logs->max(function ($log) {
                    return $log->synced_at ? $log->created_at->diffInSeconds($log->synced_at) : null;
                })
            ]
        ];
    }
}
