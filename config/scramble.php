<?php

return [
    'api_path' => 'api/v1',

    'info' => [
        'title' => 'Booking System API',
        'version' => '1.0.0',
    ],

    'servers' => [
        [
            'url' => config('app.url'),
            'description' => 'Local server',
        ],
    ],
];
