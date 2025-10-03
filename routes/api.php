<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ResourceController;
use App\Http\Controllers\Api\V1\BookingController;
use App\Http\Controllers\Api\V1\EnquiryController;
use App\Http\Controllers\Api\V1\EnquiryActionController;
use App\Http\Controllers\Api\V1\CalendarAuthController;
use App\Http\Controllers\Api\V1\CalendarWebhookController;

Route::prefix('v1')->group(function () {

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/resources', [ResourceController::class, 'index'])->name('api.v1.resources.index');
        Route::get('/resources/{resource}/availability', [ResourceController::class, 'availability'])->name('api.v1.resources.availability');

        Route::post('/bookings', [BookingController::class, 'store'])->name('api.v1.bookings.store');
        Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('api.v1.bookings.show');
        Route::put('/bookings/{booking}', [BookingController::class, 'update'])->name('api.v1.bookings.update');
        Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('api.v1.bookings.destroy');
    });

    Route::post('enquiries', [EnquiryController::class, 'store'])->name('api.v1.enquiries.store');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('enquiries', [EnquiryController::class, 'index'])->name('api.v1.enquiries.index');
        Route::get('enquiries/statistics', [EnquiryController::class, 'statistics'])->name('api.v1.enquiries.statistics');
        Route::get('enquiries/search', [EnquiryController::class, 'search'])->name('api.v1.enquiries.search');
        Route::get('enquiries/{enquiry}', [EnquiryController::class, 'show'])->name('api.v1.enquiries.show');
        Route::put('enquiries/{enquiry}', [EnquiryController::class, 'update'])->name('api.v1.enquiries.update');
        Route::delete('enquiries/{enquiry}', [EnquiryController::class, 'destroy'])->name('api.v1.enquiries.destroy');

        Route::post('enquiries/{enquiry}/approve', [EnquiryActionController::class, 'approve'])->name('api.v1.enquiries.approve');
        Route::post('enquiries/{enquiry}/decline', [EnquiryActionController::class, 'decline'])->name('api.v1.enquiries.decline');
        Route::post('enquiries/{enquiry}/cancel', [EnquiryActionController::class, 'cancel'])->name('api.v1.enquiries.cancel');
    });

    Route::middleware('enquiry.token')->group(function () {
        Route::get('enquiries/actions/{token}/approve', [EnquiryActionController::class, 'handleTokenAction'])
            ->defaults('action', 'approve')
            ->name('api.v1.enquiries.token.approve');

        Route::get('enquiries/actions/{token}/decline', [EnquiryActionController::class, 'handleTokenAction'])
            ->defaults('action', 'decline')
            ->name('api.v1.enquiries.token.decline');
    });

    Route::prefix('auth/microsoft')->name('api.v1.auth.microsoft.')->group(function () {
        Route::get('url', [CalendarAuthController::class, 'getAuthUrl'])->name('url');
        Route::get('callback', [CalendarAuthController::class, 'handleCallback'])->name('callback');

        Route::middleware('auth:sanctum')->group(function () {
            Route::get('status', [CalendarAuthController::class, 'status'])->name('status');
            Route::post('refresh', [CalendarAuthController::class, 'refresh'])->name('refresh');
            Route::post('disconnect', [CalendarAuthController::class, 'disconnect'])->name('disconnect');
            Route::get('test', [CalendarAuthController::class, 'test'])->name('test');
        });
    });

    Route::prefix('webhooks')->name('api.v1.webhooks.')->group(function () {
        Route::post('microsoft', [CalendarWebhookController::class, 'handle'])
            ->middleware('microsoft.webhook')
            ->name('microsoft');

        Route::get('microsoft/test', [CalendarWebhookController::class, 'test'])->name('microsoft.test');

        Route::middleware('auth:sanctum')->group(function () {
            Route::get('microsoft/status', [CalendarWebhookController::class, 'status'])->name('microsoft.status');
            Route::post('microsoft/subscribe', [CalendarWebhookController::class, 'subscribe'])->name('microsoft.subscribe');
            Route::delete('microsoft/unsubscribe', [CalendarWebhookController::class, 'unsubscribe'])->name('microsoft.unsubscribe');
        });
    });

});
