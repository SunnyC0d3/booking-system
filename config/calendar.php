<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Calendar Event Settings
    |--------------------------------------------------------------------------
    |
    | Default settings for calendar events created from enquiries.
    |
    */

    'default_event_duration_hours' => 2,
    'default_start_time' => '09:00',
    'default_reminder_minutes' => 15,
    'timezone' => env('APP_TIMEZONE', 'UTC'),

    /*
    |--------------------------------------------------------------------------
    | Event Templates
    |--------------------------------------------------------------------------
    |
    | Templates for generating calendar event content.
    |
    */

    'subject_template' => '{resource} - {customer}',
    'location_template' => '{resource}',

    'body_template' => [
        'customer_details' => true,
        'enquiry_message' => true,
        'contact_info' => true,
        'enquiry_id' => true,
        'custom_footer' => null,
    ],

    /*
    |--------------------------------------------------------------------------
    | Calendar Provider URLs
    |--------------------------------------------------------------------------
    |
    | Base URLs for different calendar providers.
    |
    */

    'providers' => [
        'outlook' => 'https://outlook.live.com/calendar/0/deeplink/compose',
        'google' => 'https://calendar.google.com/calendar/render',
        'office365' => 'https://outlook.office.com/calendar/0/deeplink/compose',
    ],

    /*
    |--------------------------------------------------------------------------
    | Event Categories and Colors
    |--------------------------------------------------------------------------
    |
    | Color coding for different types of enquiries.
    |
    */

    'event_colors' => [
        'pending' => 'yellow',
        'approved' => 'green',
        'declined' => 'red',
        'cancelled' => 'gray',
    ],

    /*
    |--------------------------------------------------------------------------
    | Sync Behavior
    |--------------------------------------------------------------------------
    |
    | Settings for calendar synchronization behavior.
    |
    */

    'auto_sync_approved' => true,
    'auto_delete_declined' => true,
    'sync_status_changes' => true,
    'preserve_manual_changes' => false,

    /*
    |--------------------------------------------------------------------------
    | Working Hours
    |--------------------------------------------------------------------------
    |
    | Default working hours for event scheduling.
    |
    */

    'working_hours' => [
        'start' => '09:00',
        'end' => '17:00',
        'working_days' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Time Formatting
    |--------------------------------------------------------------------------
    |
    | Settings for time display and formatting.
    |
    */

    'time_format' => 'H:i',
    'date_format' => 'Y-m-d',
    'datetime_format' => 'Y-m-d H:i:s',
    'display_timezone' => true,

];
