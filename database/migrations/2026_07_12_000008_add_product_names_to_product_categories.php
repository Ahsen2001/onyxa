<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_categories', function (Blueprint $table): void {
            if (! Schema::hasColumn('product_categories', 'product_names')) {
                $table->json('product_names')->nullable()->after('description');
            }
        });

        foreach ($this->categories() as $index => $category) {
            $slug = Str::slug($category['name']);
            $existingId = DB::table('product_categories')->where('slug', $slug)->value('id');

            if ($existingId) {
                DB::table('product_categories')->where('id', $existingId)->update([
                    'name' => $category['name'],
                    'description' => $category['description'],
                    'product_names' => json_encode($category['product_names']),
                    'sort_order' => $index + 1,
                    'status' => 'active',
                    'updated_at' => now(),
                ]);

                continue;
            }

            DB::table('product_categories')->insert([
                'name' => $category['name'],
                'slug' => $slug,
                'description' => $category['description'],
                'product_names' => json_encode($category['product_names']),
                'sort_order' => $index + 1,
                'status' => 'active',
                'updated_at' => now(),
                'created_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('product_categories', function (Blueprint $table): void {
            if (Schema::hasColumn('product_categories', 'product_names')) {
                $table->dropColumn('product_names');
            }
        });
    }

    private function categories(): array
    {
        return [
            [
                'name' => 'Kitchen & Dining',
                'description' => 'Eco-friendly kitchenware made from coconut shells.',
                'product_names' => ['Coconut Shell Bowls', 'Cups & Mugs', 'Plates', 'Spoons', 'Serving Trays', 'Coasters', 'Salad Bowls'],
            ],
            [
                'name' => 'Home Décor',
                'description' => 'Handcrafted decorative products.',
                'product_names' => ['Decorative Bowls', 'Candle Holders', 'Flower Vases', 'Wall Art', 'Hanging Decorations', 'Table Decorations', 'Decorative Ornaments'],
            ],
            [
                'name' => 'Lighting',
                'description' => 'Handmade lighting solutions.',
                'product_names' => ['Hanging Lamps', 'Pendant Lights', 'Table Lamps', 'Ceiling Lamps', 'Lanterns', 'Decorative Light Shades'],
            ],
            [
                'name' => 'Fashion & Accessories',
                'description' => 'Handcrafted wearable accessories.',
                'product_names' => ['Necklaces', 'Bracelets', 'Earrings', 'Rings', 'Keychains', 'Hair Accessories', 'Pendants'],
            ],
            [
                'name' => 'Gift & Souvenir Collection',
                'description' => 'Customized and premium gift items.',
                'product_names' => ['Gift Sets', 'Souvenirs', 'Corporate Gifts', 'Wedding Gifts', 'Customized Gifts'],
            ],
            [
                'name' => 'Coconut Shell Charcoal',
                'description' => 'High-quality charcoal for domestic and industrial use.',
                'product_names' => ['Lump Charcoal', 'BBQ Charcoal', 'Restaurant Charcoal', 'Industrial Charcoal', 'Charcoal Powder'],
            ],
            [
                'name' => 'Charcoal Briquettes',
                'description' => 'Compressed charcoal products for various applications.',
                'product_names' => ['Cube Briquettes', 'Shisha (Hookah) Charcoal Cubes', 'BBQ Briquettes', 'Hexagonal Briquettes', 'Finger Briquettes', 'Pillow Briquettes'],
            ],
            [
                'name' => 'Activated Carbon (Optional)',
                'description' => 'For industrial and filtration applications.',
                'product_names' => ['Activated Carbon Powder', 'Granular Activated Carbon', 'Water Filter Carbon', 'Air Purification Carbon', 'Industrial Activated Carbon'],
            ],
            [
                'name' => 'Custom Manufacturing & Export',
                'description' => 'Products and services tailored for international buyers.',
                'product_names' => ['OEM Manufacturing', 'Private Label Production', 'Bulk Orders', 'Custom Product Design', 'Export Packaging', 'International Shipping Support'],
            ],
        ];
    }
};
