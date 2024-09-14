<?php

declare(strict_types=1);

use App\Models\Action;
use App\Models\Service;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Gateway options
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default options that should be used
    | by the gateway.
    |
    */

    'options' => [
        // Keep "*" if you want to pass all headers
        'allowed_headers' => [
            'Accept',
            'Accept-Encoding',
            'Authorization',
            'Connection',
            'Content-Type',
            'Content-Length',
            'User-Agent',
            'X-Request-UUID',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Gateway entities JSON Schema
    |--------------------------------------------------------------------------
    |
    | Here you may specify paths to your json schemas.
    |
    */

    'schema' => [
        Action::class => storage_path('action_schema.json'),
        Service::class => storage_path('service_schema.json'),
    ],
];
