<?php

namespace Database\Seeders;

use App\Models\Enquiry;
use App\Models\Resource;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class EnquirySeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('📝 Creating sample enquiries...');

        $resources = Resource::all();

        if ($resources->isEmpty()) {
            $this->command->warn('⚠️ No resources found. Please run ResourceSeeder first.');
            return;
        }

        $totalEnquiriesCreated = 0;

        foreach ($resources as $resource) {
            $enquiriesCreated = $this->createEnquiriesForResource($resource);
            $totalEnquiriesCreated += $enquiriesCreated;
            $this->command->line("  ✅ Created {$enquiriesCreated} enquiries for: {$resource->name}");
        }

        $this->command->info("🎉 Total enquiries created: {$totalEnquiriesCreated}");
        $this->command->info("📊 Enquiry status distribution: Pending, Approved, and Declined examples");
    }

    private function createEnquiriesForResource(Resource $resource): int
    {
        $enquiriesCreated = 0;
        $customers = $this->getSampleCustomers();

        $enquiryScenarios = [
            ['date_offset' => 5, 'status' => 'pending', 'count' => 2],
            ['date_offset' => 7, 'status' => 'pending', 'count' => 1],
            ['date_offset' => 10, 'status' => 'approved', 'count' => 1],
            ['date_offset' => 12, 'status' => 'approved', 'count' => 2],
            ['date_offset' => 15, 'status' => 'pending', 'count' => 1],
            ['date_offset' => 20, 'status' => 'declined', 'count' => 1],
            ['date_offset' => 25, 'status' => 'pending', 'count' => 2],
        ];

        foreach ($enquiryScenarios as $scenario) {
            for ($i = 0; $i < $scenario['count']; $i++) {
                $enquiry = $this->createSingleEnquiry(
                    $resource,
                    $scenario['date_offset'] + $i,
                    $scenario['status'],
                    $customers[array_rand($customers)]
                );

                if ($enquiry) {
                    $enquiriesCreated++;
                }
            }
        }

        return $enquiriesCreated;
    }

    private function createSingleEnquiry(Resource $resource, int $dateOffset, string $status, array $customer): ?Enquiry
    {
        $preferredDate = Carbon::today()->addDays($dateOffset);

        $startTimes = ['09:00', '10:00', '14:00', '15:00', '16:00'];
        $startTime = $startTimes[array_rand($startTimes)];
        $endTime = Carbon::createFromFormat('H:i', $startTime)->addHours(2)->format('H:i');

        $messages = [
            "Hi, I'm interested in booking this for my upcoming event. Please let me know if it's available.",
            "Hello! I would like to enquire about availability for my corporate function.",
            "Hi there, looking to book this for a special celebration. Hope to hear from you soon!",
            "Good morning, I need this for a client meeting. Could you please confirm availability?",
            "Hi, I'm planning a surprise party and would love to use your services.",
            "Hello! Interested in your services for a wedding event. Please get back to me.",
            "Hi, I'm organizing a corporate retreat and would like to discuss options.",
            "Good afternoon, enquiring about availability for a birthday celebration."
        ];

        try {
            $enquiry = Enquiry::create([
                'resource_id' => $resource->id,
                'preferred_date' => $preferredDate,
                'preferred_start_time' => $startTime,
                'preferred_end_time' => $endTime,
                'customer_info' => $customer,
                'message' => $messages[array_rand($messages)],
                'status' => $status,
                'enquiry_token' => Str::random(32),
                'expires_at' => $preferredDate->copy()->addDays(30),
            ]);

            return $enquiry;
        } catch (\Exception $e) {
            return null;
        }
    }

    private function getSampleCustomers(): array
    {
        return [
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah.johnson@example.com',
                'phone' => '+1 (555) 123-4567',
                'company' => 'Creative Events Ltd',
            ],
            [
                'name' => 'Michael Chen',
                'email' => 'michael.chen@company.com',
                'phone' => '+1 (555) 234-5678',
                'company' => 'Tech Solutions Inc',
            ],
            [
                'name' => 'Emma Williams',
                'email' => 'emma.williams@business.org',
                'phone' => '+1 (555) 345-6789',
                'company' => 'Williams & Associates',
            ],
            [
                'name' => 'David Rodriguez',
                'email' => 'david.rodriguez@startup.io',
                'phone' => '+1 (555) 456-7890',
                'company' => 'Innovation Labs',
            ],
            [
                'name' => 'Lisa Thompson',
                'email' => 'lisa.thompson@enterprise.com',
                'phone' => '+1 (555) 567-8901',
                'company' => 'Enterprise Solutions',
            ],
            [
                'name' => 'James Wilson',
                'email' => 'james.wilson@agency.net',
                'phone' => '+1 (555) 678-9012',
                'company' => 'Creative Agency',
            ],
            [
                'name' => 'Rachel Martinez',
                'email' => 'rachel.martinez@consulting.com',
                'phone' => '+1 (555) 789-0123',
                'company' => 'Strategic Consulting',
            ],
            [
                'name' => 'Ryan Taylor',
                'email' => 'ryan.taylor@solutions.biz',
                'phone' => '+1 (555) 890-1234',
                'company' => 'Business Solutions',
            ],
        ];
    }
}
