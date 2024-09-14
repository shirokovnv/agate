<?php

declare(strict_types=1);

use App\Http\Controllers\GatewayController;
use App\Http\Middleware\ForceJsonMiddleware;
use App\Http\Middleware\ForwardHeadersMiddleware;
use App\Http\Middleware\RequestUuidMiddleware;
use Illuminate\Support\Facades\Route;

Route::any('/{any}', [GatewayController::class, 'handle'])
    ->middleware([
        ForceJsonMiddleware::class,
        RequestUuidMiddleware::class,
        ForwardHeadersMiddleware::class,
    ])
    ->where('any', '.*');
