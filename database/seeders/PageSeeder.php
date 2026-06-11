<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            ['page_key' => 'home', 'section_key' => 'introduction', 'title' => 'Crafting Nature into Timeless Art', 'content' => 'ONYXA transforms coconut shells into refined handmade products for homes, gifts, and sustainable lifestyles.'],
            ['page_key' => 'about', 'section_key' => 'about_us', 'title' => 'About ONYXA', 'content' => 'ONYXA Private Limited creates eco-friendly coconut shell handicrafts by transforming natural coconut shells into beautiful handmade products.'],
            ['page_key' => 'about', 'section_key' => 'vision', 'title' => 'Our Vision', 'content' => 'To become a trusted sustainable handicraft brand known for natural materials, artisan quality, and thoughtful design.'],
            ['page_key' => 'about', 'section_key' => 'mission', 'title' => 'Our Mission', 'content' => 'To support skilled craftsmanship, reduce material waste, and deliver coconut shell products that bring natural beauty into everyday life.'],
            ['page_key' => 'sustainability', 'section_key' => 'sustainability', 'title' => 'Sustainability Commitment', 'content' => 'We give coconut shells a second life by creating useful, durable, and beautiful products from an agricultural by-product.'],
            ['page_key' => 'footer', 'section_key' => 'description', 'title' => 'Footer Description', 'content' => 'Crafting refined coconut shell handicrafts that celebrate Sri Lankan artistry, natural textures, and sustainable living.'],
        ];

        foreach ($sections as $section) {
            Page::updateOrCreate(
                ['page_key' => $section['page_key'], 'section_key' => $section['section_key']],
                [
                    'title' => $section['title'],
                    'slug' => Str::slug($section['page_key'].'-'.$section['section_key']),
                    'content' => $section['content'],
                    'image' => 'placeholders/onyxa-coconut-shell.svg',
                    'meta_title' => $section['title'].' | ONYXA Private Limited',
                    'meta_description' => Str::limit($section['content'], 155),
                    'status' => 'published',
                ]
            );
        }
    }
}
