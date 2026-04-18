<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'category',
        'published_date',
        'file',
        'is_active',
        'is_important',
        'order'
    ];

    protected $casts = [
        'published_date' => 'date',
        'is_active' => 'boolean',
        'is_important' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeImportant($query)
    {
        return $query->where('is_important', true);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('published_date', 'desc')
                     ->orderBy('order', 'asc');
    }
}
