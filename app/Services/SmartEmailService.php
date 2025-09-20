<?php

namespace App\Services;

use App\Models\Enquiry;
use App\Mail\EnquiryNotification;
use App\Mail\EnquiryConfirmation;
use App\Mail\EnquiryApproved;
use App\Mail\EnquiryDeclined;
use App\Mail\EnquirySyncError;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Exception;

class SmartEmailService
{
    /**
     * Send new enquiry notification to business owner.
     */
    public function sendEnquiryNotification(Enquiry $enquiry): void
    {
        try {
            $ownerEmail = config('enquiry.owner_email');

            Mail::to($ownerEmail)->send(new EnquiryNotification($enquiry));

            Log::info('Enquiry notification sent to owner', [
                'enquiry_id' => $enquiry->id,
                'owner_email' => $ownerEmail,
                'customer_email' => $enquiry->customer_email
            ]);

        } catch (Exception $e) {
            Log::error('Failed to send enquiry notification', [
                'enquiry_id' => $enquiry->id,
                'error' => $e->getMessage()
            ]);

            throw $e;
        }
    }

    /**
     * Send confirmation email to customer.
     */
    public function sendCustomerConfirmation(Enquiry $enquiry): void
    {
        try {
            Mail::to($enquiry->customer_email)->send(new EnquiryConfirmation($enquiry));

            Log::info('Enquiry confirmation sent to customer', [
                'enquiry_id' => $enquiry->id,
                'customer_email' => $enquiry->customer_email
            ]);

        } catch (Exception $e) {
            Log::error('Failed to send customer confirmation', [
                'enquiry_id' => $enquiry->id,
                'customer_email' => $enquiry->customer_email,
                'error' => $e->getMessage()
            ]);

            throw $e;
        }
    }

    /**
     * Send approval notification to customer.
     */
    public function sendApprovalNotification(Enquiry $enquiry, array $data = []): void
    {
        try {
            Mail::to($enquiry->customer_email)->send(new EnquiryApproved($enquiry, $data));

            Log::info('Approval notification sent to customer', [
                'enquiry_id' => $enquiry->id,
                'customer_email' => $enquiry->customer_email
            ]);

        } catch (Exception $e) {
            Log::error('Failed to send approval notification', [
                'enquiry_id' => $enquiry->id,
                'customer_email' => $enquiry->customer_email,
                'error' => $e->getMessage()
            ]);

            throw $e;
        }
    }

    /**
     * Send decline notification to customer.
     */
    public function sendDeclineNotification(Enquiry $enquiry, array $data = []): void
    {
        try {
            Mail::to($enquiry->customer_email)->send(new EnquiryDeclined($enquiry, $data));

            Log::info('Decline notification sent to customer', [
                'enquiry_id' => $enquiry->id,
                'customer_email' => $enquiry->customer_email,
                'decline_reason' => $data['decline_reason'] ?? 'Not specified'
            ]);

        } catch (Exception $e) {
            Log::error('Failed to send decline notification', [
                'enquiry_id' => $enquiry->id,
                'customer_email' => $enquiry->customer_email,
                'error' => $e->getMessage()
            ]);

            throw $e;
        }
    }

    /**
     * Send sync error notification to admin.
     */
    public function sendSyncErrorNotification(Enquiry $enquiry, string $error, array $context = []): void
    {
        try {
            $adminEmail = config('enquiry.admin_email', config('enquiry.owner_email'));

            Mail::to($adminEmail)->send(new EnquirySyncError($enquiry, $error, $context));

            Log::info('Sync error notification sent to admin', [
                'enquiry_id' => $enquiry->id,
                'admin_email' => $adminEmail,
                'error' => $error
            ]);

        } catch (Exception $e) {
            Log::error('Failed to send sync error notification', [
                'enquiry_id' => $enquiry->id,
                'error' => $e->getMessage(),
                'original_error' => $error
            ]);
        }
    }

    /**
     * Generate action URLs for email buttons.
     */
    public function generateActionUrls(Enquiry $enquiry): array
    {
        $baseUrl = config('app.url');
        $token = $enquiry->enquiry_token;

        return [
            'approve' => "{$baseUrl}/api/v1/enquiries/actions/{$token}/approve",
            'decline' => "{$baseUrl}/api/v1/enquiries/actions/{$token}/decline",
            'view' => "{$baseUrl}/api/v1/enquiries/{$enquiry->id}"
        ];
    }

    /**
     * Generate calendar action buttons HTML.
     */
    public function generateCalendarButtons(Enquiry $enquiry): string
    {
        $actionUrls = $this->generateActionUrls($enquiry);

        $approveButtonStyle = $this->getButtonStyle('approve');
        $declineButtonStyle = $this->getButtonStyle('decline');

        return "
        <table style='margin: 20px 0;'>
            <tr>
                <td style='padding-right: 10px;'>
                    <a href='{$actionUrls['approve']}' style='{$approveButtonStyle}'>
                        ✓ Approve & Add to Calendar
                    </a>
                </td>
                <td>
                    <a href='{$actionUrls['decline']}' style='{$declineButtonStyle}'>
                        ✗ Decline
                    </a>
                </td>
            </tr>
        </table>
        ";
    }

    /**
     * Generate Outlook calendar event URL.
     */
    public function generateOutlookCalendarUrl(Enquiry $enquiry): string
    {
        $subject = urlencode($this->buildCalendarSubject($enquiry));
        $startTime = $this->getFormattedEventTime($enquiry, 'start');
        $endTime = $this->getFormattedEventTime($enquiry, 'end');
        $body = urlencode($this->buildCalendarBody($enquiry));
        $location = urlencode($enquiry->resource->name);

        $params = [
            'subject' => $subject,
            'startdt' => $startTime,
            'enddt' => $endTime,
            'body' => $body,
            'location' => $location
        ];

        return 'https://outlook.live.com/calendar/0/deeplink/compose?' . http_build_query($params);
    }

    /**
     * Generate Google Calendar event URL.
     */
    public function generateGoogleCalendarUrl(Enquiry $enquiry): string
    {
        $subject = urlencode($this->buildCalendarSubject($enquiry));
        $startTime = $this->getFormattedEventTime($enquiry, 'start', 'google');
        $endTime = $this->getFormattedEventTime($enquiry, 'end', 'google');
        $details = urlencode($this->buildCalendarBody($enquiry, false));
        $location = urlencode($enquiry->resource->name);

        $params = [
            'action' => 'TEMPLATE',
            'text' => $subject,
            'dates' => "{$startTime}/{$endTime}",
            'details' => $details,
            'location' => $location
        ];

        return 'https://calendar.google.com/calendar/render?' . http_build_query($params);
    }

    /**
     * Build calendar event subject.
     */
    protected function buildCalendarSubject(Enquiry $enquiry): string
    {
        return "{$enquiry->resource->name} - {$enquiry->customer_name}";
    }

    /**
     * Build calendar event body.
     */
    protected function buildCalendarBody(Enquiry $enquiry, bool $isHtml = true): string
    {
        $separator = $isHtml ? '<br>' : "\n";
        $bold = $isHtml ? ['<strong>', '</strong>'] : ['', ''];

        $body = "{$bold[0]}Customer:{$bold[1]} {$enquiry->customer_name}{$separator}";
        $body .= "{$bold[0]}Email:{$bold[1]} {$enquiry->customer_email}{$separator}";

        if ($enquiry->customer_phone) {
            $body .= "{$bold[0]}Phone:{$bold[1]} {$enquiry->customer_phone}{$separator}";
        }

        if ($enquiry->customer_company) {
            $body .= "{$bold[0]}Company:{$bold[1]} {$enquiry->customer_company}{$separator}";
        }

        if ($enquiry->message) {
            $body .= "{$separator}{$bold[0]}Message:{$bold[1]}{$separator}{$enquiry->message}";
        }

        return $body;
    }

    /**
     * Get formatted event time for calendar URLs.
     */
    protected function getFormattedEventTime(Enquiry $enquiry, string $type, string $format = 'outlook'): string
    {
        $date = $enquiry->preferred_date;

        if ($type === 'start' && $enquiry->preferred_start_time) {
            $time = Carbon::createFromFormat('H:i', $enquiry->preferred_start_time);
            $datetime = $date->copy()->setTime($time->hour, $time->minute);
        } elseif ($type === 'end' && $enquiry->preferred_end_time) {
            $time = Carbon::createFromFormat('H:i', $enquiry->preferred_end_time);
            $datetime = $date->copy()->setTime($time->hour, $time->minute);
        } else {
            $datetime = $type === 'start'
                ? $date->copy()->setTime(9, 0)
                : $date->copy()->setTime(11, 0);
        }

        return $format === 'google'
            ? $datetime->format('Ymd\THis\Z')
            : $datetime->toISOString();
    }

    /**
     * Get button styling for email actions.
     */
    protected function getButtonStyle(string $type): string
    {
        $baseStyle = "
            display: inline-block;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            text-align: center;
            color: white;
            font-family: Arial, sans-serif;
            font-size: 14px;
        ";

        $colorStyles = [
            'approve' => 'background-color: #10b981; border: 2px solid #059669;',
            'decline' => 'background-color: #ef4444; border: 2px solid #dc2626;',
            'view' => 'background-color: #3b82f6; border: 2px solid #2563eb;'
        ];

        return $baseStyle . ($colorStyles[$type] ?? $colorStyles['view']);
    }

    /**
     * Get enquiry summary for emails.
     */
    public function getEnquirySummary(Enquiry $enquiry): array
    {
        return [
            'enquiry_id' => $enquiry->id,
            'customer_name' => $enquiry->customer_name,
            'customer_email' => $enquiry->customer_email,
            'customer_phone' => $enquiry->customer_phone,
            'customer_company' => $enquiry->customer_company,
            'resource_name' => $enquiry->resource->name,
            'preferred_date' => $enquiry->preferred_date->format('l, F j, Y'),
            'preferred_time' => $this->getPreferredTimeDisplay($enquiry),
            'message' => $enquiry->message,
            'status' => ucfirst($enquiry->status),
            'created_at' => $enquiry->created_at->format('M j, Y g:i A'),
            'expires_at' => $enquiry->expires_at?->format('M j, Y g:i A')
        ];
    }

    /**
     * Get formatted preferred time display.
     */
    protected function getPreferredTimeDisplay(Enquiry $enquiry): ?string
    {
        if (!$enquiry->preferred_start_time || !$enquiry->preferred_end_time) {
            return null;
        }

        return $enquiry->preferred_start_time . ' - ' . $enquiry->preferred_end_time;
    }

    /**
     * Check if enquiry is urgent (expires soon).
     */
    public function isUrgent(Enquiry $enquiry): bool
    {
        if (!$enquiry->expires_at) {
            return false;
        }

        return $enquiry->expires_at->diffInDays(now()) <= config('enquiry.urgent_threshold_days', 3);
    }

    /**
     * Get email template data for enquiry.
     */
    public function getTemplateData(Enquiry $enquiry, array $additionalData = []): array
    {
        return array_merge([
            'enquiry' => $enquiry,
            'summary' => $this->getEnquirySummary($enquiry),
            'action_urls' => $this->generateActionUrls($enquiry),
            'calendar_buttons' => $this->generateCalendarButtons($enquiry),
            'outlook_url' => $this->generateOutlookCalendarUrl($enquiry),
            'google_url' => $this->generateGoogleCalendarUrl($enquiry),
            'is_urgent' => $this->isUrgent($enquiry),
            'business_name' => config('enquiry.business_name', config('app.name')),
            'business_email' => config('enquiry.owner_email'),
            'business_phone' => config('enquiry.business_phone'),
            'app_url' => config('app.url')
        ], $additionalData);
    }
}
