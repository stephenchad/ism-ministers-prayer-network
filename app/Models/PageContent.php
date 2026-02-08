<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class PageContent extends Model
{
    use HasFactory;

    /**
     * Supported languages for content translation
     */
    public const LANGUAGES = [
        'en' => 'English',
        'es' => 'Español',
        'fr' => 'Français',
        'pt' => 'Português',
        'ar' => 'العربية',
    ];

    protected $fillable = [
        'page',
        'section',
        'key',
        'title',
        'subtitle',
        'content',
        'image',
        'image_mobile',
        'video_url',
        'video_embed',
        'video_thumbnail',
        'link_url',
        'link_text',
        'link_style',
        // Layout fields
        'layout_style',
        'column_count',
        'content_width',
        'bg_type',
        'bg_color',
        'bg_image',
        'bg_gradient',
        'padding_top',
        'padding_bottom',
        'text_align',
        'css_class',
        'sort_order',
        'is_active',
        // Multilingual columns
        'title_es',
        'subtitle_es',
        'content_es',
        'title_fr',
        'subtitle_fr',
        'content_fr',
        'title_pt',
        'subtitle_pt',
        'content_pt',
        'title_ar',
        'subtitle_ar',
        'content_ar',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get the translated title based on current locale
     */
    public function getTranslatedTitleAttribute(): ?string
    {
        $locale = App::getLocale();

        // Check if there's a translation for the current locale
        $translatedField = "title_{$locale}";
        if ($locale !== 'en' && isset($this->{$translatedField}) && !empty($this->{$translatedField})) {
            return $this->{$translatedField};
        }

        // Fallback to English
        return $this->title;
    }

    /**
     * Get the translated subtitle based on current locale
     */
    public function getTranslatedSubtitleAttribute(): ?string
    {
        $locale = App::getLocale();

        $translatedField = "subtitle_{$locale}";
        if ($locale !== 'en' && isset($this->{$translatedField}) && !empty($this->{$translatedField})) {
            return $this->{$translatedField};
        }

        return $this->subtitle;
    }

    /**
     * Get the translated content based on current locale
     */
    public function getTranslatedContentAttribute(): ?string
    {
        $locale = App::getLocale();

        $translatedField = "content_{$locale}";
        if ($locale !== 'en' && isset($this->{$translatedField}) && !empty($this->{$translatedField})) {
            return $this->{$translatedField};
        }

        return $this->content;
    }

    /**
     * Get content for a specific page and section
     */
    public static function getForPage($page, $section = null)
    {
        $query = static::where('page', $page)
            ->where('is_active', true)
            ->orderBy('sort_order');

        if ($section) {
            $query->where('section', $section);
        }

        return $query->get();
    }

    /**
     * Get a single content item by key with locale support
     */
    public static function getByKey($page, $key, $default = null)
    {
        $content = static::where('page', $page)
            ->where('key', $key)
            ->where('is_active', true)
            ->first();

        if (!$content) {
            return $default;
        }

        // Return the translated version
        return $content->translated_content ?? $default;
    }

    /**
     * Get a content item with all its translations
     */
    public static function getWithTranslations($page, $key)
    {
        return static::where('page', $page)
            ->where('key', $key)
            ->where('is_active', true)
            ->first();
    }

    /**
     * Get hero content for a page
     */
    public static function getHero($page)
    {
        return static::where('page', $page)
            ->where('section', 'hero')
            ->where('is_active', true)
            ->first();
    }

    /**
     * Get all page content items with translations for a locale
     */
    public static function getAllForPage($page)
    {
        return static::where('page', $page)
            ->where('is_active', true)
            ->orderBy('section')
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Get content items by section
     */
    public static function getBySection($page, $section)
    {
        return static::where('page', $page)
            ->where('section', $section)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Check if content has translations for a specific locale
     */
    public function hasTranslation($locale): bool
    {
        if ($locale === 'en') {
            return true; // English is always available
        }

        $titleField = "title_{$locale}";
        $contentField = "content_{$locale}";

        return !empty($this->{$titleField}) || !empty($this->{$contentField});
    }

    /**
     * Get available translations for this content
     */
    public function getAvailableTranslations(): array
    {
        $available = ['en'];

        foreach (['es', 'fr', 'pt', 'ar'] as $locale) {
            if ($this->hasTranslation($locale)) {
                $available[] = $locale;
            }
        }

        return $available;
    }

    /**
     * Get all title columns
     */
    public static function getTitleColumns(): array
    {
        return ['title', 'title_es', 'title_fr', 'title_pt', 'title_ar'];
    }

    /**
     * Get all subtitle columns
     */
    public static function getSubtitleColumns(): array
    {
        return ['subtitle', 'subtitle_es', 'subtitle_fr', 'subtitle_pt', 'subtitle_ar'];
    }

    /**
     * Get all content columns
     */
    public static function getContentColumns(): array
    {
        return ['content', 'content_es', 'content_fr', 'content_pt', 'content_ar'];
    }

    /**
     * Get the column name for a specific locale
     */
    public static function getColumnForLocale(string $field, string $locale): string
    {
        if ($locale === 'en') {
            return $field;
        }
        return $field . '_' . $locale;
    }

    /**
     * Get the section's background style attribute
     */
    public function getBgStyleAttribute(): string
    {
        $bgType = $this->bg_type ?? 'none';
        $bgColor = $this->bg_color ?? '';
        $bgImage = $this->bg_image ?? '';
        $bgGradient = $this->bg_gradient ?? '';
        
        if ($bgType === 'color' && $bgColor) {
            return "background-color: {$bgColor};";
        } elseif ($bgType === 'image' && $bgImage) {
            return "background-image: url('{$bgImage}'); background-size: cover; background-position: center;";
        } elseif ($bgType === 'gradient' && $bgGradient) {
            $colors = explode(',', $bgGradient);
            if (count($colors) >= 2) {
                return "background: linear-gradient(135deg, {$colors[0]}, {$colors[1]});";
            }
        }
        
        return '';
    }

    /**
     * Get the section's padding style attribute
     */
    public function getPaddingStyleAttribute(): string
    {
        $paddingMap = [
            'default' => '',
            '0' => '0',
            'small' => '20px',
            'medium' => '40px',
            'large' => '60px',
            'xlarge' => '80px',
        ];
        
        $pt = $paddingMap[$this->padding_top ?? 'default'] ?? '';
        $pb = $paddingMap[$this->padding_bottom ?? 'default'] ?? '';
        
        $style = '';
        if ($pt) $style .= "padding-top: {$pt};";
        if ($pb) $style .= "padding-bottom: {$pb};";
        
        return $style;
    }

    /**
     * Get the column class based on column_count
     */
    public function getColumnClassAttribute(): string
    {
        $columnCount = $this->column_count ?? '1';
        
        $colClassMap = [
            '1' => 'col-12',
            '2' => 'col-lg-6 col-md-6',
            '3' => 'col-lg-4 col-md-6',
            '4' => 'col-lg-3 col-md-6',
        ];
        
        return $colClassMap[$columnCount] ?? 'col-12';
    }

    /**
     * Get button class based on link_style
     */
    public function getButtonClassAttribute(): string
    {
        $btnClassMap = [
            'primary' => 'react-btn',
            'secondary' => 'react-btn-border',
            'success' => 'react-btn-success',
            'danger' => 'react-btn-danger',
            'warning' => 'react-btn-warning',
            'info' => 'react-btn-info',
        ];
        
        return $btnClassMap[$this->link_style ?? 'primary'] ?? 'react-btn';
    }

    /**
     * Get the full style attribute combining bg and padding
     */
    public function getFullStyleAttribute(): string
    {
        return $this->bg_style . $this->padding_style;
    }
}
