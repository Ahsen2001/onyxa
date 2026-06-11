<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            SettingSeeder::class,
            ProductCategorySeeder::class,
            ProductSeeder::class,
            NewsSeeder::class,
            EventSeeder::class,
            GalleryCategorySeeder::class,
            GallerySeeder::class,
            PageSeeder::class,
        ]);
    }
}
