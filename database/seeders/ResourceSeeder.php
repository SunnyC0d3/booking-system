<?php

namespace Database\Seeders;

use App\Models\Resource;
use Illuminate\Database\Seeder;

class ResourceSeeder extends Seeder
{
    public function run(): void
    {
        Resource::create([
            'name' => 'Meeting Room A',
            'description' => 'A small meeting room for up to 4 people.',
            'capacity' => 4,
            'availability_rules' => json_encode([
                'monday' => ['09:00-17:00'],
                'tuesday' => ['09:00-17:00'],
                'wednesday' => ['09:00-17:00'],
                'thursday' => ['09:00-17:00'],
                'friday' => ['09:00-17:00'],
            ]),
        ]);

        Resource::create([
            'name' => 'Conference Hall',
            'description' => 'Large hall for events up to 50 people.',
            'capacity' => 50,
            'availability_rules' => json_encode([
                'monday' => ['08:00-20:00'],
                'tuesday' => ['08:00-20:00'],
                'wednesday' => ['08:00-20:00'],
                'thursday' => ['08:00-20:00'],
                'friday' => ['08:00-20:00'],
            ]),
        ]);
    }
}
