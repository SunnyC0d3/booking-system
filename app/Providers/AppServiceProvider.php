<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\EnquiryService;
use App\Services\Microsoft365Service;
use App\Services\CalendarEventService;
use App\Services\SmartEmailService;
use App\Services\WebhookHandlerService;
use App\Services\CalendarSyncService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(Microsoft365Service::class, function ($app) {
            return new Microsoft365Service();
        });

        $this->app->singleton(SmartEmailService::class, function ($app) {
            return new SmartEmailService();
        });

        $this->app->singleton(EnquiryService::class, function ($app) {
            return new EnquiryService(
                $app->make(SmartEmailService::class)
            );
        });

        $this->app->singleton(CalendarEventService::class, function ($app) {
            return new CalendarEventService(
                $app->make(Microsoft365Service::class)
            );
        });

        $this->app->singleton(WebhookHandlerService::class, function ($app) {
            return new WebhookHandlerService(
                $app->make(Microsoft365Service::class),
                $app->make(CalendarEventService::class),
                $app->make(EnquiryService::class)
            );
        });

        $this->app->singleton(CalendarSyncService::class, function ($app) {
            return new CalendarSyncService(
                $app->make(Microsoft365Service::class),
                $app->make(CalendarEventService::class),
                $app->make(EnquiryService::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
