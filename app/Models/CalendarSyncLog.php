<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CalendarSyncLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'enquiry_id',
        'event_type',
        'microsoft_event_id',
        'sync_direction',
        'status',
        'request_data',
        'response_data',
        'error_message',
        'retry_count',
        'synced_at'
    ];

    protected $casts = [
        'request_data' => 'array',
        'response_data' => 'array',
        'retry_count' => 'integer',
        'synced_at' => 'datetime',
    ];

    const EVENT_CREATED = 'created';
    const EVENT_UPDATED = 'updated';
    const EVENT_DELETED = 'deleted';
    const EVENT_WEBHOOK_RECEIVED = 'webhook_received';
    const DIRECTION_TO_MICROSOFT = 'to_microsoft';
    const DIRECTION_FROM_MICROSOFT = 'from_microsoft';
    const STATUS_SUCCESS = 'success';
    const STATUS_FAILED = 'failed';
    const STATUS_PENDING = 'pending';
    const STATUS_RETRY = 'retry';

    public function enquiry(): BelongsTo
    {
        return $this->belongsTo(Enquiry::class);
    }

    public function scopeSuccess($query)
    {
        return $query->where('status', self::STATUS_SUCCESS);
    }

    public function scopeFailed($query)
    {
        return $query->where('status', self::STATUS_FAILED);
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeRetry($query)
    {
        return $query->where('status', self::STATUS_RETRY);
    }

    public function scopeToMicrosoft($query)
    {
        return $query->where('sync_direction', self::DIRECTION_TO_MICROSOFT);
    }

    public function scopeFromMicrosoft($query)
    {
        return $query->where('sync_direction', self::DIRECTION_FROM_MICROSOFT);
    }

    public function scopeForEventType($query, string $eventType)
    {
        return $query->where('event_type', $eventType);
    }

    public function scopeForMicrosoftEvent($query, string $microsoftEventId)
    {
        return $query->where('microsoft_event_id', $microsoftEventId);
    }

    public function scopeRecentFirst($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeNeedsRetry($query)
    {
        return $query->where('status', self::STATUS_FAILED)
            ->where('retry_count', '<', 3);
    }

    public function isSuccess(): bool
    {
        return $this->status === self::STATUS_SUCCESS;
    }

    public function isFailed(): bool
    {
        return $this->status === self::STATUS_FAILED;
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isRetry(): bool
    {
        return $this->status === self::STATUS_RETRY;
    }

    public function isToMicrosoft(): bool
    {
        return $this->sync_direction === self::DIRECTION_TO_MICROSOFT;
    }

    public function isFromMicrosoft(): bool
    {
        return $this->sync_direction === self::DIRECTION_FROM_MICROSOFT;
    }

    public function canRetry(): bool
    {
        return $this->isFailed() && $this->retry_count < 3;
    }

    public function incrementRetry(): void
    {
        $this->increment('retry_count');
        $this->update(['status' => self::STATUS_RETRY]);
    }

    public function markAsSuccess(array $responseData = null): void
    {
        $this->update([
            'status' => self::STATUS_SUCCESS,
            'response_data' => $responseData,
            'synced_at' => now(),
        ]);
    }

    public function markAsFailed(string $errorMessage, array $responseData = null): void
    {
        $this->update([
            'status' => self::STATUS_FAILED,
            'error_message' => $errorMessage,
            'response_data' => $responseData,
        ]);
    }

    public function getStatusBadgeColorAttribute(): string
    {
        return match($this->status) {
            self::STATUS_SUCCESS => 'success',
            self::STATUS_FAILED => 'danger',
            self::STATUS_PENDING => 'warning',
            self::STATUS_RETRY => 'info',
            default => 'secondary'
        };
    }

    public function getEventTypeDisplayAttribute(): string
    {
        return match($this->event_type) {
            self::EVENT_CREATED => 'Event Created',
            self::EVENT_UPDATED => 'Event Updated',
            self::EVENT_DELETED => 'Event Deleted',
            self::EVENT_WEBHOOK_RECEIVED => 'Webhook Received',
            default => ucfirst($this->event_type)
        };
    }

    public function getSyncDirectionDisplayAttribute(): string
    {
        return match($this->sync_direction) {
            self::DIRECTION_TO_MICROSOFT => 'To Microsoft',
            self::DIRECTION_FROM_MICROSOFT => 'From Microsoft',
            default => ucfirst($this->sync_direction)
        };
    }
}
