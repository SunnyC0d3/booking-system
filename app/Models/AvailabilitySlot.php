<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class AvailabilitySlot extends Model
{
    use HasFactory;

    protected $fillable = ['resource_id', 'date', 'start_time', 'end_time', 'is_available'];

    protected $casts = [
        'date' => 'date',
        'is_available' => 'boolean',
    ];

    public function resource(): BelongsTo
    {
        return $this->belongsTo(Resource::class);
    }

    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    public function scopeForDate($query, Carbon $date)
    {
        return $query->where('date', $date->toDateString());
    }

    public function scopeForDateRange($query, Carbon $startDate, Carbon $endDate)
    {
        return $query->whereBetween('date', [$startDate->toDateString(), $endDate->toDateString()]);
    }

    public function scopeForResource($query, $resourceId)
    {
        return $query->where('resource_id', $resourceId);
    }

    public function scopeExpired($query, int $daysOld = 30)
    {
        $cutoffDate = Carbon::now()->subDays($daysOld);
        return $query->where('date', '<', $cutoffDate->toDateString());
    }

    public function getStartDateTimeAttribute(): Carbon
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->date->format('Y-m-d') . ' ' . $this->start_time);
    }

    public function getEndDateTimeAttribute(): Carbon
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->date->format('Y-m-d') . ' ' . $this->end_time);
    }

    public function conflictsWith(Carbon $startDateTime, Carbon $endDateTime): bool
    {
        $slotStart = $this->start_date_time;
        $slotEnd = $this->end_date_time;

        return $startDateTime->lt($slotEnd) && $endDateTime->gt($slotStart);
    }
}
