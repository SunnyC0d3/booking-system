<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EnquiryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'resource' => [
                'id' => $this->resource->id,
                'name' => $this->resource->name,
                'description' => $this->resource->description,
            ],
            'preferred_date' => $this->preferred_date?->toDateString(),
            'preferred_start_time' => $this->preferred_start_time,
            'preferred_end_time' => $this->preferred_end_time,
            'customer_info' => [
                'name' => $this->customer_name,
                'email' => $this->customer_email,
                'phone' => $this->customer_phone,
                'company' => $this->customer_company,
            ],
            'message' => $this->message,
            'status' => $this->status,
            'status_badge_color' => $this->status_badge_color,
            'expires_at' => $this->expires_at?->toISOString(),
            'is_expired' => $this->isExpired(),
            'is_urgent' => $this->expires_at ? $this->expires_at->diffInDays(now()) <= 3 : false,
            'calendar_sync' => [
                'enabled' => $this->calendar_sync_enabled,
                'status' => $this->calendar_sync_status,
                'synced_at' => $this->calendar_synced_at?->toISOString(),
                'has_microsoft_event' => $this->hasMicrosoftEvent(),
                'microsoft_event_id' => $this->microsoft_event_id,
            ],
            'created_at' => $this->created_at->toISOString(),
            'updated_at' => $this->updated_at->toISOString(),
            'status_history' => $this->whenLoaded('statusHistory', function () {
                return $this->statusHistory->map(function ($history) {
                    return [
                        'id' => $history->id,
                        'previous_status' => $history->previous_status,
                        'new_status' => $history->new_status,
                        'changed_by' => $history->changed_by_display,
                        'change_reason' => $history->change_reason_display,
                        'notes' => $history->notes,
                        'created_at' => $history->created_at->toISOString(),
                    ];
                });
            }),
            'sync_logs' => $this->whenLoaded('syncLogs', function () {
                return $this->syncLogs->map(function ($log) {
                    return [
                        'id' => $log->id,
                        'event_type' => $log->event_type_display,
                        'sync_direction' => $log->sync_direction_display,
                        'status' => $log->status,
                        'status_badge_color' => $log->status_badge_color,
                        'error_message' => $log->error_message,
                        'retry_count' => $log->retry_count,
                        'synced_at' => $log->synced_at?->toISOString(),
                        'created_at' => $log->created_at->toISOString(),
                    ];
                });
            }),
        ];
    }
}
