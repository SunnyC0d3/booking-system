<?php

namespace App\Console\Commands;

use App\Models\CalendarSyncLog;
use App\Models\Enquiry;
use App\Services\CalendarEventService;
use App\Services\CalendarSyncService;
use App\Services\EnquiryService;
use Illuminate\Console\Command;

class SyncCalendarEvents extends Command
{
    protected $signature = 'enquiry:sync-calendar
                           {--type=pending : Sync type (pending, retry, maintenance, all)}
                           {--enquiry= : Specific enquiry ID to sync}
                           {--dry-run : Show what would be synced without performing actions}';

    protected $description = 'Sync enquiries with Microsoft 365 calendar';

    protected CalendarSyncService $syncService;

    public function __construct(CalendarSyncService $syncService)
    {
        parent::__construct();
        $this->syncService = $syncService;
    }

    public function handle(): int
    {
        $type = $this->option('type');
        $enquiryId = $this->option('enquiry');
        $dryRun = $this->option('dry-run');

        $this->info("Starting calendar sync: {$type}");

        if ($dryRun) {
            $this->warn('DRY RUN MODE - No changes will be made');
        }

        try {
            if ($enquiryId) {
                return $this->syncSpecificEnquiry($enquiryId, $dryRun);
            }

            return match($type) {
                'pending' => $this->syncPendingEnquiries($dryRun),
                'retry' => $this->retryFailedSyncs($dryRun),
                'maintenance' => $this->performMaintenance($dryRun),
                'all' => $this->syncAll($dryRun),
                default => $this->error("Unknown sync type: {$type}")
            };

        } catch (\Exception $e) {
            $this->error("Sync failed: {$e->getMessage()}");
            return Command::FAILURE;
        }
    }

    protected function syncPendingEnquiries(bool $dryRun): int
    {
        if ($dryRun) {
            $pending = app(EnquiryService::class)->getEnquiriesNeedingSync();
            $this->table(['ID', 'Customer', 'Resource', 'Date'],
                $pending->map(fn($e) => [$e->id, $e->customer_name, $e->resource->name, $e->preferred_date])
            );
            $this->info("Would sync {$pending->count()} pending enquiries");
            return Command::SUCCESS;
        }

        $results = $this->syncService->syncPendingEnquiries();

        $this->info('Sync completed:');
        $this->line("  Synced: {$results['synced']}");
        $this->line("  Failed: {$results['failed']}");

        if (!empty($results['errors'])) {
            $this->warn('Errors occurred:');
            foreach ($results['errors'] as $error) {
                $this->line("  Enquiry {$error['enquiry_id']}: {$error['error']}");
            }
        }

        return Command::SUCCESS;
    }

    protected function retryFailedSyncs(bool $dryRun): int
    {
        if ($dryRun) {
            $failed = CalendarSyncLog::needsRetry()
                ->where('created_at', '>', now()->subHours(24))
                ->get();

            $this->table(['ID', 'Enquiry', 'Event Type', 'Error'],
                $failed->map(fn($log) => [$log->id, $log->enquiry_id, $log->event_type, substr($log->error_message, 0, 50) . '...'])
            );
            $this->info("Would retry {$failed->count()} failed syncs");
            return Command::SUCCESS;
        }

        $results = $this->syncService->retryFailedSyncs();

        $this->info('Retry completed:');
        $this->line("  Retried: {$results['retried']}");
        $this->line("  Succeeded: {$results['succeeded']}");
        $this->line("  Failed: {$results['failed']}");

        return Command::SUCCESS;
    }

    protected function performMaintenance(bool $dryRun): int
    {
        if ($dryRun) {
            $this->info('Would perform maintenance tasks:');
            $this->line('  - Renew webhook subscriptions');
            $this->line('  - Sync pending enquiries');
            $this->line('  - Retry failed syncs');
            $this->line('  - Clean up old logs');
            return Command::SUCCESS;
        }

        $results = $this->syncService->performMaintenance();

        $this->info('Maintenance completed:');
        foreach ($results as $task => $result) {
            $this->line("  {$task}: " . json_encode($result));
        }

        return Command::SUCCESS;
    }

    protected function syncAll(bool $dryRun): int
    {
        $this->info('Performing comprehensive sync...');

        $this->syncPendingEnquiries($dryRun);
        $this->retryFailedSyncs($dryRun);
        $this->performMaintenance($dryRun);

        return Command::SUCCESS;
    }

    protected function syncSpecificEnquiry(int $enquiryId, bool $dryRun): int
    {
        $enquiry = Enquiry::find($enquiryId);

        if (!$enquiry) {
            $this->error("Enquiry {$enquiryId} not found");
            return Command::FAILURE;
        }

        $this->info('Enquiry Details:');
        $this->line("  ID: {$enquiry->id}");
        $this->line("  Customer: {$enquiry->customer_name}");
        $this->line("  Resource: {$enquiry->resource->name}");
        $this->line("  Status: {$enquiry->status}");
        $this->line("  Sync Status: {$enquiry->calendar_sync_status}");

        if ($dryRun) {
            $this->info('Would sync this enquiry to calendar');
            return Command::SUCCESS;
        }

        if (!$enquiry->isApproved()) {
            $this->error('Only approved enquiries can be synced to calendar');
            return Command::FAILURE;
        }

        try {
            $calendarService = app(CalendarEventService::class);

            if ($enquiry->hasMicrosoftEvent()) {
                $event = $calendarService->updateEventForEnquiry($enquiry);
                $this->info("Calendar event updated: {$event['id']}");
            } else {
                $event = $calendarService->createEventForEnquiry($enquiry);
                $this->info("Calendar event created: {$event['id']}");
            }

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error("Failed to sync enquiry: {$e->getMessage()}");
            return Command::FAILURE;
        }
    }
}
