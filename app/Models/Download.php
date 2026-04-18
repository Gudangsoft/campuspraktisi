<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'file_path',
        'file_type',
        'file_size',
        'category',
        'downloads_count',
        'is_active',
        'source_type',
        'gdrive_url',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'downloads_count' => 'integer',
        'file_size' => 'integer',
    ];

    // Accessor untuk format file size
    public function getFileSizeFormattedAttribute()
    {
        $bytes = $this->file_size;
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    // Accessor untuk icon berdasarkan file type
    public function getFileIconAttribute()
    {
        if ($this->source_type === 'gdrive') {
            return 'fa-brands fa-google-drive text-success';
        }

        $icons = [
            'pdf' => 'fa-file-pdf text-danger',
            'doc' => 'fa-file-word text-primary',
            'docx' => 'fa-file-word text-primary',
            'xls' => 'fa-file-excel text-success',
            'xlsx' => 'fa-file-excel text-success',
            'ppt' => 'fa-file-powerpoint text-warning',
            'pptx' => 'fa-file-powerpoint text-warning',
            'zip' => 'fa-file-archive text-secondary',
            'rar' => 'fa-file-archive text-secondary',
            'jpg' => 'fa-file-image text-info',
            'jpeg' => 'fa-file-image text-info',
            'png' => 'fa-file-image text-info',
        ];

        return $icons[$this->file_type] ?? 'fa-file text-secondary';
    }

    // Scope untuk filter aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk filter by category
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // Increment download count
    public function incrementDownloads()
    {
        $this->increment('downloads_count');
    }
}
