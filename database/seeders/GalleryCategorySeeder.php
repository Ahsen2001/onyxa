<?php

namespace Database\Seeders;

use App\Models\GalleryCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GalleryCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Workshop', 'Products', 'Events', 'Sustainability'];

        foreach ($categories as $index => $name) {
            GalleryCategory::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'description' => $name.' gallery images from ONYXA Private Limited.',
                    'sort_order' => $index + 1,
                    'status' => 'active',
                ]
            );
        }
    }
}
