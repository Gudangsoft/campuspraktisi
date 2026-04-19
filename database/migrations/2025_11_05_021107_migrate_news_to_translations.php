<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Migrate existing news data to translations table
        $news = DB::table('news')->get();
        
        foreach ($news as $item) {
            // Create Indonesian translation (default) if not exists
            DB::table('news_translations')->updateOrInsert(
                ['news_id' => $item->id, 'locale' => 'id'],
                [
                    'title' => $item->title,
                    'slug' => $item->slug,
                    'excerpt' => $item->excerpt,
                    'content' => $item->content,
                    'updated_at' => now(),
                ]
            );
        }
    }

    public function down(): void
    {
        DB::table('news_translations')->truncate();
    }
};
