<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PimpinanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama' => 'Muhammad Yusuf, S.Sos., M.M',
                'jabatan' => 'Direktur',
                'kategori' => 'pimpinan',
                'order' => 1
            ],
            [
                'nama' => 'Ponsen Sindu Prawito, S.Si., MM',
                'jabatan' => 'Wakil Direktur I',
                'kategori' => 'pimpinan',
                'order' => 2
            ],
            [
                'nama' => 'Shahniarti Soetriono, SE',
                'jabatan' => 'Wakil Direktur II',
                'kategori' => 'pimpinan',
                'order' => 3
            ],
            [
                'nama' => 'Eulis Eliyati, SE., M.Si',
                'jabatan' => 'Ketua Yayasan',
                'kategori' => 'yayasan',
                'order' => 1
            ],
        ];

        foreach ($data as $item) {
            \App\Models\Pimpinan::create($item);
        }

        // Settings for Yayasan
        $settings = [
            'yayasan_nama' => 'Yayasan Pengkajian Dan Penerapan Akuntansi',
            'yayasan_akta_notaris' => '2007-08-15',
            'yayasan_no_reg_ham' => 'C-3973 HT 01.02 TH 2007',
        ];

        foreach ($settings as $key => $value) {
            \App\Models\Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'group' => 'yayasan']
            );
        }
    }
}
