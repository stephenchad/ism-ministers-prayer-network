<?php

namespace App\Services;

use App\Models\PageContent;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Spatie\TranslationLoader\LanguageLine;

class TranslationService
{
    /**
     * Supported locales
     */
    public const LOCALES = [
        'en' => 'English',
        'es' => 'Español',
        'fr' => 'Français',
        'pt' => 'Português',
        'ar' => 'العربية',
    ];

    /**
     * RTL languages
     */
    public const RTL_LOCALES = ['ar'];

    /**
     * Get current locale
     */
    public static function getCurrentLocale(): string
    {
        return App::getLocale();
    }

    /**
     * Get current locale name
     */
    public static function getCurrentLocaleName(): string
    {
        $locale = self::getCurrentLocale();
        return self::LOCALES[$locale] ?? 'English';
    }

    /**
     * Check if current locale is RTL
     */
    public static function isCurrentLocaleRTL(): bool
    {
        return in_array(self::getCurrentLocale(), self::RTL_LOCALES);
    }

    /**
     * Check if a locale is RTL
     */
    public static function isRTLLocale($locale): bool
    {
        return in_array($locale, self::RTL_LOCALES);
    }

    /**
     * Set application locale
     */
    public static function setLocale($locale): void
    {
        if (array_key_exists($locale, self::LOCALES)) {
            Session::put('locale', $locale);
            App::setLocale($locale);
        }
    }

    /**
     * Get all available locales
     */
    public static function getAvailableLocales(): array
    {
        return self::LOCALES;
    }

    /**
     * Get locale flag emoji
     */
    public static function getLocaleFlag($locale): string
    {
        $flags = [
            'en' => '🇺🇸',
            'es' => '🇪🇸',
            'fr' => '🇫🇷',
            'pt' => '🇧🇷',
            'ar' => '🇸🇦',
        ];

        return $flags[$locale] ?? '🌐';
    }

    /**
     * Get translated content from LanguageLine
     */
    public static function get(string $group, string $key, array $replace = [], $locale = null): string
    {
        $locale = $locale ?? self::getCurrentLocale();

        $translation = LanguageLine::getTranslationForGroup($group, $key, $locale);

        if ($translation) {
            foreach ($replace as $search => $replaceValue) {
                $translation = str_replace(':' . $search, $replaceValue, $translation);
            }
            return $translation;
        }

        // Fallback to English
        $translation = LanguageLine::getTranslationForGroup($group, $key, 'en');

        if ($translation) {
            foreach ($replace as $search => $replaceValue) {
                $translation = str_replace(':' . $search, $replaceValue, $translation);
            }
            return $translation;
        }

        // Return the key as fallback
        return $key;
    }

    /**
     * Get translated page content
     */
    public static function getPageContent(string $page, string $key): ?string
    {
        $content = PageContent::where('page', $page)
            ->where('key', $key)
            ->where('is_active', true)
            ->first();

        if (!$content) {
            return null;
        }

        return $content->translated_content ?? null;
    }

    /**
     * Get page content with all translations
     */
    public static function getPageContentFull(string $page, string $key): ?PageContent
    {
        return PageContent::where('page', $page)
            ->where('key', $key)
            ->where('is_active', true)
            ->first();
    }

    /**
     * Get all page content for a specific locale
     */
    public static function getPageForLocale(string $page): \Illuminate\Database\Eloquent\Collection
    {
        return PageContent::where('page', $page)
            ->where('is_active', true)
            ->orderBy('section')
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Create or update a translation
     */
    public static function saveTranslation(string $group, string $key, array $texts): LanguageLine
    {
        return LanguageLine::updateOrCreate(
            [
                'group' => $group,
                'key' => $key,
            ],
            [
                'text' => $texts,
            ]
        );
    }

    /**
     * Get translations by group
     */
    public static function getTranslationsByGroup(string $group): \Illuminate\Database\Eloquent\Collection
    {
        return LanguageLine::where('group', $group)
            ->orderBy('key')
            ->get();
    }
}
