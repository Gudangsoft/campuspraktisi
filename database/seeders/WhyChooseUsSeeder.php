<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\WhyChooseUs;

class WhyChooseUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cards = [
            [
                'icon' => 'fa-graduation-cap',
                'title' => 'KULIAH PRAKTIS',
                'subtitle' => 'Dengan Metode Modern',
                'icon_color' => '#3498db',
                'background_color' => '#ffffff',
                'order' => 0,
                'is_active' => true,
                'features' => [
                    'Jadwal kuliah yang fleksibel',
                    'Pembelajaran berbasis praktik',
                    'Dosen berpengalaman di industri',
                    'Fasilitas laboratorium lengkap'
                ]
            ],
            [
                'icon' => 'fa-briefcase',
                'title' => 'INSTAN KERJA',
                'subtitle' => 'Siap Berkarir',
                'icon_color' => '#e74c3c',
                'background_color' => '#ffffff',
                'order' => 1,
                'is_active' => true,
                'features' => [
                    'Program magang di perusahaan ternama',
                    'Job placement assistance',
                    'Network alumni yang luas',
                    'Sertifikasi kompetensi industri'
                ]
            ],
            [
                'icon' => 'fa-rocket',
                'title' => 'KARIR MANDIRI',
                'subtitle' => 'Jadi Entrepreneur',
                'icon_color' => '#f39c12',
                'background_color' => '#ffffff',
                'order' => 2,
                'is_active' => true,
                'features' => [
                    'Inkubator bisnis untuk startup',
                    'Mentoring dari praktisi sukses',
                    'Akses ke investor dan funding',
                    'Workshop kewirausahaan rutin'
                ]
            ]
        ];

        foreach ($cards as $cardData) {
            $features = $cardData['features'];
            unset($cardData['features']);

            $card = WhyChooseUs::create($cardData);

            // Add features
            foreach ($features as $index => $featureText) {
                $card->features()->create([
                    'feature_text' => $featureText,
                    'icon' => 'fa-check',
                    'order' => $index
                ]);
            }
        }
    }
}
