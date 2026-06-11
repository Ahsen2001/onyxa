<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@onyxa.com')->first();

        $posts = [
            [
                'title' => 'ONYXA Expands Coconut Shell Craft Collection',
                'short_description' => 'New handmade home decor and gift products are now available for sustainable lifestyle buyers.',
                'content' => 'ONYXA Private Limited has expanded its coconut shell handicraft collection with refined bowls, cups, decor pieces, and gift items made by skilled artisans.',
                'published_at' => now()->subDays(8),
            ],
            [
                'title' => 'Artisans Introduce Natural Polishing Process',
                'short_description' => 'The production team has improved finishing quality while keeping materials natural and low waste.',
                'content' => 'Our workshop team continues to refine sanding and polishing methods that highlight the shell texture without hiding its organic character.',
                'published_at' => now()->subDays(3),
            ],
        ];

        foreach ($posts as $post) {
            $slug = Str::slug($post['title']);
            News::updateOrCreate(
                ['slug' => $slug],
                [
                    'user_id' => $admin?->id,
                    'title' => $post['title'],
                    'short_description' => $post['short_description'],
                    'content' => $post['content'],
                    'featured_image' => 'placeholders/onyxa-coconut-shell.svg',
                    'status' => 'published',
                    'published_at' => $post['published_at'],
                    'meta_title' => $post['title'].' | ONYXA News',
                    'meta_description' => $post['short_description'],
                ]
            );
        }
    }
}
