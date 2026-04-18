<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if whatsapp_number setting already exists
        $exists = Setting::where('key', 'whatsapp_number')->exists();
        
        if (!$exists) {
            Setting::create([
                'key' => 'whatsapp_number',
                'value' => '',
                'type' => 'text',
                'group' => 'social'
            ]);
        }
        
        // Check if google_maps_embed setting already exists
        $mapsExists = Setting::where('key', 'google_maps_embed')->exists();
        
        if (!$mapsExists) {
            Setting::create([
                'key' => 'google_maps_embed',
                'value' => '',
                'type' => 'textarea',
                'group' => 'general'
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Setting::whereIn('key', ['whatsapp_number', 'google_maps_embed'])->delete();
    }
};
