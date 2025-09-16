<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Resource;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $resource = Resource::first();

        Booking::create([
            'resource_id' => $resource->id,
            'start_time' => Carbon::today()->setTime(10, 0),
            'end_time' => Carbon::today()->setTime(11, 0),
            'customer_info' => [
                'name' => 'Alice Example',
                'email' => 'alice@example.com',
            ],
            'status' => 'confirmed',
        ]);
    }
}
