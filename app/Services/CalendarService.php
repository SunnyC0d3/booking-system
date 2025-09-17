<?php

namespace App\Services;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

class CalendarService
{
    public function getBusinessDaysInRange(Carbon $startDate, Carbon $endDate, bool $includeWeekends = null): array
    {
        $includeWeekends = $includeWeekends ?? config('booking.generate_weekend_slots', false);
        $businessDays = [];

        $period = CarbonPeriod::create($startDate, $endDate);

        foreach ($period as $date) {
            if (!$includeWeekends && $date->isWeekend()) {
                continue;
            }

            $businessDays[] = $date->copy();
        }

        return $businessDays;
    }

    public function parseTimeRange(string $timeRange): array
    {
        if (!str_contains($timeRange, '-')) {
            throw new \InvalidArgumentException("Invalid time range format: {$timeRange}");
        }

        [$startTime, $endTime] = explode('-', $timeRange);

        return [
            'start' => Carbon::createFromFormat('H:i', trim($startTime)),
            'end' => Carbon::createFromFormat('H:i', trim($endTime))
        ];
    }

    public function generateTimeSlots(string $startTime, string $endTime, int $duration = 60): array
    {
        $slots = [];
        $current = Carbon::createFromFormat('H:i', $startTime);
        $end = Carbon::createFromFormat('H:i', $endTime);

        while ($current->copy()->addMinutes($duration)->lte($end)) {
            $slotStart = $current->copy();
            $slotEnd = $current->copy()->addMinutes($duration);

            $slots[] = [
                'start_time' => $slotStart->format('H:i:s'),
                'end_time' => $slotEnd->format('H:i:s')
            ];

            $current->addMinutes($duration);
        }

        return $slots;
    }

    public function getDateRangeForGeneration(): array
    {
        $today = Carbon::today();
        $daysAhead = config('booking.generate_slots_for_days_ahead', 90);

        return [
            'start' => $today,
            'end' => $today->copy()->addDays($daysAhead)
        ];
    }

    public function isWithinBookingWindow(Carbon $bookingDate): bool
    {
        $now = Carbon::now();
        $minHours = config('booking.min_advance_booking_hours', 2);
        $maxDays = config('booking.max_advance_booking_days', 365);

        $earliestBooking = $now->copy()->addHours($minHours);
        $latestBooking = $now->copy()->addDays($maxDays);

        return $bookingDate->between($earliestBooking, $latestBooking);
    }

    public function formatAvailabilityForCalendar(array $slots): array
    {
        $calendar = [];

        foreach ($slots as $slot) {
            $date = $slot['date'];

            if (!isset($calendar[$date])) {
                $calendar[$date] = [
                    'date' => $date,
                    'slots' => [],
                    'total_slots' => 0,
                    'available_slots' => 0
                ];
            }

            $calendar[$date]['slots'][] = $slot;
            $calendar[$date]['total_slots']++;

            if ($slot['is_available']) {
                $calendar[$date]['available_slots']++;
            }
        }

        return array_values($calendar);
    }
}
