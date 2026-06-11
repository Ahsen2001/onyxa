<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'category' => 'Home Decor',
                'name' => 'Polished Coconut Shell Bowl',
                'short_description' => 'A smooth handmade bowl for decor, dry snacks, or sustainable gifting.',
                'description' => 'Each bowl is cut, sanded, polished, and finished by hand to preserve the natural grain of the coconut shell.',
                'price' => 1850,
                'material' => 'Natural coconut shell, food-safe polish',
                'size' => 'Approx. 12 cm diameter',
                'is_featured' => true,
            ],
            [
                'category' => 'Kitchenware',
                'name' => 'Coconut Shell Cup Set',
                'short_description' => 'Rustic reusable cups made for juice, smoothies, and tropical table settings.',
                'description' => 'A lightweight cup set shaped from selected coconut shells and finished with a natural surface treatment.',
                'price' => 3200,
                'material' => 'Coconut shell and coconut wood base',
                'size' => 'Set of 2',
                'is_featured' => true,
            ],
            [
                'category' => 'Gift Items',
                'name' => 'Eco Gift Hamper Bowl',
                'short_description' => 'A curated handcrafted coconut shell gift piece for conscious celebrations.',
                'description' => 'Designed for corporate gifts, wedding favors, and boutique retail displays with sustainable presentation.',
                'price' => 4500,
                'material' => 'Coconut shell, natural fiber packaging',
                'size' => 'Medium gift box',
                'is_featured' => true,
            ],
            [
                'category' => 'Jewelry & Accessories',
                'name' => 'Coconut Shell Pendant',
                'short_description' => 'A minimal handcrafted pendant with warm natural tones.',
                'description' => 'Cut from coconut shell offcuts and polished into a lightweight accessory for everyday wear.',
                'price' => 950,
                'material' => 'Coconut shell and cotton cord',
                'size' => 'Adjustable cord',
                'is_featured' => false,
            ],
        ];

        foreach ($products as $index => $item) {
            $category = ProductCategory::where('name', $item['category'])->first();

            if (! $category) {
                continue;
            }

            $slug = Str::slug($item['name']);
            $product = Product::updateOrCreate(
                ['slug' => $slug],
                [
                    'product_category_id' => $category->id,
                    'name' => $item['name'],
                    'sku' => 'ONYXA-'.str_pad((string) ($index + 1), 3, '0', STR_PAD_LEFT),
                    'short_description' => $item['short_description'],
                    'description' => $item['description'],
                    'price' => $item['price'],
                    'main_image' => 'placeholders/onyxa-coconut-shell.svg',
                    'material' => $item['material'],
                    'size' => $item['size'],
                    'availability' => 'available',
                    'is_featured' => $item['is_featured'],
                    'status' => 'published',
                    'meta_title' => $item['name'].' | ONYXA Coconut Shell Handicrafts',
                    'meta_description' => $item['short_description'],
                ]
            );

            $product->images()->updateOrCreate(
                ['sort_order' => 1],
                [
                    'image' => 'placeholders/onyxa-coconut-shell.svg',
                    'alt_text' => $item['name'].' handmade detail',
                ]
            );
        }
    }
}
