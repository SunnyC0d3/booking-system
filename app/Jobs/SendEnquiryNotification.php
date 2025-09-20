<?php

namespace App\Jobs;

use App\Models\Enquiry;
use App\Services\SmartEmailService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Exception;

class SendEnquiryNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Enquiry $enquiry;
    public string $type;
    public array $data;

    public int $tries = 3;
    public int $maxExceptions = 3;
    public int $timeout = 60;

    public function __construct(Enquiry $enquiry, string $type, array $data = [])
    {
        $this->enquiry = $enquiry;
        $this->type = $type;
        $this->data = $data;
    }

    public function handle(SmartEmailService $emailService): void
    {
        Log::info('Sending enquiry notification', [
            'enquiry_id' => $this->enquiry->id,
            'type' => $this->type,
            'attempt' => $this->attempts()
        ]);

        try {
            switch ($this->type) {
                case 'new_enquiry':
                    $emailService->sendEnquiryNotification($this->enquiry);
                    break;

                case 'customer_confirmation':
                    $emailService->sendCustomerConfirmation($this->enquiry);
                    break;

                case 'approved':
                    $emailService->sendApprovalNotification($this->enquiry, $this->data);
                    break;

                case 'declined':
                    $emailService->sendDeclineNotification($this->enquiry, $this->data);
                    break;

                case 'cancelled':
                    // Handle cancellation notification if needed
                    Log::info('Enquiry cancelled notification', [
                        'enquiry_id' => $this->enquiry->id,
                        'data' => $this->data
                    ]);
                    break;

                default:
                    Log::warning('Unknown notification type', [
                        'type' => $this->type,
                        'enquiry_id' => $this->enquiry->id
                    ]);
            }

            Log::info('Enquiry notification sent successfully', [
                'enquiry_id' => $this->enquiry->id,
                'type' => $this->type
            ]);

        } catch (Exception $e) {
            Log::error('Failed to send enquiry notification', [
                'enquiry_id' => $this->enquiry->id,
                'type' => $this->type,
                'attempt' => $this->attempts(),
                'error' => $e->getMessage()
            ]);

            throw $e;
        }
    }

    public function failed(Exception $exception): void
    {
        Log::error('Enquiry notification job failed permanently', [
            'enquiry_id' => $this->enquiry->id,
            'type' => $this->type,
            'total_attempts' => $this->attempts(),
            'error' => $exception->getMessage()
        ]);
    }

    public function retryUntil(): \DateTime
    {
        return now()->addHours(4);
    }
}
