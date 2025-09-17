<?php

namespace App\Console\Commands;

use App\Models\Resource;
use App\Services\AvailabilityService;
use App\Services\CalendarService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GenerateAvailabilitySlots extends Command
{
    protected $signature = 'availability:generate
                            {--resource= : Generate slots for specific resource ID}
                            {--from= : Start date (Y-m-d format)}
                            {--to= : End date (Y-m-d format)}
                            {--days= : Number of days ahead to generate (default: config value)}
                            {--year= : Generate for entire year}';

    protected $description = 'Generate availability slots for resources';

    protected AvailabilityService $availabilityService;
    protected CalendarService $calendarService;

    public function __construct(AvailabilityService $availabilityService, CalendarService $calendarService)
    {
        parent::__construct();
        $this->availabilityService = $availabilityService;
        $this->calendarService = $calendarService;
    }

    public function handle(): int
    {
        $this->info('🔄 Starting availability slot generation...');

        try {
            $dateRange = $this->getDateRange();
            $resources = $this->getResources();

            $totalSlots = 0;

            foreach ($resources as $resource) {
                $this->info("Generating slots for: {$resource->name}");

                $slotsCreated = $this->availabilityService->generateSlotsForResource(
                    $resource,
                    $dateRange['start'],
                    $dateRange['end']
                );

                $totalSlots += $slotsCreated;
                $this->line("  ✅ Created {$slotsCreated} slots");
            }

            $this->info("🎉 Total slots created: {$totalSlots}");
            $this->info("📅 Date range: {$dateRange['start']->format('Y-m-d')} to {$dateRange['end']->format('Y-m-d')}");

            return self::SUCCESS;

        } catch (\Exception $e) {
            $this->error("❌ Error: " . $e->getMessage());
            return self::FAILURE;
        }
    }

    private function getDateRange(): array
    {
        if ($this->option('year')) {
            $year = (int) $this->option('year');
            return [
                'start' => Carbon::createFromDate($year, 1, 1),
                'end' => Carbon::createFromDate($year, 12, 31)
            ];
        }

        if ($this->option('from') && $this->option('to')) {
            return [
                'start' => Carbon::createFromFormat('Y-m-d', $this->option('from')),
                'end' => Carbon::createFromFormat('Y-m-d', $this->option('to'))
            ];
        }

        if ($this->option('days')) {
            $days = (int) $this->option('days');
            return [
                'start' => Carbon::today(),
                'end' => Carbon::today()->addDays($days)
            ];
        }

        return $this->calendarService->getDateRangeForGeneration();
    }

    private function getResources()
    {
        if ($resourceId = $this->option('resource')) {
            return Resource::where('id', $resourceId)->get();
        }

        return Resource::all();
    }
}
