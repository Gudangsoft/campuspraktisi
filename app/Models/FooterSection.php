<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the links for this footer section.
     */
    public function links()
    {
        return $this->hasMany(FooterLink::class)->orderBy('order');
    }

    /**
     * Get active links for this footer section.
     */
    public function activeLinks()
    {
        return $this->hasMany(FooterLink::class)
                    ->where('is_active', true)
                    ->orderBy('order');
    }

    /**
     * Scope a query to only include active sections.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to order sections.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
