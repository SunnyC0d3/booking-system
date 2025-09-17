<?php

namespace App\Console\Commands;

use App\Models\AvailabilitySlot;
use App\Services\AvailabilityService;
use Illuminate\Console\Command;

class CleanupExpiredSlots extends Command
{
    protected $signature = 'availability:cleanup
                            {--days=30 : Delete slots older than this many days}
                            {--dry-run : Show what would be deleted without actually deleting}';

    protected $description = 'Clean up expired availability slots';

    protected AvailabilityService $availabilityService;

    public function __construct(AvailabilityService $availabilityService)
    {
        parent::__construct();
        $this->availabilityService = $availabilityService;
    }

    public function handle(): int
    {
        $days = (int) $this->option('days');
        $dryRun = $this->option('dry-run');

        $this->info("🧹 Cleaning up availability slots older than {$days} days...");

        if ($dryRun) {
            $this->warn("🔍 DRY RUN MODE - No slots will actually be deleted");
        }

        try {
            if ($dryRun) {
                $count = $this->getExpiredSlotCount($days);
                $this->info("Would delete {$count} expired slots");
            } else {
                $deletedCount = $this->availabilityService->cleanupExpiredSlots($days);
                $this->info("✅ Deleted {$deletedCount} expired availability slots");
            }

            return self::SUCCESS;

        } catch (\Exception $e) {
            $this->error("❌ Error during cleanup: " . $e->getMessage());
            return self::FAILURE;
        }
    }

    private function getExpiredSlotCount(int $days): int
    {
        $cutoffDate = now()->subDays($days);

        return AvailabilitySlot::where('date', '<', $cutoffDate->toDateString())->count();
    }
}
