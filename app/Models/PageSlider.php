<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageSlider extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'button_text',
        'button_url',
        'desktop_image',
        'mobile_image',
        'page',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get sliders for a specific page
     */
    public static function getForPage($page = 'home')
    {
        return static::where('page', $page)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }
}
