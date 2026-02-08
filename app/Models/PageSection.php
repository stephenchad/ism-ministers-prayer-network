<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'title',
        'subtitle',
        'content',
        'image',
        'icon',
        'background_color',
        'text_color',
        'page',
        'section_type',
        'meta_data',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'meta_data' => 'array',
    ];

    /**
     * Get sections for a specific page
     */
    public static function getForPage($page = 'home')
    {
        return static::where('page', $page)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Get a section by its key
     */
    public static function getByKey($key)
    {
        return static::where('key', $key)
            ->where('is_active', true)
            ->first();
    }

    /**
     * Get a section by key and page
     */
    public static function getByKeyAndPage($key, $page = 'home')
    {
        return static::where('key', $key)
            ->where('page', $page)
            ->where('is_active', true)
            ->first();
    }
}
