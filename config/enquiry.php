<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Business Information
    |--------------------------------------------------------------------------
    |
    | Basic business information used in emails and communications.
    |
    */

    'business_name' => env('ENQUIRY_BUSINESS_NAME', env('APP_NAME')),
    'owner_email' => env('ENQUIRY_OWNER_EMAIL'),
    'from_email' => env('ENQUIRY_FROM_EMAIL', env('MAIL_FROM_ADDRESS')),
    'admin_email' => env('ENQUIRY_ADMIN_EMAIL', env('ENQUIRY_OWNER_EMAIL')),
    'business_phone' => env('ENQUIRY_BUSINESS_PHONE'),

    /*
    |--------------------------------------------------------------------------
    | Enquiry Management
    |--------------------------------------------------------------------------
    |
    | Settings for enquiry lifecycle and expiration.
    |
    */

    'default_expiry_days' => 30,
    'urgent_threshold_days' => 3,
    'minimum_advance_hours' => 24,

    /*
    |--------------------------------------------------------------------------
    | Email Configuration
    |--------------------------------------------------------------------------
    |
    | Settings for enquiry email notifications and templates.
    |
    */

    'validate_business_hours' => false,
    'business_hours' => [
        'monday' => ['09:00-17:00'],
        'tuesday' => ['09:00-17:00'],
        'wednesday' => ['09:00-17:00'],
        'thursday' => ['09:00-17:00'],
        'friday' => ['09:00-17:00'],
        'saturday' => [],
        'sunday' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Calendar Integration
    |--------------------------------------------------------------------------
    |
    | Settings for Microsoft 365 calendar integration.
    |
    */

    'add_customer_as_attendee' => false,
    'default_reminder_minutes' => 15,
    'event_subject_template' => '{resource} - {customer}',

    /*
    |--------------------------------------------------------------------------
    | Synchronization Settings
    |--------------------------------------------------------------------------
    |
    | Settings for calendar synchronization and maintenance.
    |
    */

    'sync_log_retention_days' => 30,
    'max_sync_retries' => 3,
    'sync_retry_delay_minutes' => 15,

    /*
    |--------------------------------------------------------------------------
    | Cleanup and Maintenance
    |--------------------------------------------------------------------------
    |
    | Settings for automated cleanup and maintenance tasks.
    |
    */

    'cleanup_expired_enquiries' => true,
    'cleanup_old_sync_logs' => true,
    'maintenance_schedule' => 'daily', // daily, weekly, or manual

];
