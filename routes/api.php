<?php

use App\Http\Controllers\Api\Internal\v1\ActionController;
use App\Http\Controllers\Api\Internal\v1\SchemaController;
use App\Http\Controllers\Api\Internal\v1\ServiceController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'internal/v1'], function () {
    Route::apiResource('actions', ActionController::class);
    Route::apiResource('services', ServiceController::class);

    Route::group(['prefix' => 'schema'], function () {
        Route::get('actions', [SchemaController::class, 'introspectActionSchema']);
        Route::get('services', [SchemaController::class, 'introspectServiceSchema']);
    });
});
