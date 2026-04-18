<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class WhyChooseUsSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'why_choose_us_title',
                'value' => 'Kenapa Memilih Kami?',
                'type' => 'text',
                'group' => 'why_choose_us'
            ],
            [
                'key' => 'why_choose_us_description',
                'value' => 'Keunggulan yang kami tawarkan untuk kesuksesan Anda',
                'type' => 'text',
                'group' => 'why_choose_us'
            ]
        ];

        foreach ($settings as $setting) {
            $record = Setting::where('key', $setting['key'])->first();
            if ($record) {
                $record->update($setting);
            } else {
                Setting::create($setting);
            }
        }

        $this->command->info('Why Choose Us settings created successfully!');
    }
}
