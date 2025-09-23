<?php

namespace App\Console\Commands;

use App\Models\CalendarSyncLog;
use App\Models\Enquiry;
use App\Services\EnquiryService;
use Exception;
use Illuminate\Console\Command;

class CleanupExpiredEnquiries extends Command
{
    protected $signature = 'enquiry:cleanup
                           {--dry-run : Show what would be cleaned up without performing actions}
                           {--force : Force cleanup without confirmation}';

    protected $description = 'Clean up expired enquiries and old sync logs';

    protected EnquiryService $enquiryService;

    public function __construct(EnquiryService $enquiryService)
    {
        parent::__construct();
        $this->enquiryService = $enquiryService;
    }

    public function handle(): int
    {
        $dryRun = $this->option('dry-run');
        $force = $this->option('force');

        $this->info('Starting enquiry cleanup process...');

        try {
            $expiredEnquiries = $this->getExpiredEnquiries();

            if ($expiredEnquiries->isEmpty()) {
                $this->info('No expired enquiries found.');
                return Command::SUCCESS;
            }

            $this->displayExpiredEnquiries($expiredEnquiries);

            if ($dryRun) {
                $this->warn('DRY RUN MODE - No changes will be made');
                return Command::SUCCESS;
            }

            if (!$force && !$this->confirmCleanup($expiredEnquiries->count())) {
                $this->info('Cleanup cancelled.');
                return Command::SUCCESS;
            }

            $cleanupCount = $this->enquiryService->cleanupExpiredEnquiries();
            $this->info("Cleanup completed: {$cleanupCount} enquiries processed");
            $this->cleanupOldSyncLogs($dryRun, $force);

            return Command::SUCCESS;

        } catch (Exception $e) {
            $this->error("Cleanup failed: {$e->getMessage()}");
            return Command::FAILURE;
        }
    }

    protected function getExpiredEnquiries()
    {
        return Enquiry::where('status', 'pending')
            ->where('expires_at', '<', now())
            ->with('resource')
            ->get();
    }

    protected function displayExpiredEnquiries($enquiries): void
    {
        $this->info("Found {$enquiries->count()} expired enquiries:");

        $tableData = $enquiries->map(function ($enquiry) {
            return [
                $enquiry->id,
                $enquiry->customer_name,
                $enquiry->customer_email,
                $enquiry->resource->name,
                $enquiry->preferred_date->format('Y-m-d'),
                $enquiry->expires_at->format('Y-m-d'),
                $enquiry->expires_at->diffForHumans()
            ];
        });

        $this->table([
            'ID',
            'Customer',
            'Email',
            'Resource',
            'Date',
            'Expired',
            'Age'
        ], $tableData);
    }

    protected function confirmCleanup(int $count): bool
    {
        return $this->confirm(
            "Are you sure you want to clean up {$count} expired enquiries? " .
            "This will change their status to 'cancelled' and cannot be undone."
        );
    }

    protected function cleanupOldSyncLogs(bool $dryRun, bool $force): void
    {
        $retentionDays = config('enquiry.sync_log_retention_days', 30);
        $cutoffDate = now()->subDays($retentionDays);

        $oldLogsQuery = CalendarSyncLog::where('created_at', '<', $cutoffDate);
        $oldLogsCount = $oldLogsQuery->count();

        if ($oldLogsCount === 0) {
            $this->line('No old sync logs to clean up.');
            return;
        }

        $this->line("Found {$oldLogsCount} sync logs older than {$retentionDays} days");

        if ($dryRun) {
            $this->line("Would delete {$oldLogsCount} old sync logs");
            return;
        }

        if (!$force && !$this->confirm("Delete {$oldLogsCount} old sync logs?")) {
            $this->line('Sync log cleanup skipped.');
            return;
        }

        $deletedCount = $oldLogsQuery->delete();
        $this->line("Deleted {$deletedCount} old sync logs");
    }
}
