<div style="background-color: #f8f9fa; border-radius: 6px; padding: 20px; margin: 15px 0;">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">

        <!-- Left Column -->
        <div>
            <h4 style="color: #374151; margin: 0 0 15px 0; font-size: 16px; font-weight: 600; border-bottom: 2px solid #e5e7eb; padding-bottom: 8px;">
                📋 Service Details
            </h4>

            <div style="margin-bottom: 12px;">
                <span style="color: #6b7280; font-size: 14px; font-weight: 500; display: block; margin-bottom: 4px;">Resource:</span>
                <span style="color: #1f2937; font-size: 16px; font-weight: 600;">{{ $summary['resource_name'] }}</span>
            </div>

            <div style="margin-bottom: 12px;">
                <span style="color: #6b7280; font-size: 14px; font-weight: 500; display: block; margin-bottom: 4px;">Preferred Date:</span>
                <span style="color: #1f2937; font-size: 16px;">{{ $summary['preferred_date'] }}</span>
            </div>

            @if($summary['preferred_time'])
                <div style="margin-bottom: 12px;">
                    <span style="color: #6b7280; font-size: 14px; font-weight: 500; display: block; margin-bottom: 4px;">Preferred Time:</span>
                    <span style="color: #1f2937; font-size: 16px;">{{ $summary['preferred_time'] }}</span>
                </div>
            @endif

            <div>
                <span style="color: #6b7280; font-size: 14px; font-weight: 500; display: block; margin-bottom: 4px;">Status:</span>
                <span style="display: inline-block; background-color:
                    @switch($enquiry->status)
                        @case('pending') #fef3c7; color: #92400e; @break
                        @case('approved') #d1fae5; color: #065f46; @break
                        @case('declined') #fee2e2; color: #991b1b; @break
                        @case('cancelled') #f3f4f6; color: #374151; @break
                        @default #f3f4f6; color: #374151;
                    @endswitch
                    padding: 4px 12px; border-radius: 20px; font-size: 14px; font-weight: 600;">
                    {{ $summary['status'] }}
                </span>
            </div>
        </div>

        <!-- Right Column -->
        <div>
            <h4 style="color: #374151; margin: 0 0 15px 0; font-size: 16px; font-weight: 600; border-bottom: 2px solid #e5e7eb; padding-bottom: 8px;">
                👤 Customer Information
            </h4>

            <div style="margin-bottom: 12px;">
                <span style="color: #6b7280; font-size: 14px; font-weight: 500; display: block; margin-bottom: 4px;">Name:</span>
                <span style="color: #1f2937; font-size: 16px;">{{ $summary['customer_name'] }}</span>
            </div>

            <div style="margin-bottom: 12px;">
                <span style="color: #6b7280; font-size: 14px; font-weight: 500; display: block; margin-bottom: 4px;">Email:</span>
                <a href="mailto:{{ $summary['customer_email'] }}" style="color: #3b82f6; text-decoration: none; font-size: 16px;">
                    {{ $summary['customer_email'] }}
                </a>
            </div>

            @if($summary['customer_phone'])
                <div style="margin-bottom: 12px;">
                    <span style="color: #6b7280; font-size: 14px; font-weight: 500; display: block; margin-bottom: 4px;">Phone:</span>
                    <a href="tel:{{ $summary['customer_phone'] }}" style="color: #3b82f6; text-decoration: none; font-size: 16px;">
                        {{ $summary['customer_phone'] }}
                    </a>
                </div>
            @endif

            @if($summary['customer_company'])
                <div>
                    <span style="color: #6b7280; font-size: 14px; font-weight: 500; display: block; margin-bottom: 4px;">Company:</span>
                    <span style="color: #1f2937; font-size: 16px;">{{ $summary['customer_company'] }}</span>
                </div>
            @endif
        </div>

    </div>

    <!-- Mobile-friendly stacked layout -->
    <style>
        @media only screen and (max-width: 600px) {
            [style*="display: grid"] {
                display: block !important;
            }

            [style*="grid-template-columns"] {
                grid-template-columns: none !important;
            }

            [style*="gap: 20px"] > div:first-child {
                margin-bottom: 25px !important;
            }
        }
    </style>

    <!-- Additional Details -->
    <div style="border-top: 1px solid #e5e7eb; padding-top: 15px; margin-top: 15px;">
        <div style="display: flex; justify-content: space-between; flex-wrap: wrap; gap: 15px; font-size: 14px; color: #6b7280;">
            <div>
                <span style="font-weight: 500;">Enquiry ID:</span> #{{ $summary['enquiry_id'] }}
            </div>
            <div>
                <span style="font-weight: 500;">Submitted:</span> {{ $summary['created_at'] }}
            </div>
            @if($summary['expires_at'])
                <div>
                    <span style="font-weight: 500;">Expires:</span> {{ $summary['expires_at'] }}
                </div>
            @endif
        </div>
    </div>
</div>
