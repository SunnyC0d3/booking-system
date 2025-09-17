<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('availability:generate --days=90')
    ->dailyAt('02:00')
    ->withoutOverlapping()
    ->runInBackground();

Schedule::command('availability:cleanup --days=30')
    ->weeklyOn(0, '03:00')
    ->withoutOverlapping();

Schedule::command('availability:generate --year=' . (now()->year + 1))
    ->yearlyOn(12, 1, '01:00')
    ->withoutOverlapping();
