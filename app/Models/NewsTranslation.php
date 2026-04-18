<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsTranslation extends Model
{
    protected $fillable = [
        'news_id',
        'locale',
        'title',
        'slug',
        'excerpt',
        'content'
    ];
    
    public function news()
    {
        return $this->belongsTo(News::class);
    }
}
