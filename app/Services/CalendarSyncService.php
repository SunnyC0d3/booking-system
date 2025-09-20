<?php

namespace App\Services;

use App\Models\CalendarSyncLog;
use App\Jobs\SyncCalendarChanges;
use App\Jobs\RetryFailedSync;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Exception;

class CalendarSyncService
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
     * Create webhook subscription for calendar events.
     */
    public function createWebhookSubscription(): array
    {
        $ownerEmail = config('enquiry.owner_email');
        $webhookUrl = config('app.url') . '/api/v1/webhooks/microsoft';

        Log::info('Creating webhook subscription', [
            'owner_email' => $ownerEmail,
            'webhook_url' => $webhookUrl
        ]);

        try {
            $subscription = $this->microsoftService->createWebhookSubscription(
                $ownerEmail,
                $webhookUrl,
                '/me/events'
            );

            $this->cacheSubscription($subscription);

            Log::info('Webhook subscription created successfully', [
                'subscription_id' => $subscription['id'],
                'expires_at' => $subscription['expirationDateTime']
            ]);

            return $subscription;

        } catch (Exception $e) {
            Log::error('Failed to create webhook subscription', [
                'error' => $e->getMessage(),
                'owner_email' => $ownerEmail
            ]);

            throw new Exception('Failed to create webhook subscription: ' . $e->getMessage());
        }
    }

    /**
     * Delete all webhook subscriptions.
     */
    public function deleteWebhookSubscriptions(): int
    {
        $ownerEmail = config('enquiry.owner_email');
        $deletedCount = 0;

        try {
            $subscriptions = $this->microsoftService->getWebhookSubscriptions($ownerEmail);

            foreach ($subscriptions as $subscription) {
                try {
                    $this->microsoftService->deleteWebhookSubscription($ownerEmail, $subscription['id']);
                    $deletedCount++;

                    Log::info('Webhook subscription deleted', [
                        'subscription_id' => $subscription['id']
                    ]);
                } catch (Exception $e) {
                    Log::warning('Failed to delete webhook subscription', [
                        'subscription_id' => $subscription['id'],
                        'error' => $e->getMessage()
                    ]);
                }
            }

            $this->clearSubscriptionCache();

            return $deletedCount;

        } catch (Exception $e) {
            Log::error('Failed to get webhook subscriptions for deletion', [
                'error' => $e->getMessage()
            ]);

            throw $e;
        }
    }

    /**
     * Get active webhook subscriptions.
     */
    public function getActiveSubscriptions(): array
    {
        $ownerEmail = config('enquiry.owner_email');

        try {
            $subscriptions = $this->microsoftService->getWebhookSubscriptions($ownerEmail);

            $calendarSubscriptions = array_filter($subscriptions, function ($subscription) {
                return str_contains($subscription['resource'] ?? '', '/events');
            });

            return array_values($calendarSubscriptions);

        } catch (Exception $e) {
            Log::error('Failed to get active subscriptions', [
                'error' => $e->getMessage()
            ]);

            return [];
        }
    }

    /**
     * Check if webhook subscriptions need renewal.
     */
    public function checkSubscriptionRenewal(): array
    {
        $subscriptions = $this->getActiveSubscriptions();
        $renewalNeeded = [];

        foreach ($subscriptions as $subscription) {
            $expiresAt = Carbon::parse($subscription['expirationDateTime']);
            $hoursUntilExpiry = now()->diffInHours($expiresAt, false);

            if ($hoursUntilExpiry <= 24) {
                $renewalNeeded[] = [
                    'id' => $subscription['id'],
                    'expires_at' => $expiresAt,
                    'hours_until_expiry' => $hoursUntilExpiry
                ];
            }
        }

        return $renewalNeeded;
    }

    /**
     * Renew webhook subscriptions.
     */
    public function renewWebhookSubscriptions(): array
    {
        $renewalNeeded = $this->checkSubscriptionRenewal();
        $results = [];

        foreach ($renewalNeeded as $subscription) {
            try {
                $this->microsoftService->deleteWebhookSubscription(
                    config('enquiry.owner_email'),
                    $subscription['id']
                );

                $newSubscription = $this->createWebhookSubscription();

                $results[] = [
                    'old_id' => $subscription['id'],
                    'new_id' => $newSubscription['id'],
                    'status' => 'renewed'
                ];

                Log::info('Webhook subscription renewed', [
                    'old_id' => $subscription['id'],
                    'new_id' => $newSubscription['id']
                ]);

            } catch (Exception $e) {
                $results[] = [
                    'old_id' => $subscription['id'],
                    'status' => 'failed',
                    'error' => $e->getMessage()
                ];

                Log::error('Failed to renew webhook subscription', [
                    'subscription_id' => $subscription['id'],
                    'error' => $e->getMessage()
                ]);
            }
        }

        return $results;
    }

    /**
     * Sync pending enquiries to calendar.
     */
    public function syncPendingEnquiries(): array
    {
        $enquiries = $this->enquiryService->getEnquiriesNeedingSync();
        $results = ['synced' => 0, 'failed' => 0, 'errors' => []];

        Log::info('Starting sync of pending enquiries', [
            'count' => $enquiries->count()
        ]);

        foreach ($enquiries as $enquiry) {
            try {
                $this->calendarEventService->createEventForEnquiry($enquiry);
                $results['synced']++;

                Log::info('Enquiry synced to calendar', [
                    'enquiry_id' => $enquiry->id
                ]);

            } catch (Exception $e) {
                $results['failed']++;
                $results['errors'][] = [
                    'enquiry_id' => $enquiry->id,
                    'error' => $e->getMessage()
                ];

                $this->enquiryService->markSyncFailed($enquiry, $e->getMessage());

                Log::error('Failed to sync enquiry to calendar', [
                    'enquiry_id' => $enquiry->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return $results;
    }

    /**
     * Retry failed synchronizations.
     */
    public function retryFailedSyncs(): array
    {
        $failedLogs = CalendarSyncLog::needsRetry()
            ->where('created_at', '>', now()->subHours(24))
            ->get();

        $results = ['retried' => 0, 'succeeded' => 0, 'failed' => 0];

        Log::info('Retrying failed synchronizations', [
            'count' => $failedLogs->count()
        ]);

        foreach ($failedLogs as $log) {
            if (!$log->canRetry()) {
                continue;
            }

            $results['retried']++;

            RetryFailedSync::dispatch($log);
        }

        return $results;
    }

    /**
     * Get synchronization health status.
     */
    public function getSyncHealthStatus(): array
    {
        $last24Hours = now()->subHours(24);

        $syncLogs = CalendarSyncLog::where('created_at', '>', $last24Hours)->get();
        $total = $syncLogs->count();
        $successful = $syncLogs->where('status', CalendarSyncLog::STATUS_SUCCESS)->count();
        $failed = $syncLogs->where('status', CalendarSyncLog::STATUS_FAILED)->count();
        $pending = $syncLogs->where('status', CalendarSyncLog::STATUS_PENDING)->count();

        $successRate = $total > 0 ? round(($successful / $total) * 100, 2) : 100;

        $enquiriesNeedingSync = $this->enquiryService->getEnquiriesNeedingSync()->count();
        $subscriptionsNeedingRenewal = count($this->checkSubscriptionRenewal());

        return [
            'overall_status' => $this->calculateOverallStatus($successRate, $failed, $pending, $enquiriesNeedingSync),
            'sync_statistics' => [
                'last_24_hours' => [
                    'total_operations' => $total,
                    'successful' => $successful,
                    'failed' => $failed,
                    'pending' => $pending,
                    'success_rate' => $successRate
                ]
            ],
            'pending_work' => [
                'enquiries_needing_sync' => $enquiriesNeedingSync,
                'subscriptions_needing_renewal' => $subscriptionsNeedingRenewal
            ],
            'active_subscriptions' => count($this->getActiveSubscriptions()),
            'last_webhook_received' => $this->getLastWebhookTime(),
            'recommendations' => $this->getHealthRecommendations($successRate, $failed, $enquiriesNeedingSync, $subscriptionsNeedingRenewal)
        ];
    }

    /**
     * Cache webhook subscription details.
     */
    protected function cacheSubscription(array $subscription): void
    {
        $cacheKey = 'microsoft_webhook_subscription';
        $cacheData = [
            'id' => $subscription['id'],
            'expires_at' => $subscription['expirationDateTime'],
            'created_at' => now()->toISOString()
        ];

        Cache::put($cacheKey, $cacheData, now()->addDays(3));
    }

    /**
     * Clear subscription cache.
     */
    protected function clearSubscriptionCache(): void
    {
        Cache::forget('microsoft_webhook_subscription');
    }

    /**
     * Calculate overall health status.
     */
    protected function calculateOverallStatus(float $successRate, int $failed, int $pending, int $needingSync): string
    {
        if ($successRate < 50 || $failed > 10) {
            return 'critical';
        }

        if ($successRate < 80 || $pending > 5 || $needingSync > 10) {
            return 'warning';
        }

        if ($successRate < 95 || $needingSync > 0) {
            return 'good';
        }

        return 'excellent';
    }

    /**
     * Get health recommendations.
     */
    protected function getHealthRecommendations(float $successRate, int $failed, int $needingSync, int $needingRenewal): array
    {
        $recommendations = [];

        if ($successRate < 80) {
            $recommendations[] = 'Low success rate detected. Check Microsoft 365 authentication and API quotas.';
        }

        if ($failed > 5) {
            $recommendations[] = 'High number of failed operations. Review error logs and consider rate limiting.';
        }

        if ($needingSync > 5) {
            $recommendations[] = 'Multiple enquiries awaiting calendar sync. Run manual sync or check for authentication issues.';
        }

        if ($needingRenewal > 0) {
            $recommendations[] = 'Webhook subscriptions need renewal. Run subscription renewal to maintain real-time sync.';
        }

        if (empty($recommendations)) {
            $recommendations[] = 'Calendar synchronization is operating normally.';
        }

        return $recommendations;
    }

    /**
     * Get timestamp of last received webhook.
     */
    protected function getLastWebhookTime(): ?string
    {
        $latestWebhook = CalendarSyncLog::where('event_type', 'webhook_received')
            ->where('sync_direction', CalendarSyncLog::DIRECTION_FROM_MICROSOFT)
            ->latest()
            ->first();

        return $latestWebhook?->created_at?->toISOString();
    }

    /**
     * Perform comprehensive sync maintenance.
     */
    public function performMaintenance(): array
    {
        Log::info('Starting calendar sync maintenance');

        $results = [
            'subscription_renewals' => $this->renewWebhookSubscriptions(),
            'pending_syncs' => $this->syncPendingEnquiries(),
            'failed_retries' => $this->retryFailedSyncs(),
            'cleanup' => $this->cleanupOldLogs()
        ];

        Log::info('Calendar sync maintenance completed', $results);

        return $results;
    }

    /**
     * Clean up old sync logs.
     */
    protected function cleanupOldLogs(): array
    {
        $cutoffDate = now()->subDays(config('enquiry.sync_log_retention_days', 30));

        $deletedCount = CalendarSyncLog::where('created_at', '<', $cutoffDate)->delete();

        Log::info('Old sync logs cleaned up', [
            'deleted_count' => $deletedCount,
            'cutoff_date' => $cutoffDate
        ]);

        return ['deleted_logs' => $deletedCount];
    }
}
