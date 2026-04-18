<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'Akademi Keperawatan', 'type' => 'text', 'group' => 'general'],
            ['key' => 'site_tagline', 'value' => 'Excellence in Nursing Education', 'type' => 'text', 'group' => 'general'],
            ['key' => 'site_description', 'value' => 'Leading nursing academy committed to quality education', 'type' => 'textarea', 'group' => 'general'],
            ['key' => 'about_us', 'value' => 'Dengan pengalaman bertahun-tahun dalam pendidikan keperawatan, kami menyediakan program akademik yang komprehensif dan fasilitas modern untuk mendukung pembelajaran mahasiswa.', 'type' => 'editor', 'group' => 'general'],
            ['key' => 'about_image', 'value' => '', 'type' => 'image', 'group' => 'general'],
            ['key' => 'contact_email', 'value' => 'info@akper.ac.id', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'contact_phone', 'value' => '+62 21 1234567', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'contact_address', 'value' => 'Jl. Pendidikan No. 123, Jakarta', 'type' => 'textarea', 'group' => 'contact'],
            ['key' => 'facebook_url', 'value' => '', 'type' => 'text', 'group' => 'social'],
            ['key' => 'twitter_url', 'value' => '', 'type' => 'text', 'group' => 'social'],
            ['key' => 'instagram_url', 'value' => '', 'type' => 'text', 'group' => 'social'],
            ['key' => 'youtube_url', 'value' => '', 'type' => 'text', 'group' => 'social'],
            ['key' => 'linkedin_url', 'value' => '', 'type' => 'text', 'group' => 'social'],
            ['key' => 'tiktok_url', 'value' => '', 'type' => 'text', 'group' => 'social'],
            ['key' => 'whatsapp_number', 'value' => '', 'type' => 'text', 'group' => 'social'],
        ];

        foreach ($settings as $setting) {
            \App\Models\Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
