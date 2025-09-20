<?php

namespace App\Jobs;

use App\Services\CalendarSyncService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Exception;

class SyncCalendarChanges implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $syncType;
    public array $options;

    public int $tries = 2;
    public int $maxExceptions = 2;
    public int $timeout = 300;

    public function __construct(string $syncType = 'pending', array $options = [])
    {
        $this->syncType = $syncType;
        $this->options = $options;
    }

    public function handle(CalendarSyncService $syncService): void
    {
        Log::info('Starting calendar sync job', [
            'sync_type' => $this->syncType,
            'options' => $this->options,
            'attempt' => $this->attempts()
        ]);

        try {
            $results = [];

            switch ($this->syncType) {
                case 'pending':
                    $results = $syncService->syncPendingEnquiries();
                    break;

                case 'retry_failed':
                    $results = $syncService->retryFailedSyncs();
                    break;

                case 'maintenance':
                    $results = $syncService->performMaintenance();
                    break;

                case 'subscription_renewal':
                    $results['renewals'] = $syncService->renewWebhookSubscriptions();
                    break;

                default:
                    Log::warning('Unknown sync type', [
                        'sync_type' => $this->syncType
                    ]);
                    return;
            }

            Log::info('Calendar sync job completed successfully', [
                'sync_type' => $this->syncType,
                'results' => $results
            ]);

        } catch (Exception $e) {
            Log::error('Calendar sync job failed', [
                'sync_type' => $this->syncType,
                'attempt' => $this->attempts(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            throw $e;
        }
    }

    public function failed(Exception $exception): void
    {
        Log::error('Calendar sync job failed permanently', [
            'sync_type' => $this->syncType,
            'total_attempts' => $this->attempts(),
            'error' => $exception->getMessage()
        ]);
    }

    public function retryUntil(): \DateTime
    {
        return now()->addHours(1);
    }
}
