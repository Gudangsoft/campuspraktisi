<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $settings = [
            [
                'key' => 'google_maps_embed',
                'value' => '',
                'type' => 'textarea',
                'group' => 'general',
            ],
            [
                'key' => 'google_maps_latitude',
                'value' => '-7.9553',
                'type' => 'text',
                'group' => 'general',
            ],
            [
                'key' => 'google_maps_longitude',
                'value' => '112.6244',
                'type' => 'text',
                'group' => 'general',
            ]
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->updateOrInsert(
                ['key' => $setting['key']],
                array_merge($setting, ['created_at' => now(), 'updated_at' => now()])
            );
        }
    }

    public function down(): void
    {
        DB::table('settings')->whereIn('key', [
            'google_maps_embed',
            'google_maps_latitude',
            'google_maps_longitude'
        ])->delete();
    }
};
