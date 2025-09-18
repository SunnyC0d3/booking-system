<?php

namespace App\Services;

use App\Models\AvailabilitySlot;
use App\Models\BlackoutDate;
use App\Models\Resource;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;

class AvailabilityService
{
    public function generateSlotsForResource(Resource $resource, Carbon $startDate, Carbon $endDate): int
    {
        $slotsCreated = 0;
        $slotDuration = config('booking.default_slot_duration', 60);

        $period = CarbonPeriod::create($startDate, $endDate);

        foreach ($period as $date) {
            if ($this->isBlackoutDate($resource->id, $date)) {
                continue;
            }

            $availabilityRules = $resource->availability_rules ?? config('booking.default_business_hours');
            $dayOfWeek = strtolower($date->englishDayOfWeek);

            if (!isset($availabilityRules[$dayOfWeek]) || empty($availabilityRules[$dayOfWeek])) {
                continue;
            }

            foreach ($availabilityRules[$dayOfWeek] as $timeRange) {
                $slotsCreated += $this->createSlotsForTimeRange(
                    $resource->id,
                    $date,
                    $timeRange,
                    $slotDuration
                );
            }
        }

        return $slotsCreated;
    }

    private function createSlotsForTimeRange(int $resourceId, Carbon $date, string $timeRange, int $slotDuration): int
    {
        [$startTime, $endTime] = explode('-', $timeRange);

        $currentSlot = Carbon::createFromFormat('Y-m-d H:i', $date->format('Y-m-d') . ' ' . $startTime);
        $endDateTime = Carbon::createFromFormat('Y-m-d H:i', $date->format('Y-m-d') . ' ' . $endTime);

        $slotsCreated = 0;

        while ($currentSlot->addMinutes($slotDuration)->lte($endDateTime)) {
            $slotStart = $currentSlot->copy()->subMinutes($slotDuration);
            $slotEnd = $currentSlot->copy();

            if ($this->slotExists($resourceId, $date, $slotStart->format('H:i:s'), $slotEnd->format('H:i:s'))) {
                continue;
            }

            AvailabilitySlot::create([
                'resource_id' => $resourceId,
                'date' => $date->toDateString(),
                'start_time' => $slotStart->format('H:i:s'),
                'end_time' => $slotEnd->format('H:i:s'),
                'is_available' => true,
            ]);

            $slotsCreated++;
        }

        return $slotsCreated;
    }

    private function slotExists(int $resourceId, Carbon $date, string $startTime, string $endTime): bool
    {
        return AvailabilitySlot::forResource($resourceId)
            ->forDate($date)
            ->where('start_time', $startTime)
            ->where('end_time', $endTime)
            ->exists();
    }

    private function isBlackoutDate(int $resourceId, Carbon $date): bool
    {
        return BlackoutDate::forResource($resourceId)
            ->where('date', $date->toDateString())
            ->exists();
    }

    public function getAvailabilityForDateRange(Resource $resource, Carbon $startDate, Carbon $endDate): Collection
    {
        return AvailabilitySlot::forResource($resource->id)
            ->forDateRange($startDate, $endDate)
            ->available()
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();
    }

    public function cleanupExpiredSlots(int $daysOld = 30): int
    {
        return AvailabilitySlot::expired($daysOld)->delete();
    }
}
