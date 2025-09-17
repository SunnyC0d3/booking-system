<?php

use Knuckles\Scribe\Config\AuthIn;

return [
    // HTML <title> for docs
    'title' => config('app.name') . ' API Documentation',

    // Short description
    'description' => 'API documentation for the Booking System.',

    // Base URL for API
    'base_url' => config('app.url'),

    // Routes to include
    'routes' => [
        [
            'match' => [
                'prefixes' => ['api/*'],
                'domains' => ['*'],
            ],
            'include' => [],
            'exclude' => [],
        ],
    ],

    // Documentation type
    'type' => 'laravel',

    // Theme
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
    ],

    // Auth configuration
    'auth' => [
        'enabled' => true,
        'default' => true,
        'in' => AuthIn::BEARER->value,
        'name' => 'Authorization',
        'use_value' => env('SCRIBE_AUTH_KEY'),
        'placeholder' => '{YOUR_BEARER_TOKEN}',
    ],

    // Example requests languages
    'example_languages' => ['bash', 'javascript'],

    // Postman & OpenAPI generation
    'postman' => ['enabled' => true],
    'openapi' => ['enabled' => true],

    // Default group for endpoints
    'groups' => [
        'default' => 'Booking System',
        'order' => [],
    ],

    // Last updated info
    'last_updated' => 'Last updated: {date:F j, Y}',

    // Faker seed for reproducible examples
    'examples' => ['faker_seed' => 1234],

    // Strategies for extracting info
    'strategies' => [
        'metadata' => [],
        'headers' => [],
        'urlParameters' => [],
        'queryParameters' => [],
        'bodyParameters' => [],
        'responses' => [],
        'responseFields' => [],
    ],

    // Database transactions for response calls
    'database_connections_to_transact' => [config('database.default')],
];
