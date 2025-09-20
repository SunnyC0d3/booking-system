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

class EnquiryNotification extends Mailable implements ShouldQueue
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
        $subject = "New Enquiry: {$this->enquiry->resource->name} - {$this->enquiry->customer_name}";

        if ($this->templateData['is_urgent']) {
            $subject = "[URGENT] " . $subject;
        }

        return new Envelope(
            subject: $subject,
            from: config('enquiry.from_email', config('mail.from.address')),
            replyTo: $this->enquiry->customer_email,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.enquiry-notification',
            with: $this->templateData
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
