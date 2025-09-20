<?php

namespace App\Jobs;

use App\Services\WebhookHandlerService;
use DateTime;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Exception;

class ProcessCalendarEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $eventId;
    public string $eventType;
    public array $notification;

    public int $tries = 3;
    public int $maxExceptions = 3;
    public int $timeout = 120;

    public function __construct(string $eventId, string $eventType, array $notification)
    {
        $this->eventId = $eventId;
        $this->eventType = $eventType;
        $this->notification = $notification;
    }

    public function handle(WebhookHandlerService $webhookHandler): void
    {
        Log::info('Processing calendar event job', [
            'event_id' => $this->eventId,
            'event_type' => $this->eventType,
            'attempt' => $this->attempts()
        ]);

        try {
            switch ($this->eventType) {
                case 'created':
                    $webhookHandler->processEventCreation($this->eventId, $this->notification);
                    break;

                case 'updated':
                    $webhookHandler->processEventUpdate($this->eventId, $this->notification);
                    break;

                default:
                    Log::warning('Unknown event type in calendar event job', [
                        'event_type' => $this->eventType,
                        'event_id' => $this->eventId
                    ]);
            }

            Log::info('Calendar event processed successfully', [
                'event_id' => $this->eventId,
                'event_type' => $this->eventType
            ]);

        } catch (Exception $e) {
            Log::error('Failed to process calendar event', [
                'event_id' => $this->eventId,
                'event_type' => $this->eventType,
                'attempt' => $this->attempts(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            throw $e;
        }
    }

    public function failed(Exception $exception): void
    {
        Log::error('Calendar event processing job failed permanently', [
            'event_id' => $this->eventId,
            'event_type' => $this->eventType,
            'total_attempts' => $this->attempts(),
            'error' => $exception->getMessage()
        ]);
    }

    public function retryUntil(): DateTime
    {
        return now()->addHours(2);
    }
}
