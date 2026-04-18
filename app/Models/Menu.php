<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['title', 'url', 'parent_id', 'order', 'is_active', 'target', 'menu_group'];

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('order');
    }
    
    // For frontend - only active children (WITHOUT recursive loading to prevent issues)
    public function activeChildren()
    {
        return $this->hasMany(Menu::class, 'parent_id')
            ->where('is_active', true)
            ->orderBy('order');
    }
    
    // Recursive relationship to get all descendants (for admin)
    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeParent($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeTopbar($query)
    {
        return $query->where('menu_group', 'topbar');
    }

    public function scopeMain($query)
    {
        return $query->where('menu_group', 'main');
    }
}
