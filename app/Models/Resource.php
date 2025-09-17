<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Resource extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'capacity', 'availability_rules'];

    protected $casts = [
        'availability_rules' => 'array',
    ];

    public function availabilitySlots(): HasMany
    {
        return $this->hasMany(AvailabilitySlot::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function blackoutDates(): HasMany
    {
        return $this->hasMany(BlackoutDate::class);
    }

    public function getAvailabilityForDate(Carbon $date)
    {
        return $this->availabilitySlots()
            ->where('date', $date->toDateString())
            ->where('is_available', true)
            ->orderBy('start_time')
            ->get();
    }

    public function getAvailabilityForDateRange(Carbon $startDate, Carbon $endDate)
    {
        return $this->availabilitySlots()
            ->whereBetween('date', [$startDate->toDateString(), $endDate->toDateString()])
            ->where('is_available', true)
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();
    }

    public function hasAvailabilityForDay(string $dayOfWeek): bool
    {
        $rules = $this->availability_rules ?? config('booking.default_business_hours');
        return isset($rules[strtolower($dayOfWeek)]) && !empty($rules[strtolower($dayOfWeek)]);
    }

    public function getAvailabilityRulesForDay(string $dayOfWeek): array
    {
        $rules = $this->availability_rules ?? config('booking.default_business_hours');
        return $rules[strtolower($dayOfWeek)] ?? [];
    }
}
