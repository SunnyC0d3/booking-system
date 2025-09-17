<?php

namespace Database\Seeders;

use App\Models\AvailabilitySlot;
use App\Models\Booking;
use App\Models\Resource;
use App\Services\BookingService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('📅 Creating sample bookings...');

        $resources = Resource::all();

        if ($resources->isEmpty()) {
            $this->command->warn('⚠️ No resources found. Please run ResourceSeeder first.');
            return;
        }

        $bookingService = app(BookingService::class);
        $totalBookingsCreated = 0;

        foreach ($resources as $resource) {
            $bookingsCreated = $this->createBookingsForResource($resource, $bookingService);
            $totalBookingsCreated += $bookingsCreated;
            $this->command->line("  ✅ Created {$bookingsCreated} bookings for: {$resource->name}");
        }

        $this->command->info("🎉 Total bookings created: {$totalBookingsCreated}");
        $this->command->info("📊 Booking status distribution: Confirmed, Pending, and Cancelled examples");
    }

    private function createBookingsForResource(Resource $resource, BookingService $bookingService): int
    {
        $bookingsCreated = 0;
        $customers = $this->getSampleCustomers();

        $bookingScenarios = [
            ['date_offset' => 0, 'status' => 'confirmed', 'count' => 2],
            ['date_offset' => 1, 'status' => 'confirmed', 'count' => 1],
            ['date_offset' => 1, 'status' => 'pending', 'count' => 1],
            ['date_offset' => 7, 'status' => 'pending', 'count' => 2],
            ['date_offset' => 8, 'status' => 'confirmed', 'count' => 1],
            ['date_offset' => 14, 'status' => 'pending', 'count' => 1],
            ['date_offset' => 2, 'status' => 'cancelled', 'count' => 1],
        ];

        foreach ($bookingScenarios as $scenario) {
            for ($i = 0; $i < $scenario['count']; $i++) {
                $booking = $this->createSingleBooking(
                    $resource,
                    $scenario['date_offset'] + $i,
                    $scenario['status'],
                    $customers[array_rand($customers)],
                    $bookingService
                );

                if ($booking) {
                    $bookingsCreated++;
                }
            }
        }

        return $bookingsCreated;
    }

    private function createSingleBooking(
        Resource $resource,
        int $dateOffset,
        string $status,
        array $customer,
        BookingService $bookingService
    ): ?Booking {
        $bookingDate = Carbon::today()->addDays($dateOffset);
        $availableSlots = AvailabilitySlot::where('resource_id', $resource->id)
            ->where('date', $bookingDate->toDateString())
            ->where('is_available', true)
            ->get();

        if ($availableSlots->isEmpty()) {
            return null;
        }

        $slot = $availableSlots->random();

        $startTime = Carbon::createFromFormat('Y-m-d H:i:s', $bookingDate->format('Y-m-d') . ' ' . $slot->start_time);
        $endTime = Carbon::createFromFormat('Y-m-d H:i:s', $bookingDate->format('Y-m-d') . ' ' . $slot->end_time);

        try {
            if ($status !== 'cancelled') {
                $booking = $bookingService->createBooking($resource, $startTime, $endTime, $customer);
                $booking->update(['status' => $status]);

                if ($status === 'cancelled') {
                    $bookingService->cancelBooking($booking);
                }

                return $booking;
            } else {
                $booking = Booking::create([
                    'resource_id' => $resource->id,
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'customer_info' => $customer,
                    'status' => 'confirmed',
                ]);

                $bookingService->cancelBooking($booking);
                return $booking;
            }
        } catch (\Exception $e) {
            return null;
        }
    }

    private function getSampleCustomers(): array
    {
        return [
            [
                'name' => 'Alice Johnson',
                'email' => 'alice.johnson@example.com',
            ],
            [
                'name' => 'Bob Smith',
                'email' => 'bob.smith@company.com',
            ],
            [
                'name' => 'Carol Davis',
                'email' => 'carol.davis@business.org',
            ],
            [
                'name' => 'David Wilson',
                'email' => 'david.wilson@startup.io',
            ],
            [
                'name' => 'Emma Brown',
                'email' => 'emma.brown@enterprise.com',
            ],
            [
                'name' => 'Frank Miller',
                'email' => 'frank.miller@agency.net',
            ],
            [
                'name' => 'Grace Lee',
                'email' => 'grace.lee@consulting.com',
            ],
            [
                'name' => 'Henry Taylor',
                'email' => 'henry.taylor@solutions.biz',
            ],
            [
                'name' => 'Ivy Chen',
                'email' => 'ivy.chen@tech.dev',
            ],
            [
                'name' => 'Jack Anderson',
                'email' => 'jack.anderson@services.pro',
            ],
        ];
    }
}
