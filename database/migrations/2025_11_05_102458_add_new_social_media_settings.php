<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $settings = [
            [
                'key' => 'youtube_url',
                'value' => '',
                'type' => 'text',
                'group' => 'social',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'linkedin_url',
                'value' => '',
                'type' => 'text',
                'group' => 'social',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'tiktok_url',
                'value' => '',
                'type' => 'text',
                'group' => 'social',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'whatsapp_number',
                'value' => '',
                'type' => 'text',
                'group' => 'social',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($settings as $setting) {
            // Check if setting already exists
            $exists = DB::table('settings')->where('key', $setting['key'])->exists();
            if (!$exists) {
                DB::table('settings')->insert($setting);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('settings')->whereIn('key', [
            'youtube_url',
            'linkedin_url',
            'tiktok_url',
            'whatsapp_number',
        ])->delete();
    }
};
