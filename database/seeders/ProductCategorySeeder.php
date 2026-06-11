<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Home Decor', 'description' => 'Bowls, candle holders, and accent pieces made from polished coconut shells.'],
            ['name' => 'Kitchenware', 'description' => 'Natural coconut shell cups, spoons, serving bowls, and tableware.'],
            ['name' => 'Gift Items', 'description' => 'Handmade sustainable gifts for events, hotels, and conscious shoppers.'],
            ['name' => 'Jewelry & Accessories', 'description' => 'Lightweight coconut shell accessories with handcrafted finishes.'],
        ];

        foreach ($categories as $index => $category) {
            ProductCategory::updateOrCreate(
                ['slug' => Str::slug($category['name'])],
                [
                    'name' => $category['name'],
                    'description' => $category['description'],
                    'image' => 'placeholders/onyxa-coconut-shell.svg',
                    'sort_order' => $index + 1,
                    'status' => 'active',
                ]
            );
        }
    }
}
