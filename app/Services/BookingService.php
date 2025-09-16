<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Resource;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class BookingService
{
    public function createBooking(Resource $resource, Carbon $start, Carbon $end, array $customerInfo): Booking
    {
        $date = $start->toDateString();
        $slotConflict = $resource->availabilitySlots()
            ->where('date', $date)
            ->where(function ($q) use ($start, $end) {
                $q->where('start_time', '<=', $start->toTimeString())
                    ->where('end_time', '>=', $end->toTimeString());
            })
            ->where('is_available', true)
            ->exists();

        if (!$slotConflict && $resource->availabilitySlots()->where('date', $date)->exists()) {
            throw ValidationException::withMessages([
                'availability' => 'Resource is not available in this time slot',
            ]);
        }

        $overlaps = Booking::where('resource_id', $resource->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function ($q) use ($start, $end) {
                $q->whereBetween('start_time', [$start, $end])
                    ->orWhereBetween('end_time', [$start, $end])
                    ->orWhere(function ($q2) use ($start, $end) {
                        $q2->where('start_time', '<=', $start)
                            ->where('end_time', '>=', $end);
                    });
            })
            ->count();

        if ($overlaps >= $resource->capacity) {
            throw ValidationException::withMessages([
                'conflict' => 'Resource is fully booked for this interval',
            ]);
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

        $overlaps = Booking::where('resource_id', $resource->id)
            ->where('id', '!=', $booking->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function ($q) use ($start, $end) {
                $q->whereBetween('start_time', [$start, $end])
                    ->orWhereBetween('end_time', [$start, $end])
                    ->orWhere(function ($q2) use ($start, $end) {
                        $q2->where('start_time', '<=', $start)
                            ->where('end_time', '>=', $end);
                    });
            })
            ->count();

        if ($overlaps >= $resource->capacity) {
            throw ValidationException::withMessages([
                'conflict' => 'Resource is fully booked for this interval',
            ]);
        }

        $booking->update([
            'start_time' => $start,
            'end_time' => $end,
            'customer_info' => $customerInfo,
        ]);

        return $booking;
    }
}
