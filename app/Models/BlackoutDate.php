<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlackoutDate extends Model
{
    use HasFactory;

    protected $fillable = [
        'resource_id',
        'date',
        'reason',
        'recurring_yearly'
    ];

    protected $casts = [
        'date' => 'date',
        'recurring_yearly' => 'boolean',
    ];

    public function resource(): BelongsTo
    {
        return $this->belongsTo(Resource::class);
    }

    public function scopeForResource($query, $resourceId)
    {
        return $query->where(function ($q) use ($resourceId) {
            $q->whereNull('resource_id')->orWhere('resource_id', $resourceId);
        });
    }
}
