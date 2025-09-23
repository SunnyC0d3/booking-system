@extends('emails.layouts.enquiry-base')

@section('title', 'Update on your enquiry')

@section('content')
    <div style="background-color: #fef2f2; padding: 25px; border-radius: 8px; margin-bottom: 30px; border-left: 4px solid #f87171;">
        <h2 style="color: #991b1b; margin: 0 0 10px 0; font-size: 24px;">
            Update on Your Enquiry
        </h2>
        <p style="color: #dc2626; margin: 0; font-size: 16px;">
            We're unable to accommodate your request for the dates you specified.
        </p>
    </div>

    <div style="background-color: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 25px; margin-bottom: 30px;">
        <h3 style="color: #1f2937; margin: 0 0 20px 0; font-size: 18px;">Your Original Request</h3>

        @include('emails.partials.enquiry-details')
    </div>

    @if(isset($decline_reason) && $decline_reason)
        <div style="background-color: #fffbeb; border-left: 4px solid #f59e0b; border-radius: 4px; padding: 20px; margin-bottom: 30px;">
            <h4 style="color: #92400e; margin: 0 0 10px 0; font-size: 16px;">Reason:</h4>
            <p style="color: #78350f; margin: 0; line-height: 1.6;">
                {{ $decline_reason }}
            </p>
        </div>
    @endif

    @if(isset($custom_message) && $custom_message)
        <div style="background-color: #f0f9ff; border-left: 4px solid #3b82f6; border-radius: 4px; padding: 20px; margin-bottom: 30px;">
            <h4 style="color: #1e40af; margin: 0 0 10px 0; font-size: 16px;">Message from {{ $business_name }}:</h4>
            <p style="color: #1d4ed8; margin: 0; line-height: 1.6;">
                {{ $custom_message }}
            </p>
        </div>
    @endif

    <div style="background-color: #f8fafc; border-radius: 8px; padding: 25px; margin-bottom: 30px;">
        <h3 style="color: #1f2937; margin: 0 0 20px 0; font-size: 18px;">💡 We'd Still Love to Help!</h3>

        <div style="color: #475569; line-height: 1.6;">
            <p style="margin: 0 0 15px 0;">
                While we can't accommodate your original request, we may have alternative options available:
            </p>

            <ul style="margin: 0 0 20px 0; padding-left: 20px;">
                <li style="margin-bottom: 8px;">Different dates that might work for you</li>
                <li style="margin-bottom: 8px;">Alternative resources or services</li>
                <li style="margin-bottom: 8px;">Modified arrangements to meet your needs</li>
                <li>Recommendations for other providers if we can't help</li>
            </ul>

            <p style="margin: 0;">
                Please don't hesitate to reach out to discuss other possibilities!
            </p>
        </div>
    </div>

    <div style="background-color: #ecfdf5; border-radius: 8px; padding: 25px; margin-bottom: 30px; text-align: center;">
        <h3 style="color: #065f46; margin: 0 0 15px 0; font-size: 18px;">🤝 Get in Touch</h3>
        <p style="color: #047857; margin: 0 0 20px 0; font-size: 16px;">
            We're here to help find a solution that works for you.
        </p>

        <div style="background-color: #ffffff; border-radius: 6px; padding: 20px; display: inline-block; margin-bottom: 20px;">
            <p style="margin: 0 0 10px 0; color: #065f46; font-weight: 500;">
                📧 Email: <a href="mailto:{{ $business_email }}" style="color: #059669; text-decoration: none;">{{ $business_email }}</a>
            </p>
            @if($business_phone)
                <p style="margin: 0; color: #065f46; font-weight: 500;">
                    📞 Phone: <a href="tel:{{ $business_phone }}" style="color: #059669; text-decoration: none;">{{ $business_phone }}</a>
                </p>
            @endif
        </div>

        <p style="color: #10b981; font-size: 14px; margin: 0;">
            Simply reply to this email or give us a call to explore other options.
        </p>
    </div>

    @if($enquiry->message)
        <div style="background-color: #f1f5f9; border-left: 4px solid #64748b; border-radius: 4px; padding: 20px; margin-bottom: 30px;">
            <h4 style="color: #475569; margin: 0 0 10px 0; font-size: 16px;">Your original message:</h4>
            <p style="color: #64748b; font-style: italic; margin: 0; line-height: 1.6;">
                "{{ $enquiry->message }}"
            </p>
        </div>
    @endif

    <div style="background-color: #f3f4f6; border-radius: 8px; padding: 20px; margin-bottom: 30px;">
        <h4 style="color: #374151; margin: 0 0 15px 0; font-size: 16px;">Why This Happened</h4>
        <div style="color: #6b7280; font-size: 14px; line-height: 1.6;">
            <p style="margin: 0 0 10px 0;">
                We carefully review every enquiry to ensure we can provide the best possible service. Sometimes we need to decline requests due to:
            </p>
            <ul style="margin: 0; padding-left: 20px;">
                <li style="margin-bottom: 5px;">Existing bookings or commitments</li>
                <li style="margin-bottom: 5px;">Maintenance or setup requirements</li>
                <li style="margin-bottom: 5px;">Resource limitations</li>
                <li>Scheduling conflicts</li>
            </ul>
        </div>
    </div>

    <div style="text-align: center; background-color: #fafafa; border-radius: 8px; padding: 25px; margin-top: 40px;">
        <h3 style="color: #374151; margin: 0 0 15px 0; font-size: 18px;">
            Thank You for Your Understanding
        </h3>
        <p style="color: #6b7280; font-size: 16px; margin: 0 0 10px 0;">
            We appreciate you considering {{ $business_name }}
        </p>
        <p style="color: #9ca3af; font-size: 14px; margin: 0;">
            We hope to have the opportunity to serve you in the future.
        </p>
    </div>

    <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; color: #9ca3af; font-size: 12px; text-align: center;">
        <p style="margin: 0;">
            Enquiry #{{ $summary['enquiry_id'] }} • Processed on {{ now()->format('M j, Y \a\t g:i A') }}
        </p>
    </div>
@endsection
