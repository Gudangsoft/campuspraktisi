<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\News;
use App\Models\NewsTranslation;

class MigrateNewsToTranslations extends Command
{
    protected $signature = 'news:migrate-translations';
    protected $description = 'Migrate existing news data to translations table';

    public function handle()
    {
        $this->info('Starting migration of news to translations...');
        
        $news = News::all();
        $count = 0;
        
        foreach ($news as $item) {
            // Check if translation already exists
            $exists = NewsTranslation::where('news_id', $item->id)
                                    ->where('locale', 'id')
                                    ->exists();
            
            if (!$exists) {
                NewsTranslation::create([
                    'news_id' => $item->id,
                    'locale' => 'id',
                    'title' => $item->title,
                    'slug' => $item->slug,
                    'excerpt' => $item->excerpt,
                    'content' => $item->content,
                ]);
                $count++;
            }
        }
        
        $this->info("✓ Migrated {$count} news items to translations table");
        
        return Command::SUCCESS;
    }
}
