<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Advantage;
use App\Models\Setting;

class AdvantageSeeder extends Seeder
{
    public function run(): void
    {
        // Insert default settings
        $settings = [
            ['key' => 'advantages_section_enabled', 'value' => '1', 'group' => 'advantages'],
            ['key' => 'advantages_title', 'value' => 'Keunggulan Kami', 'group' => 'advantages'],
            ['key' => 'advantages_subtitle', 'value' => 'Politeknik Praktisi Bandung menawarkan berbagai keunggulan yang membedakan kami dari institusi pendidikan lainnya.', 'group' => 'advantages'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value'], 'group' => $setting['group']]
            );
        }

        // Insert sample advantages
        $advantages = [
            [
                'title' => 'Kurikulum Berbasis Industri',
                'description' => 'Kurikulum yang dirancang bersama praktisi industri untuk memastikan relevansi dan kesesuaian dengan kebutuhan pasar kerja.',
                'icon' => 'fa-graduation-cap',
                'icon_color' => '#3498db',
                'is_active' => true,
                'order' => 0
            ],
            [
                'title' => 'Dosen Praktisi',
                'description' => 'Dosen yang merupakan praktisi aktif di industri, memberikan wawasan dan pengalaman nyata kepada mahasiswa.',
                'icon' => 'fa-users',
                'icon_color' => '#27ae60',
                'is_active' => true,
                'order' => 1
            ],
            [
                'title' => 'Pembelajaran Berbasis Praktik',
                'description' => 'Fokus pada pembelajaran praktis dengan proporsi praktikum yang lebih besar dibandingkan teori.',
                'icon' => 'fa-book',
                'icon_color' => '#e74c3c',
                'is_active' => true,
                'order' => 2
            ],
            [
                'title' => 'Sertifikasi Profesi',
                'description' => 'Program sertifikasi profesi terintegrasi dalam kurikulum untuk meningkatkan daya saing lulusan.',
                'icon' => 'fa-certificate',
                'icon_color' => '#f39c12',
                'is_active' => true,
                'order' => 3
            ],
            [
                'title' => 'Magang Industri',
                'description' => 'Program magang industri yang ekstensif untuk memberikan pengalaman kerja nyata sebelum lulus.',
                'icon' => 'fa-briefcase',
                'icon_color' => '#9b59b6',
                'is_active' => true,
                'order' => 4
            ],
            [
                'title' => 'Penempatan Kerja',
                'description' => 'Jaringan kerjasama dengan industri untuk memfasilitasi penempatan kerja bagi lulusan.',
                'icon' => 'fa-handshake',
                'icon_color' => '#1abc9c',
                'is_active' => true,
                'order' => 5
            ],
        ];

        foreach ($advantages as $advantage) {
            Advantage::create($advantage);
        }
    }
}
