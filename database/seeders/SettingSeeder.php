<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'company_name', 'value' => 'ONYXA Private Limited', 'type' => 'text', 'group_name' => 'company'],
            ['key' => 'tagline', 'value' => 'Crafting Nature into Timeless Art', 'type' => 'text', 'group_name' => 'company'],
            ['key' => 'email', 'value' => 'info@onyxa.com', 'type' => 'email', 'group_name' => 'contact'],
            ['key' => 'phone', 'value' => '+94 00 000 0000', 'type' => 'phone', 'group_name' => 'contact'],
            ['key' => 'whatsapp', 'value' => '+94 00 000 0000', 'type' => 'phone', 'group_name' => 'contact'],
            ['key' => 'address', 'value' => 'Sri Lanka', 'type' => 'textarea', 'group_name' => 'contact'],
            ['key' => 'business_hours', 'value' => 'Monday - Friday, 9.00 AM - 5.00 PM', 'type' => 'text', 'group_name' => 'contact'],
            ['key' => 'logo', 'value' => null, 'type' => 'image', 'group_name' => 'brand'],
            ['key' => 'favicon', 'value' => null, 'type' => 'image', 'group_name' => 'brand'],
            ['key' => 'google_map_embed', 'value' => null, 'type' => 'textarea', 'group_name' => 'contact'],
            ['key' => 'footer_text', 'value' => 'Crafting refined coconut shell handicrafts that celebrate Sri Lankan artistry, natural textures, and sustainable living.', 'type' => 'textarea', 'group_name' => 'company'],
            ['key' => 'facebook_url', 'value' => null, 'type' => 'url', 'group_name' => 'social'],
            ['key' => 'instagram_url', 'value' => null, 'type' => 'url', 'group_name' => 'social'],
            ['key' => 'linkedin_url', 'value' => null, 'type' => 'url', 'group_name' => 'social'],
            ['key' => 'youtube_url', 'value' => null, 'type' => 'url', 'group_name' => 'social'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
