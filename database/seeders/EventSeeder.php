<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@onyxa.com')->first();

        $events = [
            [
                'title' => 'Sustainable Handicraft Showcase',
                'description' => 'A live showcase of ONYXA coconut shell products, artisan techniques, and eco-friendly gifting ideas.',
                'location' => 'Colombo Eco Market',
                'event_date' => now()->addDays(21)->toDateString(),
                'event_time' => '10:00:00',
                'status' => 'upcoming',
            ],
            [
                'title' => 'Coconut Shell Craft Workshop',
                'description' => 'An introductory workshop on transforming coconut shells into polished handmade decor pieces.',
                'location' => 'ONYXA Workshop',
                'event_date' => now()->addDays(45)->toDateString(),
                'event_time' => '14:00:00',
                'status' => 'upcoming',
            ],
            [
                'title' => 'Local Artisan Fair 2026',
                'description' => 'ONYXA presented a curated selection of sustainable coconut shell products at a local artisan fair.',
                'location' => 'Galle Craft Hall',
                'event_date' => now()->subDays(20)->toDateString(),
                'event_time' => '09:30:00',
                'status' => 'completed',
            ],
        ];

        foreach ($events as $event) {
            $slug = Str::slug($event['title']);
            Event::updateOrCreate(
                ['slug' => $slug],
                [
                    'user_id' => $admin?->id,
                    'title' => $event['title'],
                    'description' => $event['description'],
                    'location' => $event['location'],
                    'event_date' => $event['event_date'],
                    'event_time' => $event['event_time'],
                    'featured_image' => 'placeholders/onyxa-coconut-shell.svg',
                    'status' => $event['status'],
                    'meta_title' => $event['title'].' | ONYXA Events',
                    'meta_description' => Str::limit($event['description'], 155),
                ]
            );
        }
    }
}
