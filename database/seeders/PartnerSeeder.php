<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Partner;
use Illuminate\Support\Facades\File;

class PartnerSeeder extends Seeder
{
    public function run()
    {
        $partners = [
            [
                'name' => 'Kementerian Pendidikan dan Kebudayaan',
                'website' => 'https://www.kemdikbud.go.id',
                'description' => 'Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi Republik Indonesia',
                'is_active' => true,
                'order' => 0
            ],
            [
                'name' => 'Google Indonesia',
                'website' => 'https://www.google.co.id',
                'description' => 'Partner teknologi untuk pengembangan digital',
                'is_active' => true,
                'order' => 1
            ],
            [
                'name' => 'Microsoft Indonesia',
                'website' => 'https://www.microsoft.com/id-id',
                'description' => 'Kerjasama dalam bidang teknologi informasi',
                'is_active' => true,
                'order' => 2
            ],
            [
                'name' => 'Telkom Indonesia',
                'website' => 'https://www.telkom.co.id',
                'description' => 'Partner telekomunikasi dan infrastruktur digital',
                'is_active' => true,
                'order' => 3
            ],
            [
                'name' => 'Bank BCA',
                'website' => 'https://www.bca.co.id',
                'description' => 'Kerjasama dalam pengembangan fintech',
                'is_active' => true,
                'order' => 4
            ],
            [
                'name' => 'Gojek Indonesia',
                'website' => 'https://www.gojek.com',
                'description' => 'Partner dalam ekosistem digital dan startup',
                'is_active' => true,
                'order' => 5
            ]
        ];

        foreach ($partners as $partnerData) {
            // Note: Logo akan kosong, admin harus upload manual
            // Atau bisa generate dummy image
            Partner::create(array_merge($partnerData, [
                'logo' => 'partners/placeholder.png' // Placeholder, harus diganti manual
            ]));
        }

        $this->command->info('Partner seeder completed! (Note: Logo masih placeholder, harap upload manual)');
    }
}
