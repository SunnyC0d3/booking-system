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
            ->forDate($date)
            ->available()
            ->orderBy('start_time')
            ->get();
    }

    public function getAvailabilityForDateRange(Carbon $startDate, Carbon $endDate)
    {
        return $this->availabilitySlots()
            ->forDateRange($startDate, $endDate)
            ->available()
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();
    }
}
