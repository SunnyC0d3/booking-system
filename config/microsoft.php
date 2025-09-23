<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Microsoft 365 OAuth Configuration
    |--------------------------------------------------------------------------
    |
    | These settings configure the OAuth2 authentication flow with Microsoft
    | Graph API for calendar integration.
    |
    */

    'client_id' => env('MICROSOFT_CLIENT_ID'),
    'client_secret' => env('MICROSOFT_CLIENT_SECRET'),
    'tenant_id' => env('MICROSOFT_TENANT_ID', 'common'),
    'redirect_uri' => env('MICROSOFT_REDIRECT_URI', env('APP_URL') . '/api/v1/auth/microsoft/callback'),

    /*
    |--------------------------------------------------------------------------
    | Microsoft Graph API Scopes
    |--------------------------------------------------------------------------
    |
    | Required permissions for calendar integration functionality.
    |
    */

    'scopes' => [
        'https://graph.microsoft.com/Calendars.ReadWrite',
        'https://graph.microsoft.com/offline_access',
    ],

    /*
    |--------------------------------------------------------------------------
    | Webhook Configuration
    |--------------------------------------------------------------------------
    |
    | Settings for Microsoft Graph API webhook subscriptions.
    |
    */

    'webhook_secret' => env('MICROSOFT_WEBHOOK_SECRET'),
    'webhook_url' => env('APP_URL') . '/api/v1/webhooks/microsoft',

    /*
    |--------------------------------------------------------------------------
    | API Configuration
    |--------------------------------------------------------------------------
    |
    | Settings for Microsoft Graph API requests.
    |
    */

    'graph_api_url' => 'https://graph.microsoft.com/v1.0',
    'login_url' => 'https://login.microsoftonline.com',

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    |
    | Microsoft Graph API rate limiting configuration.
    |
    */

    'rate_limit' => [
        'requests_per_second' => 5,
        'burst_limit' => 20,
        'retry_after_seconds' => 60,
    ],

    /*
    |--------------------------------------------------------------------------
    | Token Management
    |--------------------------------------------------------------------------
    |
    | Settings for managing OAuth tokens.
    |
    */

    'token_refresh_buffer_minutes' => 5, // Refresh tokens 5 minutes before expiry
    'token_cleanup_days' => 30, // Clean up expired tokens after 30 days

    /*
    |--------------------------------------------------------------------------
    | Webhook Subscription Management
    |--------------------------------------------------------------------------
    |
    | Settings for managing webhook subscriptions.
    |
    */

    'subscription_renewal_hours' => 24, // Renew subscriptions 24 hours before expiry
    'max_subscription_days' => 3, // Maximum subscription duration (Microsoft limit)

];
