<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'footer_section_id',
        'title',
        'url',
        'open_new_tab',
        'order',
        'is_active',
    ];

    protected $casts = [
        'open_new_tab' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get the footer section that owns the link.
     */
    public function section()
    {
        return $this->belongsTo(FooterSection::class, 'footer_section_id');
    }

    /**
     * Scope a query to only include active links.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to order links.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
