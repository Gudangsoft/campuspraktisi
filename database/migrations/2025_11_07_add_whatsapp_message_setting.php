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
        // Check if whatsapp_message setting doesn't exist, then create it
        if (!Setting::where('key', 'whatsapp_message')->exists()) {
            Setting::create([
                'key' => 'whatsapp_message',
                'value' => 'Halo, saya ingin bertanya tentang {site_name}',
                'type' => 'textarea',
                'group' => 'social',
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Setting::where('key', 'whatsapp_message')->delete();
    }
};
