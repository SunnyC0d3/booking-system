<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ResourceController;
use App\Http\Controllers\Api\V1\BookingController;

Route::prefix('v1')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get('/resources', [ResourceController::class, 'index']);
        Route::get('/resources/{resource}/availability', [ResourceController::class, 'availability']);

        Route::post('/bookings', [BookingController::class, 'store']);
        Route::get('/bookings/{booking}', [BookingController::class, 'show']);
        Route::put('/bookings/{booking}', [BookingController::class, 'update']);
        Route::delete('/bookings/{booking}', [BookingController::class, 'destroy']);
    });
