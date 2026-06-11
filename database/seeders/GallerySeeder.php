<?php

namespace Database\Seeders;

use App\Models\Gallery;
use App\Models\GalleryCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['category' => 'Workshop', 'title' => 'Hand Sanding Coconut Shells'],
            ['category' => 'Products', 'title' => 'Finished Coconut Shell Bowls'],
            ['category' => 'Events', 'title' => 'ONYXA Craft Display'],
            ['category' => 'Sustainability', 'title' => 'Natural Shell Material Sorting'],
        ];

        foreach ($items as $index => $item) {
            $category = GalleryCategory::where('name', $item['category'])->first();
            $slug = Str::slug($item['title']);

            Gallery::updateOrCreate(
                ['title' => $item['title']],
                [
                    'gallery_category_id' => $category?->id,
                    'title' => $item['title'],
                    'image' => 'placeholders/onyxa-coconut-shell.svg',
                    'description' => 'A visual moment from ONYXA coconut shell handicraft production.',
                    'alt_text' => $item['title'].' at ONYXA',
                    'caption' => $item['title'],
                    'sort_order' => $index + 1,
                    'status' => 'active',
                ]
            );
        }
    }
}
