<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicCalendar extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_year',
        'semester',
        'title',
        'description',
        'start_date',
        'end_date',
        'category',
        'color',
        'is_active',
        'order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
        'order' => 'integer'
    ];

    // Scope untuk event aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope filter by semester
    public function scopeSemester($query, $semester)
    {
        return $query->where('semester', $semester);
    }

    // Scope filter by academic year
    public function scopeAcademicYear($query, $year)
    {
        return $query->where('academic_year', $year);
    }

    // Scope filter by category
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // Scope untuk event yang akan datang
    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>=', now()->toDateString())
                     ->orderBy('start_date', 'asc');
    }

    // Scope untuk event yang sedang berlangsung
    public function scopeCurrent($query)
    {
        $today = now()->toDateString();
        return $query->where('start_date', '<=', $today)
                     ->where(function($q) use ($today) {
                         $q->whereNull('end_date')
                           ->orWhere('end_date', '>=', $today);
                     });
    }

    // Check if event is ongoing
    public function isOngoing()
    {
        $today = now()->toDateString();
        if ($this->end_date) {
            return $this->start_date <= $today && $this->end_date >= $today;
        }
        return $this->start_date == $today;
    }

    // Check if event is upcoming
    public function isUpcoming()
    {
        return $this->start_date > now()->toDateString();
    }

    // Check if event has passed
    public function hasPassed()
    {
        if ($this->end_date) {
            return $this->end_date < now()->toDateString();
        }
        return $this->start_date < now()->toDateString();
    }

    // Get duration in days
    public function getDurationDays()
    {
        if ($this->end_date) {
            return $this->start_date->diffInDays($this->end_date) + 1;
        }
        return 1;
    }

    // Get category badge class
    public function getCategoryBadgeClass()
    {
        return match($this->category) {
            'academic' => 'bg-primary',
            'exam' => 'bg-danger',
            'holiday' => 'bg-success',
            'registration' => 'bg-warning',
            default => 'bg-secondary'
        };
    }

    // Get category icon
    public function getCategoryIcon()
    {
        return match($this->category) {
            'academic' => 'fa-graduation-cap',
            'exam' => 'fa-file-pen',
            'holiday' => 'fa-umbrella-beach',
            'registration' => 'fa-clipboard-list',
            default => 'fa-calendar'
        };
    }
}
