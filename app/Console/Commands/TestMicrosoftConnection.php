<?php

namespace App\Console\Commands;

use App\Services\Microsoft365Service;
use App\Services\CalendarSyncService;
use App\Models\MicrosoftToken;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;

class TestMicrosoftConnection extends Command
{
    protected $signature = 'enquiry:test-microsoft
                           {--user= : User identifier to test (defaults to owner email)}
                           {--create-event : Test creating a calendar event}
                           {--webhook : Test webhook subscription}';

    protected $description = 'Test Microsoft 365 connection and functionality';

    protected Microsoft365Service $microsoftService;
    protected CalendarSyncService $syncService;

    public function __construct(Microsoft365Service $microsoftService, CalendarSyncService $syncService)
    {
        parent::__construct();
        $this->microsoftService = $microsoftService;
        $this->syncService = $syncService;
    }

    public function handle(): int
    {
        $userIdentifier = $this->option('user') ?? config('enquiry.owner_email');

        if (!$userIdentifier) {
            $this->error('No user identifier provided. Set ENQUIRY_OWNER_EMAIL or use --user option');
            return Command::FAILURE;
        }

        $this->info("Testing Microsoft 365 connection for: {$userIdentifier}");
        $this->newLine();

        $allTestsPassed = true;

        $allTestsPassed &= $this->testConfiguration();
        $allTestsPassed &= $this->testAuthentication($userIdentifier);
        $allTestsPassed &= $this->testApiConnectivity($userIdentifier);
        $allTestsPassed &= $this->testCalendarAccess($userIdentifier);

        if ($this->option('create-event')) {
            $allTestsPassed &= $this->testEventCreation($userIdentifier);
        }

        if ($this->option('webhook')) {
            $allTestsPassed &= $this->testWebhookSubscription($userIdentifier);
        }

        $this->newLine();

        if ($allTestsPassed) {
            $this->info('✅ All tests passed! Microsoft 365 integration is working correctly.');
            return Command::SUCCESS;
        } else {
            $this->error('❌ Some tests failed. Check the output above for details.');
            return Command::FAILURE;
        }
    }

    protected function testConfiguration(): bool
    {
        $this->line('🔧 Testing configuration...');

        $requiredConfigs = [
            'microsoft.client_id' => config('microsoft.client_id'),
            'microsoft.client_secret' => config('microsoft.client_secret'),
            'microsoft.redirect_uri' => config('microsoft.redirect_uri'),
            'microsoft.webhook_secret' => config('microsoft.webhook_secret'),
        ];

        $configOk = true;
        foreach ($requiredConfigs as $key => $value) {
            if (empty($value)) {
                $this->error("  ❌ Missing configuration: {$key}");
                $configOk = false;
            } else {
                $this->line("  ✅ {$key}: " . (str_contains($key, 'secret') ? '[HIDDEN]' : $value));
            }
        }

        return $configOk;
    }

    protected function testAuthentication(string $userIdentifier): bool
    {
        $this->line('🔐 Testing authentication...');

        $token = MicrosoftToken::getValidTokenForUser($userIdentifier);

        if (!$token) {
            $this->error('  ❌ No valid authentication token found');
            $this->line('  💡 Run the OAuth flow first: php artisan tinker');
            $this->line('     Then: app(\\App\\Http\\Controllers\\Api\\V1\\CalendarAuthController::class)->getAuthUrl(new \\Illuminate\\Http\\Request([\'user_identifier\' => \'' . $userIdentifier . '\']));');
            return false;
        }

        $this->line("  ✅ Token found (ID: {$token->id})");
        $this->line("  📅 Expires: {$token->expires_at->format('Y-m-d H:i:s')} ({$token->time_until_expiry})");
        $this->line("  🔑 Scopes: " . implode(', ', $token->scope ?? []));

        if ($token->needsRefresh()) {
            $this->warn('  ⚠️  Token needs refresh');
        }

        return true;
    }

    protected function testApiConnectivity(string $userIdentifier): bool
    {
        $this->line('🌐 Testing API connectivity...');

        try {
            $profile = $this->microsoftService->getUserProfile($userIdentifier);

            $this->line("  ✅ Connected to Microsoft Graph API");
            $this->line("  👤 User: {$profile['displayName']} ({$profile['userPrincipalName']})");

            return true;

        } catch (Exception $e) {
            $this->error("  ❌ API connectivity failed: {$e->getMessage()}");
            return false;
        }
    }

    protected function testCalendarAccess(string $userIdentifier): bool
    {
        $this->line('📅 Testing calendar access...');

        try {
            $calendars = $this->microsoftService->getUserCalendars($userIdentifier);

            $this->line("  ✅ Retrieved {" . count($calendars) . "} calendars");

            foreach ($calendars as $calendar) {
                $this->line("    📋 {$calendar['name']} (ID: {$calendar['id']})");
            }

            return true;

        } catch (Exception $e) {
            $this->error("  ❌ Calendar access failed: {$e->getMessage()}");
            return false;
        }
    }

    protected function testEventCreation(string $userIdentifier): bool
    {
        $this->line('📝 Testing event creation...');

        if (!$this->confirm('This will create a test event in your calendar. Continue?')) {
            $this->line('  ⏭️  Event creation test skipped');
            return true;
        }

        try {
            $testEventData = [
                'subject' => 'Test Event - Enquiry System',
                'start_time' => now()->addHour()->toISOString(),
                'end_time' => now()->addHours(2)->toISOString(),
                'body' => 'This is a test event created by the enquiry system. You can safely delete this.',
                'location' => 'Test Location'
            ];

            $formattedData = $this->microsoftService->formatEventData($testEventData);
            $event = $this->microsoftService->createCalendarEvent($userIdentifier, $formattedData);

            $this->line("  ✅ Test event created: {$event['subject']}");
            $this->line("  🔗 Event ID: {$event['id']}");

            if ($this->confirm('Delete the test event?', true)) {
                $this->microsoftService->deleteCalendarEvent($userIdentifier, $event['id']);
                $this->line("  🗑️  Test event deleted");
            }

            return true;

        } catch (Exception $e) {
            $this->error("  ❌ Event creation failed: {$e->getMessage()}");
            return false;
        }
    }

    protected function testWebhookSubscription(string $userIdentifier): bool
    {
        $this->line('🪝 Testing webhook subscription...');

        try {
            $subscriptions = $this->syncService->getActiveSubscriptions();
            $this->line("  📊 Active subscriptions: " . count($subscriptions));

            foreach ($subscriptions as $subscription) {
                $expiresAt = Carbon::parse($subscription['expirationDateTime']);
                $this->line("    🔗 {$subscription['id']} (expires: {$expiresAt->format('Y-m-d H:i:s')})");
            }

            $renewalNeeded = $this->syncService->checkSubscriptionRenewal();
            if (!empty($renewalNeeded)) {
                $this->warn("  ⚠️  " . count($renewalNeeded) . " subscriptions need renewal");
            } else {
                $this->line("  ✅ All subscriptions are current");
            }

            return true;
        } catch (Exception $e) {
            $this->error("  ❌ Webhook subscription test failed: {$e->getMessage()}");
            return false;
        }
    }
}
