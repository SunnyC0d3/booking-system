<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Enquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'resource_id',
        'preferred_date',
        'preferred_start_time',
        'preferred_end_time',
        'customer_info',
        'message',
        'status',
        'enquiry_token',
        'expires_at',
        'microsoft_event_id',
        'microsoft_calendar_id',
        'microsoft_event_data',
        'calendar_synced_at',
        'calendar_sync_enabled',
        'calendar_sync_status'
    ];

    protected $casts = [
        'preferred_date' => 'date',
        'preferred_start_time' => 'datetime:H:i',
        'preferred_end_time' => 'datetime:H:i',
        'customer_info' => 'array',
        'microsoft_event_data' => 'array',
        'expires_at' => 'datetime',
        'calendar_synced_at' => 'datetime',
        'calendar_sync_enabled' => 'boolean',
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_DECLINED = 'declined';
    const STATUS_CANCELLED = 'cancelled';
    const SYNC_PENDING = 'pending';
    const SYNC_SYNCED = 'synced';
    const SYNC_FAILED = 'failed';

    public function resource(): BelongsTo
    {
        return $this->belongsTo(Resource::class);
    }

    public function syncLogs(): HasMany
    {
        return $this->hasMany(CalendarSyncLog::class);
    }

    public function statusHistory(): HasMany
    {
        return $this->hasMany(EnquiryStatusHistory::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    public function scopeDeclined($query)
    {
        return $query->where('status', self::STATUS_DECLINED);
    }

    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<', now());
    }

    public function scopeForResource($query, $resourceId)
    {
        return $query->where('resource_id', $resourceId);
    }

    public function scopeForDate($query, Carbon $date)
    {
        return $query->where('preferred_date', $date->toDateString());
    }

    public function scopeForDateRange($query, Carbon $startDate, Carbon $endDate)
    {
        return $query->whereBetween('preferred_date', [$startDate->toDateString(), $endDate->toDateString()]);
    }

    public function scopeSyncEnabled($query)
    {
        return $query->where('calendar_sync_enabled', true);
    }

    public function scopeSyncPending($query)
    {
        return $query->where('calendar_sync_status', self::SYNC_PENDING);
    }

    public function getCustomerNameAttribute(): ?string
    {
        return $this->customer_info['name'] ?? null;
    }

    public function getCustomerEmailAttribute(): ?string
    {
        return $this->customer_info['email'] ?? null;
    }

    public function getCustomerPhoneAttribute(): ?string
    {
        return $this->customer_info['phone'] ?? null;
    }

    public function getCustomerCompanyAttribute(): ?string
    {
        return $this->customer_info['company'] ?? null;
    }

    public function getPreferredDateTimeAttribute(): ?Carbon
    {
        if (!$this->preferred_date || !$this->preferred_start_time) {
            return null;
        }

        return Carbon::createFromFormat(
            'Y-m-d H:i',
            $this->preferred_date->format('Y-m-d') . ' ' . $this->preferred_start_time
        );
    }

    public function getPreferredEndDateTimeAttribute(): ?Carbon
    {
        if (!$this->preferred_date || !$this->preferred_end_time) {
            return null;
        }

        return Carbon::createFromFormat(
            'Y-m-d H:i',
            $this->preferred_date->format('Y-m-d') . ' ' . $this->preferred_end_time
        );
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function isDeclined(): bool
    {
        return $this->status === self::STATUS_DECLINED;
    }

    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function isSyncEnabled(): bool
    {
        return $this->calendar_sync_enabled;
    }

    public function isSynced(): bool
    {
        return $this->calendar_sync_status === self::SYNC_SYNCED;
    }

    public function hasMicrosoftEvent(): bool
    {
        return !empty($this->microsoft_event_id);
    }

    public function canBeApproved(): bool
    {
        return $this->isPending() && !$this->isExpired();
    }

    public function canBeDeclined(): bool
    {
        return $this->isPending() && !$this->isExpired();
    }

    public function getStatusBadgeColorAttribute(): string
    {
        return match($this->status) {
            self::STATUS_PENDING => 'warning',
            self::STATUS_APPROVED => 'success',
            self::STATUS_DECLINED => 'danger',
            default => 'secondary'
        };
    }
}
