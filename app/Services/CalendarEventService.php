<?php

namespace App\Services;

use App\Models\Enquiry;
use App\Models\CalendarSyncLog;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Exception;

class CalendarEventService
{
    protected Microsoft365Service $microsoftService;
    protected string $ownerEmail;

    public function __construct(Microsoft365Service $microsoftService)
    {
        $this->microsoftService = $microsoftService;
        $this->ownerEmail = config('enquiry.owner_email');
    }

    /**
     * Create a calendar event for an approved enquiry.
     */
    public function createEventForEnquiry(Enquiry $enquiry): array
    {
        $this->logSyncAttempt($enquiry, 'created', 'to_microsoft');

        try {
            $eventData = $this->buildEventDataFromEnquiry($enquiry);

            $createdEvent = $this->microsoftService->createCalendarEvent(
                $this->ownerEmail,
                $eventData
            );

            $enquiry->update([
                'microsoft_event_id' => $createdEvent['id'],
                'microsoft_event_data' => $createdEvent,
                'calendar_sync_status' => Enquiry::SYNC_SYNCED,
                'calendar_synced_at' => now(),
            ]);

            $this->logSyncSuccess($enquiry, 'created', 'to_microsoft', $createdEvent);

            Log::info('Calendar event created for enquiry', [
                'enquiry_id' => $enquiry->id,
                'event_id' => $createdEvent['id'],
                'customer_email' => $enquiry->customer_email
            ]);

            return $createdEvent;

        } catch (Exception $e) {
            $this->logSyncFailure($enquiry, 'created', 'to_microsoft', $e->getMessage());
            throw $e;
        }
    }

    /**
     * Update a calendar event for an enquiry.
     */
    public function updateEventForEnquiry(Enquiry $enquiry): array
    {
        if (!$enquiry->hasMicrosoftEvent()) {
            throw new Exception('Enquiry has no associated calendar event to update');
        }

        $this->logSyncAttempt($enquiry, 'updated', 'to_microsoft');

        try {
            $eventData = $this->buildEventDataFromEnquiry($enquiry);

            $updatedEvent = $this->microsoftService->updateCalendarEvent(
                $this->ownerEmail,
                $enquiry->microsoft_event_id,
                $eventData
            );

            $enquiry->update([
                'microsoft_event_data' => $updatedEvent,
                'calendar_synced_at' => now(),
            ]);

            $this->logSyncSuccess($enquiry, 'updated', 'to_microsoft', $updatedEvent);

            Log::info('Calendar event updated for enquiry', [
                'enquiry_id' => $enquiry->id,
                'event_id' => $enquiry->microsoft_event_id
            ]);

            return $updatedEvent;

        } catch (Exception $e) {
            $this->logSyncFailure($enquiry, 'updated', 'to_microsoft', $e->getMessage());
            throw $e;
        }
    }

    /**
     * Delete a calendar event for an enquiry.
     */
    public function deleteEventForEnquiry(Enquiry $enquiry): bool
    {
        if (!$enquiry->hasMicrosoftEvent()) {
            return true;
        }

        $this->logSyncAttempt($enquiry, 'deleted', 'to_microsoft');

        try {
            $success = $this->microsoftService->deleteCalendarEvent(
                $this->ownerEmail,
                $enquiry->microsoft_event_id
            );

            if ($success) {
                $enquiry->update([
                    'microsoft_event_id' => null,
                    'microsoft_event_data' => null,
                    'calendar_sync_status' => Enquiry::SYNC_PENDING,
                ]);

                $this->logSyncSuccess($enquiry, 'deleted', 'to_microsoft');

                Log::info('Calendar event deleted for enquiry', [
                    'enquiry_id' => $enquiry->id,
                    'event_id' => $enquiry->microsoft_event_id
                ]);
            }

            return $success;

        } catch (Exception $e) {
            $this->logSyncFailure($enquiry, 'deleted', 'to_microsoft', $e->getMessage());
            throw $e;
        }
    }

    /**
     * Build Microsoft Graph event data from enquiry.
     */
    protected function buildEventDataFromEnquiry(Enquiry $enquiry): array
    {
        $resource = $enquiry->resource;

        $startDateTime = $this->getEventStartTime($enquiry);
        $endDateTime = $this->getEventEndTime($enquiry);
        $subject = $this->buildEventSubject($enquiry);
        $body = $this->buildEventBody($enquiry);

        $eventData = [
            'subject' => $subject,
            'start_time' => $startDateTime->toISOString(),
            'end_time' => $endDateTime->toISOString(),
            'timezone' => config('app.timezone', 'UTC'),
            'body' => $body,
            'location' => $resource->name,
            'reminder_minutes' => config('enquiry.default_reminder_minutes', 15)
        ];

        if (config('enquiry.add_customer_as_attendee', false)) {
            $eventData['attendees'] = [
                [
                    'email' => $enquiry->customer_email,
                    'name' => $enquiry->customer_name,
                    'type' => 'required'
                ]
            ];
        }

        return $this->microsoftService->formatEventData($eventData);
    }

    /**
     * Build event subject from enquiry.
     */
    protected function buildEventSubject(Enquiry $enquiry): string
    {
        $template = config('enquiry.event_subject_template', '{resource} - {customer}');

        return str_replace([
            '{resource}',
            '{customer}',
            '{company}',
            '{date}'
        ], [
            $enquiry->resource->name,
            $enquiry->customer_name,
            $enquiry->customer_company ?? '',
            $enquiry->preferred_date->format('M j, Y')
        ], $template);
    }

    /**
     * Build event body from enquiry.
     */
    protected function buildEventBody(Enquiry $enquiry): string
    {
        $html = '<h3>Enquiry Details</h3>';
        $html .= '<p><strong>Customer:</strong> ' . e($enquiry->customer_name) . '</p>';
        $html .= '<p><strong>Email:</strong> ' . e($enquiry->customer_email) . '</p>';

        if ($enquiry->customer_phone) {
            $html .= '<p><strong>Phone:</strong> ' . e($enquiry->customer_phone) . '</p>';
        }

        if ($enquiry->customer_company) {
            $html .= '<p><strong>Company:</strong> ' . e($enquiry->customer_company) . '</p>';
        }

        $html .= '<p><strong>Resource:</strong> ' . e($enquiry->resource->name) . '</p>';
        $html .= '<p><strong>Preferred Date:</strong> ' . $enquiry->preferred_date->format('l, F j, Y') . '</p>';

        if ($enquiry->preferred_start_time && $enquiry->preferred_end_time) {
            $html .= '<p><strong>Preferred Time:</strong> ' . $enquiry->preferred_start_time . ' - ' . $enquiry->preferred_end_time . '</p>';
        }

        if ($enquiry->message) {
            $html .= '<h4>Customer Message</h4>';
            $html .= '<p>' . nl2br(e($enquiry->message)) . '</p>';
        }

        $html .= '<hr>';
        $html .= '<p><small>Enquiry ID: ' . $enquiry->id . ' | Created: ' . $enquiry->created_at->format('M j, Y g:i A') . '</small></p>';

        return $html;
    }

    /**
     * Get event start time.
     */
    protected function getEventStartTime(Enquiry $enquiry): Carbon
    {
        if ($enquiry->preferred_start_time) {
            return Carbon::createFromFormat(
                'Y-m-d H:i',
                $enquiry->preferred_date->format('Y-m-d') . ' ' . $enquiry->preferred_start_time
            );
        }

        return $enquiry->preferred_date->copy()->setTime(9, 0);
    }

    /**
     * Get event end time.
     */
    protected function getEventEndTime(Enquiry $enquiry): Carbon
    {
        if ($enquiry->preferred_end_time) {
            return Carbon::createFromFormat(
                'Y-m-d H:i',
                $enquiry->preferred_date->format('Y-m-d') . ' ' . $enquiry->preferred_end_time
            );
        }

        return $this->getEventStartTime($enquiry)->addHours(2);
    }

    /**
     * Log sync attempt.
     */
    protected function logSyncAttempt(Enquiry $enquiry, string $eventType, string $direction): CalendarSyncLog
    {
        return CalendarSyncLog::create([
            'enquiry_id' => $enquiry->id,
            'event_type' => $eventType,
            'microsoft_event_id' => $enquiry->microsoft_event_id,
            'sync_direction' => $direction,
            'status' => CalendarSyncLog::STATUS_PENDING,
            'request_data' => [
                'enquiry_id' => $enquiry->id,
                'preferred_date' => $enquiry->preferred_date,
                'resource_name' => $enquiry->resource->name
            ]
        ]);
    }

    /**
     * Log sync success.
     */
    protected function logSyncSuccess(Enquiry $enquiry, string $eventType, string $direction, array $responseData = []): void
    {
        $syncLog = CalendarSyncLog::where('enquiry_id', $enquiry->id)
            ->where('event_type', $eventType)
            ->where('sync_direction', $direction)
            ->where('status', CalendarSyncLog::STATUS_PENDING)
            ->latest()
            ->first();

        if ($syncLog) {
            $syncLog->markAsSuccess($responseData);
        }
    }

    /**
     * Log sync failure.
     */
    protected function logSyncFailure(Enquiry $enquiry, string $eventType, string $direction, string $error, array $responseData = []): void
    {
        $syncLog = CalendarSyncLog::where('enquiry_id', $enquiry->id)
            ->where('event_type', $eventType)
            ->where('sync_direction', $direction)
            ->where('status', CalendarSyncLog::STATUS_PENDING)
            ->latest()
            ->first();

        if ($syncLog) {
            $syncLog->markAsFailed($error, $responseData);
        }
    }

    /**
     * Sync enquiry changes from Microsoft calendar event.
     */
    public function syncEnquiryFromEvent(string $eventId, array $eventData): ?Enquiry
    {
        $enquiry = Enquiry::where('microsoft_event_id', $eventId)->first();

        if (!$enquiry) {
            Log::warning('Received webhook for unknown event', ['event_id' => $eventId]);
            return null;
        }

        $this->logSyncAttempt($enquiry, 'updated', 'from_microsoft');

        try {
            $updates = $this->extractEnquiryUpdatesFromEvent($eventData);

            if (!empty($updates)) {
                $enquiry->update($updates);

                Log::info('Enquiry updated from calendar event', [
                    'enquiry_id' => $enquiry->id,
                    'event_id' => $eventId,
                    'updates' => array_keys($updates)
                ]);
            }

            $this->logSyncSuccess($enquiry, 'updated', 'from_microsoft', $eventData);

            return $enquiry->fresh();

        } catch (Exception $e) {
            $this->logSyncFailure($enquiry, 'updated', 'from_microsoft', $e->getMessage(), $eventData);
            throw $e;
        }
    }

    /**
     * Extract enquiry updates from Microsoft event data.
     */
    protected function extractEnquiryUpdatesFromEvent(array $eventData): array
    {
        $updates = [];

        $updates['microsoft_event_data'] = $eventData;
        $updates['calendar_synced_at'] = now();

        if (isset($eventData['start']['dateTime'])) {
            $startTime = Carbon::parse($eventData['start']['dateTime']);
            $newDate = $startTime->toDateString();
            $newStartTime = $startTime->format('H:i');

            $updates['preferred_date'] = $newDate;
            $updates['preferred_start_time'] = $newStartTime;
        }

        if (isset($eventData['end']['dateTime'])) {
            $endTime = Carbon::parse($eventData['end']['dateTime']);
            $updates['preferred_end_time'] = $endTime->format('H:i');
        }

        return $updates;
    }
}
