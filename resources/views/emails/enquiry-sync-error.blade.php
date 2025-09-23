@extends('emails.layouts.enquiry-base')

@section('title', '[SYSTEM ERROR] Calendar Sync Failed')

@section('content')
    <div style="background-color: #fef2f2; padding: 25px; border-radius: 8px; margin-bottom: 30px; border-left: 4px solid #ef4444;">
        <h2 style="color: #991b1b; margin: 0 0 10px 0; font-size: 24px;">
            🚨 Calendar Sync Error
        </h2>
        <p style="color: #dc2626; margin: 0; font-size: 16px;">
            A calendar synchronization error has occurred and requires attention.
        </p>
    </div>

    <div style="background-color: #fff7ed; border-left: 4px solid #f97316; border-radius: 4px; padding: 20px; margin-bottom: 30px;">
        <h3 style="color: #ea580c; margin: 0 0 15px 0; font-size: 18px;">⚠️ Error Details</h3>
        <div style="background-color: #ffffff; border-radius: 6px; padding: 15px; border: 1px solid #fed7aa;">
            <pre style="color: #9a3412; font-family: 'Courier New', monospace; font-size: 13px; margin: 0; white-space: pre-wrap; word-break: break-all;">{{ $error }}</pre>
        </div>
    </div>

    <div style="background-color: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 25px; margin-bottom: 30px;">
        <h3 style="color: #1f2937; margin: 0 0 20px 0; font-size: 18px;">📋 Affected Enquiry</h3>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <p style="margin: 0 0 5px 0; color: #6b7280; font-size: 14px; font-weight: 500;">Enquiry ID:</p>
                <p style="margin: 0 0 15px 0; color: #1f2937; font-size: 16px;">#{{ $enquiry->id }}</p>

                <p style="margin: 0 0 5px 0; color: #6b7280; font-size: 14px; font-weight: 500;">Status:</p>
                <p style="margin: 0 0 15px 0; color: #1f2937; font-size: 16px;">{{ ucfirst($enquiry->status) }}</p>

                <p style="margin: 0 0 5px 0; color: #6b7280; font-size: 14px; font-weight: 500;">Resource:</p>
                <p style="margin: 0; color: #1f2937; font-size: 16px;">{{ $enquiry->resource->name }}</p>
            </div>

            <div>
                <p style="margin: 0 0 5px 0; color: #6b7280; font-size: 14px; font-weight: 500;">Customer:</p>
                <p style="margin: 0 0 15px 0; color: #1f2937; font-size: 16px;">{{ $enquiry->customer_name }}</p>

                <p style="margin: 0 0 5px 0; color: #6b7280; font-size: 14px; font-weight: 500;">Email:</p>
                <p style="margin: 0 0 15px 0; color: #1f2937; font-size: 16px;">{{ $enquiry->customer_email }}</p>

                <p style="margin: 0 0 5px 0; color: #6b7280; font-size: 14px; font-weight: 500;">Preferred Date:</p>
                <p style="margin: 0; color: #1f2937; font-size: 16px;">{{ $enquiry->preferred_date->format('l, F j, Y') }}</p>
            </div>
        </div>

        @if($enquiry->preferred_start_time && $enquiry->preferred_end_time)
            <div style="background-color: #f8fafc; border-radius: 6px; padding: 15px;">
                <p style="margin: 0 0 5px 0; color: #6b7280; font-size: 14px; font-weight: 500;">Preferred Time:</p>
                <p style="margin: 0; color: #1f2937; font-size: 16px;">{{ $enquiry->preferred_start_time }} - {{ $enquiry->preferred_end_time }}</p>
            </div>
        @endif
    </div>

    @if(!empty($context))
        <div style="background-color: #f8fafc; border-radius: 8px; padding: 20px; margin-bottom: 30px;">
            <h4 style="color: #374151; margin: 0 0 15px 0; font-size: 16px;">🔍 Additional Context</h4>

            @foreach($context as $key => $value)
                <div style="margin-bottom: 12px;">
                    <span style="color: #6b7280; font-size: 14px; font-weight: 500;">{{ ucfirst(str_replace('_', ' ', $key)) }}:</span>
                    <span style="color: #374151; font-size: 14px; margin-left: 10px;">
                        @if(is_array($value))
                            {{ json_encode($value, JSON_PRETTY_PRINT) }}
                        @else
                            {{ $value }}
                        @endif
                    </span>
                </div>
            @endforeach
        </div>
    @endif

    <div style="background-color: #fffbeb; border-radius: 8px; padding: 25px; margin-bottom: 30px;">
        <h3 style="color: #92400e; margin: 0 0 20px 0; font-size: 18px;">🔧 Recommended Actions</h3>

        <div style="color: #78350f; line-height: 1.6;">
            <div style="display: flex; align-items: flex-start; margin-bottom: 15px;">
                <span style="background-color: #f59e0b; color: white; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: bold; margin-right: 12px; flex-shrink: 0;">1</span>
                <div>
                    <strong>Check Microsoft 365 Authentication</strong><br>
                    <span style="font-size: 14px; color: #a16207;">Verify that the OAuth tokens are valid and haven't expired</span>
                </div>
            </div>

            <div style="display: flex; align-items: flex-start; margin-bottom: 15px;">
                <span style="background-color: #f59e0b; color: white; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: bold; margin-right: 12px; flex-shrink: 0;">2</span>
                <div>
                    <strong>Test API Connectivity</strong><br>
                    <span style="font-size: 14px; color: #a16207;">Run: <code>php artisan enquiry:test-microsoft</code></span>
                </div>
            </div>

            <div style="display: flex; align-items: flex-start; margin-bottom: 15px;">
                <span style="background-color: #f59e0b; color: white; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: bold; margin-right: 12px; flex-shrink: 0;">3</span>
                <div>
                    <strong>Retry the Sync</strong><br>
                    <span style="font-size: 14px; color: #a16207;">Run: <code>php artisan enquiry:sync-calendar --enquiry={{ $enquiry->id }}</code></span>
                </div>
            </div>

            <div style="display: flex; align-items: flex-start;">
                <span style="background-color: #f59e0b; color: white; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: bold; margin-right: 12px; flex-shrink: 0;">4</span>
                <div>
                    <strong>Check System Logs</strong><br>
                    <span style="font-size: 14px; color: #a16207;">Review application logs for additional error details</span>
                </div>
            </div>
        </div>
    </div>

    <div style="background-color: #f3f4f6; border-radius: 8px; padding: 20px; margin-bottom: 30px;">
        <h4 style="color: #374151; margin: 0 0 15px 0; font-size: 16px;">🏃‍♂️ Quick Actions</h4>

        <div style="display: flex; gap: 15px; flex-wrap: wrap;">
            <a href="{{ $app_url }}/api/v1/enquiries/{{ $enquiry->id }}"
               style="display: inline-block; padding: 10px 16px; background-color: #3b82f6; color: white; text-decoration: none; border-radius: 4px; font-size: 14px;">
                📋 View Enquiry
            </a>

            <a href="{{ $app_url }}/api/v1/auth/microsoft/status"
               style="display: inline-block; padding: 10px 16px; background-color: #10b981; color: white; text-decoration: none; border-radius: 4px; font-size: 14px;">
                🔐 Check Auth Status
            </a>
        </div>
    </div>

    <div style="background-color: #fef3c7; border-left: 4px solid #f59e0b; border-radius: 4px; padding: 20px; margin-bottom: 30px;">
        <h4 style="color: #92400e; margin: 0 0 10px 0; font-size: 16px;">⏰ Time Sensitive</h4>
        <p style="color: #78350f; margin: 0; line-height: 1.6;">
            If this enquiry was recently approved by the customer, they may be expecting calendar confirmation.
            Consider manually creating the calendar event or contacting the customer while troubleshooting.
        </p>
    </div>

    <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; color: #6b7280; font-size: 14px;">
        <p style="margin: 0 0 10px 0;">
            <strong>System:</strong> {{ $business_name ?? config('app.name') }}
        </p>
        <p style="margin: 0 0 10px 0;">
            <strong>Timestamp:</strong> {{ $timestamp }}
        </p>
        <p style="margin: 0 0 10px 0;">
            <strong>Environment:</strong> {{ config('app.env') }}
        </p>
        <p style="margin: 0;">
            <strong>Error ID:</strong> {{ $enquiry->id }}-{{ now()->format('YmdHis') }}
        </p>
    </div>
@endsection
