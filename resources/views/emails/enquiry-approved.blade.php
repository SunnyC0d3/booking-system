@extends('emails.layouts.enquiry-base')

@section('title', 'Great News! Your enquiry has been approved')

@section('content')
    <div style="background-color: #ecfdf5; padding: 25px; border-radius: 8px; margin-bottom: 30px; border-left: 4px solid #10b981;">
        <h2 style="color: #065f46; margin: 0 0 10px 0; font-size: 28px;">
            🎉 Congratulations!
        </h2>
        <p style="color: #047857; margin: 0; font-size: 18px; font-weight: 500;">
            Your enquiry has been approved and confirmed.
        </p>
    </div>

    <div style="background-color: #ffffff; border: 2px solid #10b981; border-radius: 8px; padding: 25px; margin-bottom: 30px;">
        <h3 style="color: #1f2937; margin: 0 0 20px 0; font-size: 20px;">✅ Confirmed Booking Details</h3>

        @include('emails.partials.enquiry-details')

        @if(isset($calendar_notes) && $calendar_notes)
            <div style="background-color: #f0fdf4; border-radius: 6px; padding: 15px; margin-top: 20px;">
                <h4 style="color: #166534; margin: 0 0 10px 0; font-size: 16px;">📝 Additional Notes:</h4>
                <p style="color: #15803d; margin: 0; line-height: 1.6;">
                    {{ $calendar_notes }}
                </p>
            </div>
        @endif
    </div>

    <div style="background-color: #f8fafc; border-radius: 8px; padding: 25px; margin-bottom: 30px; border-left: 4px solid #3b82f6;">
        <h3 style="color: #1e40af; margin: 0 0 20px 0; font-size: 18px;">📅 Add to Your Calendar</h3>
        <p style="color: #475569; margin: 0 0 20px 0;">
            Save this event to your calendar so you don't forget:
        </p>

        <div style="display: flex; gap: 15px; flex-wrap: wrap;">
            <a href="{{ $outlook_url }}"
               style="display: inline-block; padding: 12px 20px; background-color: #0078d4; color: white; text-decoration: none; border-radius: 6px; font-size: 14px; font-weight: 500;">
                📅 Add to Outlook
            </a>

            <a href="{{ $google_url }}"
               style="display: inline-block; padding: 12px 20px; background-color: #4285f4; color: white; text-decoration: none; border-radius: 6px; font-size: 14px; font-weight: 500;">
                📅 Add to Google Calendar
            </a>
        </div>
    </div>

    <div style="background-color: #fffbeb; border-radius: 8px; padding: 25px; margin-bottom: 30px;">
        <h3 style="color: #92400e; margin: 0 0 20px 0; font-size: 18px;">⚠️ Important Information</h3>

        <div style="color: #78350f; line-height: 1.6;">
            <p style="margin: 0 0 15px 0;">
                <strong>Please keep this confirmation email</strong> as your booking reference.
            </p>

            <p style="margin: 0 0 15px 0;">
                If you need to make any changes or have questions, please contact us as soon as possible:
            </p>

            <div style="background-color: #fef3c7; border-radius: 6px; padding: 15px; margin: 15px 0;">
                <p style="margin: 0 0 5px 0; font-weight: 500;">📧 Email: {{ $business_email }}</p>
                @if($business_phone)
                    <p style="margin: 0; font-weight: 500;">📞 Phone: {{ $business_phone }}</p>
                @endif
            </div>

            <p style="margin: 0;">
                <strong>Booking Reference:</strong> #{{ $summary['enquiry_id'] }}
            </p>
        </div>
    </div>

    @if($enquiry->message)
        <div style="background-color: #f1f5f9; border-left: 4px solid #64748b; border-radius: 4px; padding: 20px; margin-bottom: 30px;">
            <h4 style="color: #475569; margin: 0 0 10px 0; font-size: 16px;">Your original message:</h4>
            <p style="color: #64748b; font-style: italic; margin: 0; line-height: 1.6;">
                "{{ $enquiry->message }}"
            </p>
        </div>
    @endif

    <div style="background-color: #f3f4f6; border-radius: 8px; padding: 25px; margin-bottom: 30px;">
        <h4 style="color: #374151; margin: 0 0 15px 0; font-size: 16px;">🤝 What to Expect Next</h4>

        <div style="color: #6b7280; line-height: 1.6;">
            <p style="margin: 0 0 12px 0;">
                • We'll send you a reminder closer to your event date
            </p>
            <p style="margin: 0 0 12px 0;">
                • If you have any special requirements, please let us know in advance
            </p>
            <p style="margin: 0 0 12px 0;">
                • Contact us immediately if you need to make changes
            </p>
            <p style="margin: 0;">
                • We're here to ensure everything goes perfectly!
            </p>
        </div>
    </div>

    <div style="text-align: center; background-color: #ecfdf5; border-radius: 8px; padding: 30px; margin-top: 40px;">
        <h3 style="color: #065f46; margin: 0 0 15px 0; font-size: 20px;">
            We're excited to work with you!
        </h3>
        <p style="color: #047857; font-size: 16px; margin: 0 0 10px 0;">
            Thank you for choosing {{ $business_name }}
        </p>
        <p style="color: #10b981; font-size: 14px; margin: 0;">
            Your satisfaction is our top priority.
        </p>
    </div>

    <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; color: #9ca3af; font-size: 12px; text-align: center;">
        <p style="margin: 0;">
            Booking confirmed on {{ now()->format('M j, Y \a\t g:i A') }} • Reference: #{{ $summary['enquiry_id'] }}
        </p>
    </div>
@endsection
