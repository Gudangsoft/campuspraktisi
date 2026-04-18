<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryVideo extends Model
{
    protected $fillable = [
        'title', 'description', 'youtube_url', 'thumbnail',
        'category', 'video_date', 'is_active', 'order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'video_date' => 'date',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // Get YouTube embed ID from URL
    public function getEmbedIdAttribute()
    {
        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/', $this->youtube_url, $match);
        return $match[1] ?? null;
    }

    // Alias for youtube_id
    public function getYoutubeIdAttribute()
    {
        return $this->embed_id;
    }

    // Get YouTube thumbnail URL
    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail) {
            return asset('storage/' . $this->thumbnail);
        }
        
        // Fallback to YouTube thumbnail if custom thumbnail not set
        if ($this->embed_id) {
            return "https://img.youtube.com/vi/{$this->embed_id}/maxresdefault.jpg";
        }
        
        return null;
    }

    // Get YouTube embed URL
    public function getEmbedUrlAttribute()
    {
        if ($this->embed_id) {
            return "https://www.youtube.com/embed/{$this->embed_id}";
        }
        return null;
    }
}
