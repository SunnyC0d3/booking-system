<?php

namespace Database\Seeders;

use App\Models\AvailabilitySlot;
use App\Models\Resource;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class AvailabilitySeeder extends Seeder
{
    public function run(): void
    {
        $resource = Resource::first();

        // Example: make today available from 9–12 and 13–17
        $date = Carbon::today()->toDateString();

        AvailabilitySlot::create([
            'resource_id' => $resource->id,
            'date' => $date,
            'start_time' => '09:00:00',
            'end_time' => '12:00:00',
            'is_available' => true,
        ]);

        AvailabilitySlot::create([
            'resource_id' => $resource->id,
            'date' => $date,
            'start_time' => '13:00:00',
            'end_time' => '17:00:00',
            'is_available' => true,
        ]);
    }
}
