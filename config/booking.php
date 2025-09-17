<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Slot Duration
    |--------------------------------------------------------------------------
    |
    | Default time slot duration in minutes for availability generation
    |
    */
    'default_slot_duration' => 60,

    /*
    |--------------------------------------------------------------------------
    | Advance Booking Limits
    |--------------------------------------------------------------------------
    |
    | How far in advance users can book (in days)
    |
    */
    'max_advance_booking_days' => 365,
    'min_advance_booking_hours' => 2,

    /*
    |--------------------------------------------------------------------------
    | Availability Generation
    |--------------------------------------------------------------------------
    |
    | Settings for automatic availability slot generation
    |
    */
    'generate_slots_for_days_ahead' => 90,
    'cleanup_expired_slots_after_days' => 30,

    /*
    |--------------------------------------------------------------------------
    | Business Hours
    |--------------------------------------------------------------------------
    |
    | Default business hours if not specified in resource availability_rules
    |
    */
    'default_business_hours' => [
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
    | Weekend Settings
    |--------------------------------------------------------------------------
    |
    | Should availability be generated for weekends by default
    |
    */
    'generate_weekend_slots' => false,

    /*
    |--------------------------------------------------------------------------
    | Time Zone
    |--------------------------------------------------------------------------
    |
    | Default timezone for booking operations
    |
    */
    'timezone' => env('APP_TIMEZONE', 'UTC'),
];
