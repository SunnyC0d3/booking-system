<?php

namespace Database\Seeders;

use App\Models\BlackoutDate;
use App\Models\Resource;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BlackoutDateSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🚫 Creating blackout dates and holidays...');

        $this->createGlobalHolidays();
        $this->createResourceSpecificBlackouts();

        $totalBlackouts = BlackoutDate::count();
        $this->command->info("🎉 Created {$totalBlackouts} blackout dates");
    }

    private function createGlobalHolidays(): void
    {
        $this->command->line('📅 Adding global holidays...');

        $currentYear = Carbon::now()->year;
        $nextYear = $currentYear + 1;

        $holidays = [
            ['date' => "{$currentYear}-01-01", 'reason' => 'New Year\'s Day', 'recurring' => true],
            ['date' => "{$currentYear}-07-04", 'reason' => 'Independence Day (US)', 'recurring' => true],
            ['date' => "{$currentYear}-12-25", 'reason' => 'Christmas Day', 'recurring' => true],
            ['date' => "{$currentYear}-12-26", 'reason' => 'Boxing Day', 'recurring' => true],
            ['date' => "{$currentYear}-12-31", 'reason' => 'New Year\'s Eve', 'recurring' => true],

            ['date' => "{$nextYear}-01-01", 'reason' => 'New Year\'s Day', 'recurring' => true],
            ['date' => "{$nextYear}-07-04", 'reason' => 'Independence Day (US)', 'recurring' => true],
            ['date' => "{$nextYear}-12-25", 'reason' => 'Christmas Day', 'recurring' => true],
            ['date' => "{$nextYear}-12-26", 'reason' => 'Boxing Day', 'recurring' => true],

            ['date' => "{$currentYear}-11-28", 'reason' => 'Thanksgiving 2025', 'recurring' => false],
            ['date' => "{$currentYear}-11-29", 'reason' => 'Black Friday', 'recurring' => false],

            ['date' => "{$currentYear}-05-26", 'reason' => 'Spring Bank Holiday (UK)', 'recurring' => true],
            ['date' => "{$currentYear}-08-25", 'reason' => 'Summer Bank Holiday (UK)', 'recurring' => true],

            ['date' => Carbon::today()->addDays(60)->toDateString(), 'reason' => 'Company Annual Meeting', 'recurring' => false],
            ['date' => Carbon::today()->addDays(120)->toDateString(), 'reason' => 'System Upgrade Day', 'recurring' => false],
        ];

        foreach ($holidays as $holiday) {
            BlackoutDate::create([
                'resource_id' => null,
                'date' => $holiday['date'],
                'reason' => $holiday['reason'],
                'recurring_yearly' => $holiday['recurring'],
            ]);
        }

        $this->command->line('  ✅ Global holidays created');
    }

    private function createResourceSpecificBlackouts(): void
    {
        $this->command->line('🔧 Adding resource-specific maintenance days...');

        $resources = Resource::all();

        if ($resources->isEmpty()) {
            $this->command->warn('  ⚠️ No resources found. Skipping resource-specific blackouts.');
            return;
        }

        foreach ($resources as $resource) {
            $this->createMaintenanceDays($resource);
        }

        $this->command->line('  ✅ Resource-specific blackouts created');
    }

    private function createMaintenanceDays(Resource $resource): void
    {
        $maintenanceDays = [
            [
                'date' => Carbon::today()->addDays(15 + ($resource->id * 5))->toDateString(),
                'reason' => 'Monthly Equipment Maintenance',
                'recurring' => false
            ],
            [
                'date' => Carbon::today()->addDays(45 + ($resource->id * 3))->toDateString(),
                'reason' => 'Deep Cleaning & Inspection',
                'recurring' => false
            ],
            [
                'date' => Carbon::today()->addDays(90 + ($resource->id * 2))->toDateString(),
                'reason' => 'Quarterly System Update',
                'recurring' => false
            ],
            [
                'date' => Carbon::today()->addDays(30 + $resource->id)->toDateString(),
                'reason' => "Scheduled maintenance for {$resource->name}",
                'recurring' => false
            ],
        ];

        foreach ($maintenanceDays as $maintenance) {
            BlackoutDate::create([
                'resource_id' => $resource->id,
                'date' => $maintenance['date'],
                'reason' => $maintenance['reason'],
                'recurring_yearly' => $maintenance['recurring'],
            ]);
        }

        $this->command->line("    📝 Created maintenance schedule for: {$resource->name}");
    }
}
