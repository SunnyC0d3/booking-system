@extends('emails.layouts.enquiry-base')

@section('title', 'Enquiry Received - Thank You!')

@section('content')
    <div style="background-color: #ecfdf5; padding: 25px; border-radius: 8px; margin-bottom: 30px; border-left: 4px solid #10b981;">
        <h2 style="color: #065f46; margin: 0 0 10px 0; font-size: 24px;">
            ✅ Thank you for your enquiry!
        </h2>
        <p style="color: #047857; margin: 0; font-size: 16px;">
            We've received your request and will get back to you soon.
        </p>
    </div>

    <div style="background-color: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 25px; margin-bottom: 30px;">
        <h3 style="color: #1f2937; margin: 0 0 20px 0; font-size: 20px;">Your Enquiry Details</h3>

        @include('emails.partials.enquiry-details')
    </div>

    <div style="background-color: #f8f9fa; border-radius: 8px; padding: 25px; margin-bottom: 30px;">
        <h3 style="color: #1f2937; margin: 0 0 20px 0; font-size: 18px;">What happens next?</h3>

        <div style="display: flex; align-items: flex-start; margin-bottom: 20px;">
            <div style="background-color: #3b82f6; color: white; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: bold; margin-right: 15px; flex-shrink: 0;">
                1
            </div>
            <div>
                <h4 style="color: #1f2937; margin: 0 0 5px 0; font-size: 16px;">We'll review your request</h4>
                <p style="color: #6b7280; margin: 0; font-size: 14px;">
                    Our team will check availability and review your requirements.
                </p>
            </div>
        </div>

        <div style="display: flex; align-items: flex-start; margin-bottom: 20px;">
            <div style="background-color: #10b981; color: white; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: bold; margin-right: 15px; flex-shrink: 0;">
                2
            </div>
            <div>
                <h4 style="color: #1f2937; margin: 0 0 5px 0; font-size: 16px;">You'll receive confirmation</h4>
                <p style="color: #6b7280; margin: 0; font-size: 14px;">
                    We'll email you within 24 hours to confirm or discuss alternative options.
                </p>
            </div>
        </div>

        <div style="display: flex; align-items: flex-start;">
            <div style="background-color: #8b5cf6; color: white; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: bold; margin-right: 15px; flex-shrink: 0;">
                3
            </div>
            <div>
                <h4 style="color: #1f2937; margin: 0 0 5px 0; font-size: 16px;">We'll finalize the details</h4>
                <p style="color: #6b7280; margin: 0; font-size: 14px;">
                    Once confirmed, we'll provide you with all the information you need.
                </p>
            </div>
        </div>
    </div>

    @if($enquiry->message)
        <div style="background-color: #fef3c7; border-left: 4px solid #f59e0b; border-radius: 4px; padding: 20px; margin-bottom: 30px;">
            <h4 style="color: #92400e; margin: 0 0 10px 0; font-size: 16px;">Your message to us:</h4>
            <p style="color: #78350f; font-style: italic; margin: 0; line-height: 1.6;">
                "{{ $enquiry->message }}"
            </p>
        </div>
    @endif

    <div style="background-color: #f3f4f6; border-radius: 8px; padding: 20px; margin-bottom: 30px;">
        <h4 style="color: #374151; margin: 0 0 15px 0; font-size: 16px;">Need to make changes or have questions?</h4>
        <p style="color: #6b7280; margin: 0 0 15px 0; line-height: 1.6;">
            If you need to modify your enquiry or have any questions, please reply to this email or contact us directly:
        </p>
        <div style="color: #374151;">
            <p style="margin: 0 0 5px 0;">
                <strong>📧 Email:</strong> {{ $business_email }}
            </p>
            @if($business_phone)
                <p style="margin: 0;">
                    <strong>📞 Phone:</strong> {{ $business_phone }}
                </p>
            @endif
        </div>
    </div>

    <div style="background-color: #dbeafe; border-radius: 8px; padding: 20px; margin-bottom: 30px;">
        <h4 style="color: #1e40af; margin: 0 0 10px 0; font-size: 16px;">📋 Reference Information</h4>
        <div style="color: #1e40af; font-size: 14px;">
            <p style="margin: 0 0 5px 0;"><strong>Enquiry ID:</strong> #{{ $summary['enquiry_id'] }}</p>
            <p style="margin: 0 0 5px 0;"><strong>Submitted:</strong> {{ $summary['created_at'] }}</p>
            <p style="margin: 0;"><strong>Valid Until:</strong> {{ $summary['expires_at'] }}</p>
        </div>
    </div>

    <div style="text-align: center; margin-top: 40px;">
        <p style="color: #6b7280; font-size: 16px; margin: 0 0 20px 0;">
            Thank you for choosing {{ $business_name }}!
        </p>
        <p style="color: #9ca3af; font-size: 14px; margin: 0;">
            We appreciate your business and look forward to working with you.
        </p>
    </div>
@endsection
