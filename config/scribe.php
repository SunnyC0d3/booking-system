<?php

use Knuckles\Scribe\Config\AuthIn;

return [
    'title' => 'Booking System API Documentation',
    'description' => 'Complete API documentation for the Production-Ready Booking System. Manage resources, availability, and bookings with automated slot generation and intelligent conflict prevention.',
    'base_url' => config('app.url'),
    'routes' => [
        [
            'match' => [
                'prefixes' => ['api/v1/*'],
                'domains' => ['*'],
            ],
            'include' => [
                'api/v1/resources*',
                'api/v1/bookings*',
            ],
            'exclude' => [
                'api/v1/health',
                'api/v1/debug*',
            ],
        ],
    ],
    'type' => 'laravel',
    'theme' => 'default',
    'static' => [
        'output_path' => 'public/docs',
    ],
    'laravel' => [
        'add_routes' => true,
        'docs_url' => '/docs',
        'middleware' => [],
    ],
    'try_it_out' => [
        'enabled' => true,
        'base_url' => null,
        'use_csrf' => false,
    ],
    'auth' => [
        'enabled' => true,
        'default' => true,
        'in' => AuthIn::BEARER->value,
        'name' => 'Authorization',
        'use_value' => env('SCRIBE_AUTH_KEY', 'your_generated_sanctum_token_here'),
        'placeholder' => 'Bearer {YOUR_SANCTUM_TOKEN}',
        'extra_info' => 'Generate a token using: php artisan api-client:create "Your Name" "your.email@example.com"',
    ],
    'example_languages' => [
        'bash',
        'javascript',
        'php',
        'python',
    ],
    'postman' => [
        'enabled' => true,
        'title' => 'Booking System API',
        'description' => 'Postman collection for the Booking System API with all endpoints and examples.',
    ],

    'openapi' => [
        'enabled' => true,
        'title' => 'Booking System API',
        'description' => 'OpenAPI 3.0 specification for the Booking System API.',
        'version' => '1.0.0',
        'contact' => [
            'name' => 'API Support',
            'email' => 'api-support@example.com',
        ],
        'servers' => [
            [
                'url' => config('app.url'),
                'description' => 'Production Server',
            ],
        ],
    ],
    'groups' => [
        'default' => 'General',
        'order' => [
            'Authentication',
            'Resources',
            'Bookings',
            'General',
        ],
    ],
    'last_updated' => 'Last updated: {date:F j, Y \a\t g:i A T}',
    'examples' => [
        'faker_seed' => 1234,
        'models_source' => ['factoryCreate', 'databaseFirst'],
    ],
    'database_connections_to_transact' => [config('database.default')],
    'fractal' => [
        'serializer' => null,
    ],
    'intro_text' => <<<INTRO
# Welcome to the Booking System API

This API provides comprehensive booking management with automated availability generation and intelligent conflict prevention.

## Key Features

- **Resource Management**: List and query bookable resources
- **Flexible Availability**: Query availability by date, date range, or days ahead
- **Smart Booking**: Automatic conflict detection and capacity management
- **Holiday Support**: Built-in blackout date system for holidays and maintenance
- **Calendar Integration**: Frontend-ready responses for calendar components

## Getting Started

1. **Authentication**: All endpoints require a Sanctum Bearer token
2. **Generate Token**: Use `php artisan api-client:create` to create API credentials
3. **Base URL**: All endpoints are prefixed with `/api/v1`
4. **Rate Limiting**: 60 requests per minute per token

## Common Patterns

Most endpoints follow RESTful conventions with enhanced query capabilities:

- Single date queries: `?date=2025-09-18`
- Date range queries: `?from=2025-09-18&to=2025-09-25`
- Relative queries: `?days=7` (next 7 days from today)

INTRO,
];
