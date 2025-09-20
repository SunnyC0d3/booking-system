<?php

namespace App\Services;

use App\Models\Enquiry;
use App\Models\EnquiryStatusHistory;
use App\Models\Resource;
use App\Jobs\SendEnquiryNotification;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Exception;

class EnquiryService
{
    protected SmartEmailService $emailService;

    public function __construct(SmartEmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    /**
     * Create a new enquiry.
     */
    public function createEnquiry(Resource $resource, array $data): Enquiry
    {
        $enquiry = Enquiry::create([
            'resource_id' => $resource->id,
            'preferred_date' => $data['preferred_date'],
            'preferred_start_time' => $data['preferred_start_time'] ?? null,
            'preferred_end_time' => $data['preferred_end_time'] ?? null,
            'customer_info' => $data['customer_info'],
            'message' => $data['message'] ?? null,
            'status' => Enquiry::STATUS_PENDING,
            'enquiry_token' => Str::random(32),
            'expires_at' => Carbon::parse($data['preferred_date'])->addDays(30),
        ]);

        EnquiryStatusHistory::logStatusChange(
            $enquiry->id,
            Enquiry::STATUS_PENDING,
            null,
            EnquiryStatusHistory::CHANGED_BY_SYSTEM,
            'enquiry_created'
        );

        $this->sendEnquiryNotifications($enquiry);

        return $enquiry;
    }

    /**
     * Update an existing enquiry.
     */
    public function updateEnquiry(Enquiry $enquiry, array $data): Enquiry
    {
        $oldStatus = $enquiry->status;

        $enquiry->update($data);

        if (isset($data['status']) && $data['status'] !== $oldStatus) {
            EnquiryStatusHistory::logStatusChange(
                $enquiry->id,
                $data['status'],
                $oldStatus,
                EnquiryStatusHistory::CHANGED_BY_API,
                'status_updated'
            );
        }

        return $enquiry->fresh();
    }

    /**
     * Approve an enquiry.
     */
    public function approveEnquiry(Enquiry $enquiry, string $reason = 'manual_approval', ?string $notes = null): Enquiry
    {
        if (!$enquiry->canBeApproved()) {
            throw new Exception('Enquiry cannot be approved');
        }

        $oldStatus = $enquiry->status;

        $enquiry->update([
            'status' => Enquiry::STATUS_APPROVED,
        ]);

        EnquiryStatusHistory::logStatusChange(
            $enquiry->id,
            Enquiry::STATUS_APPROVED,
            $oldStatus,
            EnquiryStatusHistory::CHANGED_BY_OWNER,
            $reason,
            $notes ? ['notes' => $notes] : null,
            $notes
        );

        SendEnquiryNotification::dispatch($enquiry, 'approved');

        return $enquiry->fresh();
    }

    /**
     * Decline an enquiry.
     */
    public function declineEnquiry(Enquiry $enquiry, string $reason = 'Not available', ?string $customMessage = null): Enquiry
    {
        if (!$enquiry->canBeDeclined()) {
            throw new Exception('Enquiry cannot be declined');
        }

        $oldStatus = $enquiry->status;

        $enquiry->update([
            'status' => Enquiry::STATUS_DECLINED,
        ]);

        EnquiryStatusHistory::logStatusChange(
            $enquiry->id,
            Enquiry::STATUS_DECLINED,
            $oldStatus,
            EnquiryStatusHistory::CHANGED_BY_OWNER,
            'manual_decline',
            [
                'decline_reason' => $reason,
                'custom_message' => $customMessage
            ]
        );

        SendEnquiryNotification::dispatch($enquiry, 'declined', [
            'decline_reason' => $reason,
            'custom_message' => $customMessage
        ]);

        return $enquiry->fresh();
    }

    /**
     * Cancel an enquiry.
     */
    public function cancelEnquiry(Enquiry $enquiry, string $reason = 'Cancelled', bool $notifyCustomer = true): Enquiry
    {
        $oldStatus = $enquiry->status;

        $enquiry->update([
            'status' => Enquiry::STATUS_CANCELLED,
        ]);

        EnquiryStatusHistory::logStatusChange(
            $enquiry->id,
            Enquiry::STATUS_CANCELLED,
            $oldStatus,
            EnquiryStatusHistory::CHANGED_BY_SYSTEM,
            'cancellation',
            ['reason' => $reason]
        );

        if ($notifyCustomer) {
            SendEnquiryNotification::dispatch($enquiry, 'cancelled', [
                'cancellation_reason' => $reason
            ]);
        }

        return $enquiry->fresh();
    }

    /**
     * Send enquiry notifications.
     */
    protected function sendEnquiryNotifications(Enquiry $enquiry): void
    {
        SendEnquiryNotification::dispatch($enquiry, 'new_enquiry');
        SendEnquiryNotification::dispatch($enquiry, 'customer_confirmation');
    }

    /**
     * Get enquiry statistics for a date range.
     */
    public function getEnquiryStatistics(string $from, string $to): array
    {
        $baseQuery = Enquiry::whereBetween('created_at', [
            Carbon::parse($from)->startOfDay(),
            Carbon::parse($to)->endOfDay()
        ]);

        $totalEnquiries = $baseQuery->count();

        $statusCounts = [
            'pending' => $baseQuery->clone()->where('status', Enquiry::STATUS_PENDING)->count(),
            'approved' => $baseQuery->clone()->where('status', Enquiry::STATUS_APPROVED)->count(),
            'declined' => $baseQuery->clone()->where('status', Enquiry::STATUS_DECLINED)->count(),
            'cancelled' => $baseQuery->clone()->where('status', Enquiry::STATUS_CANCELLED)->count(),
        ];

        $resourceBreakdown = $baseQuery->clone()
            ->selectRaw('resource_id, resources.name as resource_name, count(*) as count')
            ->join('resources', 'enquiries.resource_id', '=', 'resources.id')
            ->groupBy('resource_id', 'resources.name')
            ->get()
            ->keyBy('resource_name')
            ->map(fn($item) => $item->count)
            ->toArray();

        $conversionRate = $totalEnquiries > 0
            ? round(($statusCounts['approved'] / $totalEnquiries) * 100, 2)
            : 0;

        return [
            'period' => [
                'from' => $from,
                'to' => $to
            ],
            'total_enquiries' => $totalEnquiries,
            'status_breakdown' => $statusCounts,
            'resource_breakdown' => $resourceBreakdown,
            'conversion_rate' => $conversionRate,
            'response_times' => $this->getResponseTimeStatistics($from, $to)
        ];
    }

    /**
     * Get response time statistics.
     */
    protected function getResponseTimeStatistics(string $from, string $to): array
    {
        $approvedEnquiries = Enquiry::whereBetween('created_at', [
            Carbon::parse($from)->startOfDay(),
            Carbon::parse($to)->endOfDay()
        ])
            ->where('status', Enquiry::STATUS_APPROVED)
            ->with(['statusHistory' => function ($query) {
                $query->where('new_status', Enquiry::STATUS_APPROVED)
                    ->orderBy('created_at', 'asc');
            }])
            ->get();

        if ($approvedEnquiries->isEmpty()) {
            return [
                'average_response_hours' => 0,
                'fastest_response_hours' => 0,
                'slowest_response_hours' => 0
            ];
        }

        $responseTimes = $approvedEnquiries->map(function ($enquiry) {
            $approval = $enquiry->statusHistory->first();
            if (!$approval) {
                return null;
            }

            return $enquiry->created_at->diffInHours($approval->created_at);
        })->filter()->values();

        if ($responseTimes->isEmpty()) {
            return [
                'average_response_hours' => 0,
                'fastest_response_hours' => 0,
                'slowest_response_hours' => 0
            ];
        }

        return [
            'average_response_hours' => round($responseTimes->average(), 1),
            'fastest_response_hours' => $responseTimes->min(),
            'slowest_response_hours' => $responseTimes->max()
        ];
    }

    /**
     * Clean up expired enquiries.
     */
    public function cleanupExpiredEnquiries(): int
    {
        $expiredEnquiries = Enquiry::where('status', Enquiry::STATUS_PENDING)
            ->where('expires_at', '<', now())
            ->get();

        $count = 0;
        foreach ($expiredEnquiries as $enquiry) {
            $this->cancelEnquiry($enquiry, 'Enquiry expired', false);
            $count++;
        }

        return $count;
    }

    /**
     * Find enquiries that need sync with calendar.
     */
    public function getEnquiriesNeedingSync(): \Illuminate\Database\Eloquent\Collection
    {
        return Enquiry::where('status', Enquiry::STATUS_APPROVED)
            ->where('calendar_sync_enabled', true)
            ->where('calendar_sync_status', Enquiry::SYNC_PENDING)
            ->get();
    }

    /**
     * Mark enquiry as synced with calendar.
     */
    public function markAsSynced(Enquiry $enquiry, string $microsoftEventId, array $eventData = []): void
    {
        $enquiry->update([
            'microsoft_event_id' => $microsoftEventId,
            'microsoft_event_data' => $eventData,
            'calendar_sync_status' => Enquiry::SYNC_SYNCED,
            'calendar_synced_at' => now(),
        ]);
    }

    /**
     * Mark enquiry sync as failed.
     */
    public function markSyncFailed(Enquiry $enquiry, string $error): void
    {
        $enquiry->update([
            'calendar_sync_status' => Enquiry::SYNC_FAILED,
        ]);

        EnquiryStatusHistory::logStatusChange(
            $enquiry->id,
            $enquiry->status,
            $enquiry->status,
            EnquiryStatusHistory::CHANGED_BY_SYSTEM,
            'sync_failed',
            ['error' => $error]
        );
    }
}
