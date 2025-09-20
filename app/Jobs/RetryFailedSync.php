<?php

namespace App\Jobs;

use App\Models\CalendarSyncLog;
use App\Services\CalendarEventService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Exception;

class RetryFailedSync implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public CalendarSyncLog $syncLog;

    public int $tries = 2;
    public int $maxExceptions = 2;
    public int $timeout = 120;

    public function __construct(CalendarSyncLog $syncLog)
    {
        $this->syncLog = $syncLog;
    }

    public function handle(CalendarEventService $calendarService): void
    {
        Log::info('Retrying failed sync operation', [
            'sync_log_id' => $this->syncLog->id,
            'enquiry_id' => $this->syncLog->enquiry_id,
            'event_type' => $this->syncLog->event_type,
            'original_error' => $this->syncLog->error_message,
            'retry_count' => $this->syncLog->retry_count,
            'attempt' => $this->attempts()
        ]);

        if (!$this->syncLog->canRetry()) {
            Log::warning('Sync log cannot be retried', [
                'sync_log_id' => $this->syncLog->id,
                'retry_count' => $this->syncLog->retry_count
            ]);
            return;
        }

        try {
            $this->syncLog->incrementRetry();

            $enquiry = $this->syncLog->enquiry;
            if (!$enquiry) {
                throw new Exception('Associated enquiry not found');
            }

            switch ($this->syncLog->event_type) {
                case 'created':
                    if ($this->syncLog->isToMicrosoft()) {
                        $calendarService->createEventForEnquiry($enquiry);
                    }
                    break;

                case 'updated':
                    if ($this->syncLog->isToMicrosoft()) {
                        $calendarService->updateEventForEnquiry($enquiry);
                    }
                    break;

                case 'deleted':
                    if ($this->syncLog->isToMicrosoft()) {
                        $calendarService->deleteEventForEnquiry($enquiry);
                    }
                    break;

                default:
                    throw new Exception("Unknown event type: {$this->syncLog->event_type}");
            }

            Log::info('Failed sync operation retried successfully', [
                'sync_log_id' => $this->syncLog->id,
                'enquiry_id' => $enquiry->id,
                'event_type' => $this->syncLog->event_type
            ]);

        } catch (Exception $e) {
            Log::error('Retry of failed sync operation failed', [
                'sync_log_id' => $this->syncLog->id,
                'enquiry_id' => $this->syncLog->enquiry_id,
                'attempt' => $this->attempts(),
                'error' => $e->getMessage()
            ]);

            throw $e;
        }
    }

    public function failed(Exception $exception): void
    {
        Log::error('Retry sync job failed permanently', [
            'sync_log_id' => $this->syncLog->id,
            'enquiry_id' => $this->syncLog->enquiry_id,
            'total_attempts' => $this->attempts(),
            'error' => $exception->getMessage()
        ]);
    }

    public function retryUntil(): \DateTime
    {
        return now()->addHours(2);
    }
}
