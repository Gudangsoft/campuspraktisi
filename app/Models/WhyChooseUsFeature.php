<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhyChooseUsFeature extends Model
{
    protected $fillable = [
        'why_choose_us_id',
        'feature_text',
        'icon',
        'order'
    ];

    protected $casts = [
        'order' => 'integer'
    ];

    /**
     * Get the parent card
     */
    public function whyChooseUs()
    {
        return $this->belongsTo(WhyChooseUs::class, 'why_choose_us_id');
    }
}
