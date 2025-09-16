<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = ['resource_id', 'start_time', 'end_time', 'customer_info', 'status'];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'customer_info' => 'array',
    ];

    public function resource(): BelongsTo
    {
        return $this->belongsTo(Resource::class);
    }
}
