<?php

namespace App\Models;

use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class News extends Model
{
    // Translation disabled
    // use Translatable;
    
    protected $fillable = [
        'category_id', 'user_id', 'title', 'slug', 'excerpt', 
        'content', 'image', 'status', 'published_at', 'views', 'is_featured'
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];
    
    /**
     * Attributes that are translatable (disabled)
     */
    // protected $translatable = ['title', 'slug', 'excerpt', 'content'];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($news) {
            if (empty($news->slug)) {
                $news->slug = Str::slug($news->title);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(NewsCategory::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function translations()
    {
        return $this->hasMany(NewsTranslation::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'news_tag')
                    ->withTimestamps();
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('published_at', 'desc');
    }
}
