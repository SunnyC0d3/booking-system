<?php

namespace App\Services;

use App\Models\AvailabilitySlot;
use App\Models\BlackoutDate;
use App\Models\Booking;
use App\Models\Resource;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class BookingService
{
    public function createBooking(Resource $resource, Carbon $start, Carbon $end, array $customerInfo): Booking
    {
        if (!$this->isWithinBookingWindow($start)) {
            throw ValidationException::withMessages([
                'start_time' => 'Booking time is outside allowed booking window',
            ]);
        }

        if ($this->isBlackoutDate($resource->id, $start)) {
            throw ValidationException::withMessages([
                'availability' => 'Resource is not available on this date (holiday/blackout)',
            ]);
        }

        if (!$this->hasAvailableSlots($resource, $start, $end)) {
            throw ValidationException::withMessages([
                'availability' => 'Resource is not available in this time slot',
            ]);
        }

        $overlaps = $this->countOverlappingBookings($resource, $start, $end);
        if ($overlaps >= $resource->capacity) {
            throw ValidationException::withMessages([
                'conflict' => 'Resource is fully booked for this interval',
            ]);
        }

        if ($resource->capacity == 1) {
            $this->markSlotsUnavailable($resource, $start, $end);
        }

        return Booking::create([
            'resource_id' => $resource->id,
            'start_time' => $start,
            'end_time' => $end,
            'customer_info' => $customerInfo,
            'status' => 'pending',
        ]);
    }

    public function updateBooking(Booking $booking, Carbon $start, Carbon $end, array $customerInfo): Booking
    {
        $resource = $booking->resource;

        if (!$this->isWithinBookingWindow($start)) {
            throw ValidationException::withMessages([
                'start_time' => 'Booking time is outside allowed booking window',
            ]);
        }

        if ($this->isBlackoutDate($resource->id, $start)) {
            throw ValidationException::withMessages([
                'availability' => 'Resource is not available on this date (holiday/blackout)',
            ]);
        }

        if (!$start->eq($booking->start_time) || !$end->eq($booking->end_time)) {
            if (!$this->hasAvailableSlots($resource, $start, $end)) {
                throw ValidationException::withMessages([
                    'availability' => 'Resource is not available in this new time slot',
                ]);
            }

            $overlaps = $this->countOverlappingBookings($resource, $start, $end, $booking->id);
            if ($overlaps >= $resource->capacity) {
                throw ValidationException::withMessages([
                    'conflict' => 'Resource is fully booked for this interval',
                ]);
            }

            if ($resource->capacity == 1) {
                $this->markSlotsAvailable($resource, $booking->start_time, $booking->end_time);
                $this->markSlotsUnavailable($resource, $start, $end);
            }
        }

        $booking->update([
            'start_time' => $start,
            'end_time' => $end,
            'customer_info' => $customerInfo,
        ]);

        return $booking;
    }

    public function cancelBooking(Booking $booking): void
    {
        $resource = $booking->resource;

        if ($resource->capacity == 1) {
            $this->markSlotsAvailable($resource, $booking->start_time, $booking->end_time);
        }

        $booking->update(['status' => 'cancelled']);
    }

    private function isWithinBookingWindow(Carbon $bookingDateTime): bool
    {
        $now = Carbon::now();
        $minHours = config('booking.min_advance_booking_hours', 2);
        $maxDays = config('booking.max_advance_booking_days', 365);

        $earliestBooking = $now->copy()->addHours($minHours);
        $latestBooking = $now->copy()->addDays($maxDays);

        return $bookingDateTime->between($earliestBooking, $latestBooking);
    }

    private function isBlackoutDate(int $resourceId, Carbon $date): bool
    {
        return BlackoutDate::forResource($resourceId)
            ->where('date', $date->toDateString())
            ->exists();
    }

    private function hasAvailableSlots(Resource $resource, Carbon $start, Carbon $end): bool
    {
        return AvailabilitySlot::where('resource_id', $resource->id)
            ->where('date', $start->toDateString())
            ->where('is_available', true)
            ->where('start_time', '<=', $start->toTimeString())
            ->where('end_time', '>=', $end->toTimeString())
            ->exists();
    }

    private function countOverlappingBookings(Resource $resource, Carbon $start, Carbon $end, ?int $excludeBookingId = null): int
    {
        $query = Booking::where('resource_id', $resource->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function ($q) use ($start, $end) {
                $q->where(function ($q1) use ($start, $end) {
                    $q1->whereBetween('start_time', [$start, $end]);
                })->orWhere(function ($q2) use ($start, $end) {
                    $q2->whereBetween('end_time', [$start, $end]);
                })->orWhere(function ($q3) use ($start, $end) {
                    $q3->where('start_time', '<=', $start)
                        ->where('end_time', '>=', $end);
                });
            });

        if ($excludeBookingId) {
            $query->where('id', '!=', $excludeBookingId);
        }

        return $query->count();
    }

    private function markSlotsUnavailable(Resource $resource, Carbon $start, Carbon $end): void
    {
        AvailabilitySlot::where('resource_id', $resource->id)
            ->where('date', $start->toDateString())
            ->where('start_time', '>=', $start->toTimeString())
            ->where('end_time', '<=', $end->toTimeString())
            ->update(['is_available' => false]);
    }

    private function markSlotsAvailable(Resource $resource, Carbon $start, Carbon $end): void
    {
        AvailabilitySlot::where('resource_id', $resource->id)
            ->where('date', $start->toDateString())
            ->where('start_time', '>=', $start->toTimeString())
            ->where('end_time', '<=', $end->toTimeString())
            ->update(['is_available' => true]);
    }
}
