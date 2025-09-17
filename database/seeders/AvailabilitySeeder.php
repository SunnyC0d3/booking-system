<?php

namespace Database\Seeders;

use App\Models\AvailabilitySlot;
use App\Models\Resource;
use App\Services\AvailabilityService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class AvailabilitySeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🔄 Generating availability slots for demo...');

        $availabilityService = app(AvailabilityService::class);
        $resources = Resource::all();

        if ($resources->isEmpty()) {
            $this->command->warn('⚠️ No resources found. Please run ResourceSeeder first.');
            return;
        }

        $totalSlotsCreated = 0;

        foreach ($resources as $resource) {
            $this->command->info("Generating slots for: {$resource->name}");

            $startDate = Carbon::today();
            $endDate = Carbon::today()->addDays(30);

            $slotsCreated = $availabilityService->generateSlotsForResource(
                $resource,
                $startDate,
                $endDate
            );

            $totalSlotsCreated += $slotsCreated;
            $this->command->line("  ✅ Created {$slotsCreated} slots");

            $this->createExampleUnavailableSlots($resource);
        }

        $this->command->info("🎉 Total availability slots created: {$totalSlotsCreated}");
        $this->command->info("📅 Generated slots for next 30 days");
    }

    private function createExampleUnavailableSlots(Resource $resource): void
    {
        $exampleUnavailableDates = [
            Carbon::today()->addDays(1),
            Carbon::today()->addDays(3),
            Carbon::today()->addDays(7),
        ];

        foreach ($exampleUnavailableDates as $date) {
            AvailabilitySlot::where('resource_id', $resource->id)
                ->where('date', $date->toDateString())
                ->where('start_time', '10:00:00')
                ->where('end_time', '11:00:00')
                ->update(['is_available' => false]);

            AvailabilitySlot::where('resource_id', $resource->id)
                ->where('date', $date->toDateString())
                ->where('start_time', '14:00:00')
                ->where('end_time', '15:00:00')
                ->update(['is_available' => false]);
        }

        $this->command->line("  📝 Added example unavailable slots for demonstration");
    }
}
