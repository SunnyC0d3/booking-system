<?php

use App\Services\CalendarSyncService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('availability:generate --days=90')
    ->dailyAt('02:00')
    ->name('generate-availability-90-days')
    ->withoutOverlapping()
    ->runInBackground();

Schedule::command('availability:cleanup --days=30')
    ->weeklyOn(0, '03:00')
    ->name('cleanup-availability')
    ->withoutOverlapping();

Schedule::command('availability:generate --year=' . (now()->year + 1))
    ->yearlyOn(12, 1, '01:00')
    ->name('generate-next-year-availability')
    ->withoutOverlapping();

Schedule::command('enquiry:sync-calendar --type=pending')
    ->everyFifteenMinutes()
    ->name('sync-pending-enquiries')
    ->withoutOverlapping()
    ->runInBackground();

Schedule::command('enquiry:sync-calendar --type=retry')
    ->hourly()
    ->name('sync-retry-enquiries')
    ->withoutOverlapping()
    ->runInBackground();

Schedule::command('enquiry:sync-calendar --type=maintenance')
    ->dailyAt('03:00')
    ->name('sync-maintenance-enquiries')
    ->withoutOverlapping()
    ->runInBackground();

Schedule::command('enquiry:cleanup')
    ->dailyAt('04:00')
    ->name('cleanup-enquiries')
    ->withoutOverlapping()
    ->runInBackground();

Schedule::call(function () {
    try {
        $syncService = app(CalendarSyncService::class);
        $renewalNeeded = $syncService->checkSubscriptionRenewal();

        if (!empty($renewalNeeded)) {
            $syncService->renewWebhookSubscriptions();
            Log::info('Webhook subscriptions renewed', [
                'count' => count($renewalNeeded)
            ]);
        }
    } catch (\Exception $e) {
        Log::error('Failed to renew webhook subscriptions', [
            'error' => $e->getMessage()
        ]);
    }
})
    ->dailyAt('05:00')
    ->name('renew-webhook-subscriptions')
    ->withoutOverlapping();

Schedule::call(function () {
    try {
        $syncService = app(CalendarSyncService::class);
        $health = $syncService->getSyncHealthStatus();

        if ($health['overall_status'] === 'critical') {
            Log::critical('Calendar sync health critical', [
                'health' => $health
            ]);

            $adminEmail = config('enquiry.admin_email', config('enquiry.owner_email'));

            if ($adminEmail) {
                Mail::raw(
                    "Calendar sync health is critical. Please check the system.\n\n" .
                    json_encode($health, JSON_PRETTY_PRINT),
                    function ($message) use ($adminEmail) {
                        $message->to($adminEmail)
                            ->subject('[URGENT] Calendar Sync Health Alert');
                    }
                );
            }
        }
    } catch (Exception $e) {
        Log::error('Failed to check sync health', [
            'error' => $e->getMessage()
        ]);
    }
})
    ->everySixHours()
    ->name('monitor-sync-health')
    ->withoutOverlapping();
