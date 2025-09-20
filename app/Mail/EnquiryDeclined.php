<?php

namespace App\Mail;

use App\Models\Enquiry;
use App\Services\SmartEmailService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EnquiryDeclined extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Enquiry $enquiry;
    public array $templateData;
    public array $additionalData;

    public function __construct(Enquiry $enquiry, array $additionalData = [])
    {
        $this->enquiry = $enquiry;
        $this->additionalData = $additionalData;

        $emailService = app(SmartEmailService::class);
        $this->templateData = $emailService->getTemplateData($enquiry, $additionalData);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Update on your enquiry - {$this->enquiry->resource->name}",
            from: config('enquiry.from_email', config('mail.from.address')),
            replyTo: config('enquiry.owner_email'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.enquiry-declined',
            with: $this->templateData
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
