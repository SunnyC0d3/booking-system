<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EnquiryStatusHistory extends Model
{
    use HasFactory;

    protected $table = 'enquiry_status_history';

    protected $fillable = [
        'enquiry_id',
        'previous_status',
        'new_status',
        'changed_by',
        'change_reason',
        'metadata',
        'notes'
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    const CHANGED_BY_SYSTEM = 'system';
    const CHANGED_BY_OWNER = 'owner';
    const CHANGED_BY_WEBHOOK = 'webhook';
    const CHANGED_BY_API = 'api';
    const CHANGED_BY_COMMAND = 'command';
    const REASON_CALENDAR_EVENT_CREATED = 'calendar_event_created';
    const REASON_CALENDAR_EVENT_DELETED = 'calendar_event_deleted';
    const REASON_MANUAL_APPROVAL = 'manual_approval';
    const REASON_MANUAL_DECLINE = 'manual_decline';
    const REASON_EMAIL_ACTION = 'email_action';
    const REASON_WEBHOOK_UPDATE = 'webhook_update';
    const REASON_EXPIRY = 'expiry';
    const REASON_CANCELLATION = 'cancellation';
    const REASON_SYSTEM_UPDATE = 'system_update';

    public function enquiry(): BelongsTo
    {
        return $this->belongsTo(Enquiry::class);
    }

    public function scopeForEnquiry($query, int $enquiryId)
    {
        return $query->where('enquiry_id', $enquiryId);
    }

    public function scopeByChangeSource($query, string $changedBy)
    {
        return $query->where('changed_by', $changedBy);
    }

    public function scopeByReason($query, string $reason)
    {
        return $query->where('change_reason', $reason);
    }

    public function scopeToStatus($query, string $status)
    {
        return $query->where('new_status', $status);
    }

    public function scopeFromStatus($query, string $status)
    {
        return $query->where('previous_status', $status);
    }

    public function scopeRecentFirst($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeSystemChanges($query)
    {
        return $query->whereIn('changed_by', [
            self::CHANGED_BY_SYSTEM,
            self::CHANGED_BY_WEBHOOK,
            self::CHANGED_BY_COMMAND
        ]);
    }

    public function scopeManualChanges($query)
    {
        return $query->whereIn('changed_by', [
            self::CHANGED_BY_OWNER,
            self::CHANGED_BY_API
        ]);
    }

    public function isSystemChange(): bool
    {
        return in_array($this->changed_by, [
            self::CHANGED_BY_SYSTEM,
            self::CHANGED_BY_WEBHOOK,
            self::CHANGED_BY_COMMAND
        ]);
    }

    public function isManualChange(): bool
    {
        return in_array($this->changed_by, [
            self::CHANGED_BY_OWNER,
            self::CHANGED_BY_API
        ]);
    }

    public function isApproval(): bool
    {
        return $this->new_status === Enquiry::STATUS_APPROVED;
    }

    public function isDecline(): bool
    {
        return $this->new_status === Enquiry::STATUS_DECLINED;
    }

    public function isCancellation(): bool
    {
        return $this->new_status === Enquiry::STATUS_CANCELLED;
    }

    public function getChangeDescriptionAttribute(): string
    {
        $from = $this->previous_status ? ucfirst($this->previous_status) : 'Initial';
        $to = ucfirst($this->new_status);

        return "Changed from {$from} to {$to}";
    }

    public function getChangedByDisplayAttribute(): string
    {
        return match($this->changed_by) {
            self::CHANGED_BY_SYSTEM => 'System',
            self::CHANGED_BY_OWNER => 'Business Owner',
            self::CHANGED_BY_WEBHOOK => 'Microsoft Webhook',
            self::CHANGED_BY_API => 'API Call',
            self::CHANGED_BY_COMMAND => 'System Command',
            default => ucfirst($this->changed_by)
        };
    }

    public function getChangeReasonDisplayAttribute(): string
    {
        return match($this->change_reason) {
            self::REASON_CALENDAR_EVENT_CREATED => 'Calendar event created',
            self::REASON_CALENDAR_EVENT_DELETED => 'Calendar event deleted',
            self::REASON_MANUAL_APPROVAL => 'Manually approved',
            self::REASON_MANUAL_DECLINE => 'Manually declined',
            self::REASON_EMAIL_ACTION => 'Action via email link',
            self::REASON_WEBHOOK_UPDATE => 'Microsoft calendar update',
            self::REASON_EXPIRY => 'Enquiry expired',
            self::REASON_CANCELLATION => 'Cancelled by customer',
            self::REASON_SYSTEM_UPDATE => 'System update',
            default => ucfirst(str_replace('_', ' ', $this->change_reason ?? ''))
        };
    }

    public function getStatusBadgeColorAttribute(): string
    {
        return match($this->new_status) {
            Enquiry::STATUS_PENDING => 'warning',
            Enquiry::STATUS_APPROVED => 'success',
            Enquiry::STATUS_DECLINED => 'danger',
            Enquiry::STATUS_CANCELLED => 'secondary',
            default => 'secondary'
        };
    }

    public function hasMetadata(string $key): bool
    {
        return isset($this->metadata[$key]);
    }

    public function getMetadata(string $key, $default = null)
    {
        return $this->metadata[$key] ?? $default;
    }

    public function addMetadata(string $key, $value): void
    {
        $metadata = $this->metadata ?? [];
        $metadata[$key] = $value;
        $this->update(['metadata' => $metadata]);
    }

    public static function logStatusChange(
        int $enquiryId,
        string $newStatus,
        ?string $previousStatus = null,
        string $changedBy = self::CHANGED_BY_SYSTEM,
        ?string $reason = null,
        ?array $metadata = null,
        ?string $notes = null
    ): self {
        return static::create([
            'enquiry_id' => $enquiryId,
            'previous_status' => $previousStatus,
            'new_status' => $newStatus,
            'changed_by' => $changedBy,
            'change_reason' => $reason,
            'metadata' => $metadata,
            'notes' => $notes,
        ]);
    }
}
