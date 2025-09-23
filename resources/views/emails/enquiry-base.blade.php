<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title') - {{ $business_name ?? config('app.name') }}</title>

    <!-- Email-safe CSS -->
    <style type="text/css">
        body, table, td, p, h1, h2, h3, h4, h5, h6 {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: #f9fafb;
            color: #374151;
            line-height: 1.6;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }

        .header {
            background-color: #1f2937;
            color: #ffffff;
            padding: 30px 40px;
            text-align: center;
        }

        .content {
            padding: 40px;
        }

        .footer {
            background-color: #f3f4f6;
            color: #6b7280;
            padding: 30px 40px;
            text-align: center;
            font-size: 14px;
        }

        @media only screen and (max-width: 600px) {
            .email-container {
                width: 100% !important;
            }

            .header,
            .content,
            .footer {
                padding: 20px !important;
            }
        }
    </style>
</head>

<body style="margin: 0; padding: 0; background-color: #f9fafb;">
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f9fafb;">
    <tr>
        <td align="center" style="padding: 20px 0;">

            <!-- Email Container -->
            <table class="email-container" width="600" cellpadding="0" cellspacing="0" border="0" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">

                <!-- Header -->
                <tr>
                    <td class="header" style="background-color: #1f2937; color: #ffffff; padding: 30px 40px; text-align: center; border-radius: 8px 8px 0 0;">
                        <h1 style="margin: 0 0 10px 0; font-size: 28px; font-weight: 700; line-height: 1.2;">
                            {{ $business_name ?? config('app.name') }}
                        </h1>
                        <p style="margin: 0; font-size: 16px; color: #d1d5db;">
                            @yield('title')
                        </p>
                    </td>
                </tr>

                <!-- Main Content -->
                <tr>
                    <td class="content" style="padding: 40px;">
                        @yield('content')
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td class="footer" style="background-color: #f3f4f6; color: #6b7280; padding: 30px 40px; text-align: center; font-size: 14px; border-radius: 0 0 8px 8px;">
                        @include('emails.partials.business-footer')
                    </td>
                </tr>

            </table>

            <!-- Email Footer -->
            <table width="600" cellpadding="0" cellspacing="0" border="0" style="margin-top: 20px;">
                <tr>
                    <td style="text-align: center; color: #9ca3af; font-size: 12px; line-height: 1.4;">
                        <p style="margin: 0 0 10px 0;">
                            This email was sent by {{ $business_name ?? config('app.name') }}
                        </p>
                        @if(isset($business_email))
                            <p style="margin: 0 0 10px 0;">
                                Questions? Reply to this email or contact us at {{ $business_email }}
                            </p>
                        @endif
                        <p style="margin: 0; color: #d1d5db;">
                            © {{ date('Y') }} {{ $business_name ?? config('app.name') }}. All rights reserved.
                        </p>
                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>
</body>
</html>
