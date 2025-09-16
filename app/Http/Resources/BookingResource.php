<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'           => $this->id,
            'resource_id'  => $this->resource_id,
            'resource'     => new ResourceResource($this->whenLoaded('resource')),
            'start_time'   => $this->start_time->toIso8601String(),
            'end_time'     => $this->end_time->toIso8601String(),
            'customer_info'=> $this->customer_info,
            'status'       => $this->status,
            'created_at'   => $this->created_at->toIso8601String(),
        ];
    }
}
