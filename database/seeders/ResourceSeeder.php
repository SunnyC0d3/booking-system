<?php

namespace Database\Seeders;

use App\Models\Resource;
use Illuminate\Database\Seeder;

class ResourceSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🏢 Creating bookable resources...');

        $resources = $this->getResourceData();
        $resourcesCreated = 0;

        foreach ($resources as $resourceData) {
            Resource::create([
                'name' => $resourceData['name'],
                'description' => $resourceData['description'],
                'capacity' => $resourceData['capacity'],
                'availability_rules' => $resourceData['availability_rules'],
            ]);

            $this->command->line("  ✅ {$resourceData['name']} (Capacity: {$resourceData['capacity']})");
            $resourcesCreated++;
        }

        $this->command->info("🎉 Created {$resourcesCreated} resources with diverse availability patterns");
    }

    private function getResourceData(): array
    {
        return [
            [
                'name' => 'Meeting Room A',
                'description' => 'Intimate meeting space for small teams. Equipped with whiteboard, 55" display, and video conferencing.',
                'capacity' => 4,
                'availability_rules' => [
                    'monday' => ['09:00-17:00'],
                    'tuesday' => ['09:00-17:00'],
                    'wednesday' => ['09:00-17:00'],
                    'thursday' => ['09:00-17:00'],
                    'friday' => ['09:00-17:00'],
                    'saturday' => [],
                    'sunday' => [],
                ],
            ],
            [
                'name' => 'Meeting Room B',
                'description' => 'Cozy meeting room perfect for client calls and one-on-ones. Features modern furniture and natural lighting.',
                'capacity' => 6,
                'availability_rules' => [
                    'monday' => ['08:30-17:30'],
                    'tuesday' => ['08:30-17:30'],
                    'wednesday' => ['08:30-17:30'],
                    'thursday' => ['08:30-17:30'],
                    'friday' => ['08:30-17:30'],
                    'saturday' => [],
                    'sunday' => [],
                ],
            ],
            [
                'name' => 'Executive Conference Room',
                'description' => 'Premium boardroom with mahogany table, leather chairs, and state-of-the-art presentation technology.',
                'capacity' => 12,
                'availability_rules' => [
                    'monday' => ['07:00-21:00'],
                    'tuesday' => ['07:00-21:00'],
                    'wednesday' => ['07:00-21:00'],
                    'thursday' => ['07:00-21:00'],
                    'friday' => ['07:00-21:00'],
                    'saturday' => ['09:00-18:00'],
                    'sunday' => [],
                ],
            ],
            [
                'name' => 'Main Conference Hall',
                'description' => 'Spacious auditorium-style venue for large presentations, seminars, and company events. Full A/V equipment included.',
                'capacity' => 50,
                'availability_rules' => [
                    'monday' => ['08:00-20:00'],
                    'tuesday' => ['08:00-20:00'],
                    'wednesday' => ['08:00-20:00'],
                    'thursday' => ['08:00-20:00'],
                    'friday' => ['08:00-20:00'],
                    'saturday' => ['10:00-18:00'],
                    'sunday' => ['12:00-17:00'],
                ],
            ],
            [
                'name' => 'Innovation Lab',
                'description' => 'Creative workshop space with moveable furniture, whiteboards, and brainstorming tools. Perfect for design sprints.',
                'capacity' => 8,
                'availability_rules' => [
                    'monday' => ['09:00-18:00'],
                    'tuesday' => ['09:00-18:00'],
                    'wednesday' => ['09:00-18:00'],
                    'thursday' => ['09:00-18:00'],
                    'friday' => ['09:00-18:00'],
                    'saturday' => ['10:00-16:00'],
                    'sunday' => [],
                ],
            ],

            [
                'name' => 'Training Center',
                'description' => 'Multi-purpose training facility with classroom seating, projector, sound system, and breakout areas.',
                'capacity' => 25,
                'availability_rules' => [
                    'monday' => ['08:00-19:00'],
                    'tuesday' => ['08:00-19:00'],
                    'wednesday' => ['08:00-19:00'],
                    'thursday' => ['08:00-19:00'],
                    'friday' => ['08:00-19:00'],
                    'saturday' => ['09:00-17:00'],
                    'sunday' => [],
                ],
            ],
            [
                'name' => 'Grand Ballroom',
                'description' => 'Elegant event space for large corporate functions, award ceremonies, and special events. Professional catering kitchen adjacent.',
                'capacity' => 100,
                'availability_rules' => [
                    'monday' => ['10:00-22:00'],
                    'tuesday' => ['10:00-22:00'],
                    'wednesday' => ['10:00-22:00'],
                    'thursday' => ['10:00-22:00'],
                    'friday' => ['10:00-23:00'],
                    'saturday' => ['09:00-23:00'],
                    'sunday' => ['10:00-20:00'],
                ],
            ],
            [
                'name' => 'CEO Private Office',
                'description' => 'Executive office space available for high-level meetings and confidential discussions. Requires approval.',
                'capacity' => 1,
                'availability_rules' => [
                    'monday' => ['09:00-17:00'],
                    'tuesday' => ['09:00-17:00'],
                    'wednesday' => ['09:00-17:00'],
                    'thursday' => ['09:00-17:00'],
                    'friday' => ['09:00-15:00'],
                    'saturday' => [],
                    'sunday' => [],
                ],
            ],
            [
                'name' => 'Collaboration Hub',
                'description' => 'Open-plan collaborative workspace with flexible seating, standing desks, and multiple work zones.',
                'capacity' => 15,
                'availability_rules' => [
                    'monday' => ['07:00-19:00'],
                    'tuesday' => ['07:00-19:00'],
                    'wednesday' => ['07:00-19:00'],
                    'thursday' => ['07:00-19:00'],
                    'friday' => ['07:00-18:00'],
                    'saturday' => ['09:00-17:00'],
                    'sunday' => ['10:00-16:00'],
                ],
            ],
            [
                'name' => 'Wellness Room',
                'description' => 'Quiet space for meditation, wellness sessions, and mental health breaks. Soft lighting and comfortable seating.',
                'capacity' => 6,
                'availability_rules' => [
                    'monday' => ['12:00-14:00', '16:00-18:00'],
                    'tuesday' => ['12:00-14:00', '16:00-18:00'],
                    'wednesday' => ['12:00-14:00', '16:00-18:00'],
                    'thursday' => ['12:00-14:00', '16:00-18:00'],
                    'friday' => ['12:00-15:00'],
                    'saturday' => [],
                    'sunday' => [],
                ],
            ],
        ];
    }
}
