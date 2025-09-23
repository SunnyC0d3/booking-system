@extends('emails.layouts.enquiry-base')

@section('title', 'New Enquiry Received')

@section('content')
    <div style="background-color: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
        @if($is_urgent)
            <div style="background-color: #fef3c7; color: #92400e; padding: 12px; border-radius: 6px; margin-bottom: 20px; border-left: 4px solid #f59e0b;">
                <strong>⚠️ URGENT:</strong> This enquiry expires soon!
            </div>
        @endif

        <h2 style="color: #1f2937; margin: 0 0 10px 0; font-size: 24px;">
            New Enquiry: {{ $summary['resource_name'] }}
        </h2>
        <p style="color: #6b7280; margin: 0; font-size: 16px;">
            Enquiry #{{ $summary['enquiry_id'] }} • Received {{ $summary['created_at'] }}
        </p>
    </div>

    @include('emails.partials.enquiry-details')

    <div style="background-color: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 25px; margin: 30px 0;">
        <h3 style="color: #1f2937; margin: 0 0 20px 0; font-size: 18px;">Quick Actions</h3>

        {!! $calendar_buttons !!}

        <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
            <p style="color: #6b7280; font-size: 14px; margin: 0 0 15px 0;">
                <strong>💡 How it works:</strong>
            </p>
            <ul style="color: #6b7280; font-size: 14px; margin: 0; padding-left: 20px;">
                <li style="margin-bottom: 8px;">Click <strong>Approve</strong> to automatically add this event to your calendar</li>
                <li style="margin-bottom: 8px;">Click <strong>Decline</strong> to politely notify the customer</li>
                <li style="margin-bottom: 8px;">Any calendar changes will sync back to the system automatically</li>
            </ul>
        </div>
    </div>

    <div style="background-color: #f3f4f6; border-radius: 8px; padding: 20px; margin: 30px 0;">
        <h4 style="color: #374151; margin: 0 0 15px 0; font-size: 16px;">Alternative Calendar Options</h4>

        <div style="display: flex; gap: 15px; flex-wrap: wrap;">
            <a href="{{ $outlook_url }}"
               style="display: inline-block; padding: 10px 16px; background-color: #0078d4; color: white; text-decoration: none; border-radius: 4px; font-size: 14px;">
                📅 Add to Outlook
            </a>

            <a href="{{ $google_url }}"
               style="display: inline-block; padding: 10px 16px; background-color: #4285f4; color: white; text-decoration: none; border-radius: 4px; font-size: 14px;">
                📅 Add to Google Calendar
            </a>
        </div>
    </div>

    @if($enquiry->message)
        <div style="background-color: #fef9e7; border-left: 4px solid #f59e0b; padding: 20px; margin: 30px 0;">
            <h4 style="color: #92400e; margin: 0 0 15px 0; font-size: 16px;">💬 Customer Message</h4>
            <p style="color: #78350f; font-style: italic; margin: 0; line-height: 1.6;">
                "{{ $enquiry->message }}"
            </p>
        </div>
    @endif

    <div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #e5e7eb; color: #6b7280; font-size: 14px;">
        <p style="margin: 0 0 10px 0;">
            <strong>Customer Reply-To:</strong> {{ $summary['customer_email'] }}
        </p>
        @if($summary['customer_phone'])
            <p style="margin: 0 0 10px 0;">
                <strong>Phone:</strong> {{ $summary['customer_phone'] }}
            </p>
        @endif
        <p style="margin: 0;">
            <strong>Expires:</strong> {{ $summary['expires_at'] }}
        </p>
    </div>
@endsection
