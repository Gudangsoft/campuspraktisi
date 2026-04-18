<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryPhoto extends Model
{
    protected $fillable = [
        'title', 'description', 'image', 'category', 
        'photo_date', 'is_active', 'order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'photo_date' => 'date',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
