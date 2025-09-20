<?php

namespace App\Mail;

use App\Models\Enquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EnquirySyncError extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Enquiry $enquiry;
    public string $error;
    public array $context;

    public function __construct(Enquiry $enquiry, string $error, array $context = [])
    {
        $this->enquiry = $enquiry;
        $this->error = $error;
        $this->context = $context;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "[SYSTEM ERROR] Calendar Sync Failed - Enquiry #{$this->enquiry->id}",
            from: config('enquiry.from_email', config('mail.from.address')),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.enquiry-sync-error',
            with: [
                'enquiry' => $this->enquiry,
                'error' => $this->error,
                'context' => $this->context,
                'timestamp' => now()->format('Y-m-d H:i:s T'),
                'app_url' => config('app.url'),
                'business_name' => config('enquiry.business_name', config('app.name'))
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
