<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class ThemeSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $themeSettings = [
            // Primary Colors
            [
                'key' => 'theme_primary_color',
                'value' => '#1e90ff',
                'type' => 'color',
                'group' => 'theme',
            ],
            [
                'key' => 'theme_secondary_color',
                'value' => '#6c757d',
                'type' => 'color',
                'group' => 'theme',
            ],
            [
                'key' => 'theme_success_color',
                'value' => '#198754',
                'type' => 'color',
                'group' => 'theme',
            ],
            [
                'key' => 'theme_danger_color',
                'value' => '#dc3545',
                'type' => 'color',
                'group' => 'theme',
            ],
            [
                'key' => 'theme_warning_color',
                'value' => '#ffc107',
                'type' => 'color',
                'group' => 'theme',
            ],
            [
                'key' => 'theme_info_color',
                'value' => '#0dcaf0',
                'type' => 'color',
                'group' => 'theme',
            ],
            // Topbar Colors
            [
                'key' => 'theme_topbar_bg_color',
                'value' => '#1a1a2e',
                'type' => 'color',
                'group' => 'theme',
            ],
            [
                'key' => 'theme_topbar_text_color',
                'value' => '#e0e0e0',
                'type' => 'color',
                'group' => 'theme',
            ],
            // Header Menu Colors
            [
                'key' => 'theme_header_bg_color',
                'value' => '#ffffff',
                'type' => 'color',
                'group' => 'theme',
            ],
            [
                'key' => 'theme_header_text_color',
                'value' => '#212529',
                'type' => 'color',
                'group' => 'theme',
            ],
            // Footer Colors
            [
                'key' => 'theme_footer_bg_color',
                'value' => '#003366',
                'type' => 'color',
                'group' => 'theme',
            ],
            [
                'key' => 'theme_footer_text_color',
                'value' => '#ffffff',
                'type' => 'color',
                'group' => 'theme',
            ],
            // Button Colors
            [
                'key' => 'theme_button_bg_color',
                'value' => '#1e90ff',
                'type' => 'color',
                'group' => 'theme',
            ],
            [
                'key' => 'theme_button_text_color',
                'value' => '#ffffff',
                'type' => 'color',
                'group' => 'theme',
            ],
            // Link Colors
            [
                'key' => 'theme_link_color',
                'value' => '#1e90ff',
                'type' => 'color',
                'group' => 'theme',
            ],
            [
                'key' => 'theme_link_hover_color',
                'value' => '#0066cc',
                'type' => 'color',
                'group' => 'theme',
            ],
        ];

        foreach ($themeSettings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
