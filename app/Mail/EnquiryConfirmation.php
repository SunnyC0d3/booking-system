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

class EnquiryConfirmation extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Enquiry $enquiry;
    public array $templateData;

    public function __construct(Enquiry $enquiry)
    {
        $this->enquiry = $enquiry;

        $emailService = app(SmartEmailService::class);
        $this->templateData = $emailService->getTemplateData($enquiry);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Enquiry Received - {$this->enquiry->resource->name}",
            from: config('enquiry.from_email', config('mail.from.address')),
            replyTo: config('enquiry.owner_email'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.enquiry-confirmation',
            with: $this->templateData
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
