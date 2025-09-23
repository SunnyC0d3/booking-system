<div style="text-align: center;">
    <h3 style="color: #374151; margin: 0 0 20px 0; font-size: 18px; font-weight: 600;">
        {{ $business_name ?? config('app.name') }}
    </h3>

    <div style="margin-bottom: 20px;">
        @if(isset($business_email))
            <p style="margin: 0 0 8px 0; color: #6b7280;">
                <strong>📧 Email:</strong>
                <a href="mailto:{{ $business_email }}" style="color: #3b82f6; text-decoration: none;">
                    {{ $business_email }}
                </a>
            </p>
        @endif

        @if(isset($business_phone) && $business_phone)
            <p style="margin: 0 0 8px 0; color: #6b7280;">
                <strong>📞 Phone:</strong>
                <a href="tel:{{ $business_phone }}" style="color: #3b82f6; text-decoration: none;">
                    {{ $business_phone }}
                </a>
            </p>
        @endif

        @if(isset($app_url))
            <p style="margin: 0; color: #6b7280;">
                <strong>🌐 Website:</strong>
                <a href="{{ $app_url }}" style="color: #3b82f6; text-decoration: none;">
                    {{ str_replace(['http://', 'https://'], '', $app_url) }}
                </a>
            </p>
        @endif
    </div>

    <div style="border-top: 1px solid #d1d5db; padding-top: 20px; margin-top: 20px;">
        <p style="margin: 0 0 10px 0; color: #9ca3af; font-size: 12px; line-height: 1.4;">
            You received this email because you submitted an enquiry through our booking system.
        </p>

        <p style="margin: 0; color: #d1d5db; font-size: 11px;">
            This is an automated message from our enquiry management system.
            <br>
            Please do not reply to automated system emails unless specifically requested.
        </p>
    </div>

    @if(config('app.env') !== 'production')
        <div style="background-color: #fef3c7; border-radius: 4px; padding: 10px; margin-top: 15px;">
            <p style="margin: 0; color: #92400e; font-size: 11px; font-weight: 600;">
                🚧 {{ strtoupper(config('app.env')) }} ENVIRONMENT
                <br>
                <span style="font-weight: normal;">This email was sent from a {{ config('app.env') }} environment</span>
            </p>
        </div>
    @endif
</div>
