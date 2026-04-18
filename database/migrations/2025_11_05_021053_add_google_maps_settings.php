<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Add Google Maps Embed setting
        DB::table('settings')->insert([
            [
                'key' => 'google_maps_embed',
                'value' => '',
                'type' => 'textarea',
                'group' => 'general',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'google_maps_latitude',
                'value' => '-7.9553',
                'type' => 'text',
                'group' => 'general',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'google_maps_longitude',
                'value' => '112.6244',
                'type' => 'text',
                'group' => 'general',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
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
