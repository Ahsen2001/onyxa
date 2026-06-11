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
            ['key' => 'company_email', 'value' => 'info@onyxa.com', 'type' => 'email', 'group_name' => 'contact'],
            ['key' => 'company_phone', 'value' => '+94 00 000 0000', 'type' => 'phone', 'group_name' => 'contact'],
            ['key' => 'company_address', 'value' => 'Sri Lanka', 'type' => 'textarea', 'group_name' => 'contact'],
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
