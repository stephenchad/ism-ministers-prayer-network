<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TranslationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
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
     * Switch the application locale
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function switch(Request $request)
    {
        $locale = $request->input('locale', 'en');

        if (!array_key_exists($locale, self::LOCALES)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid locale',
                'available_locales' => array_keys(self::LOCALES),
            ], 400);
        }

        Session::put('locale', $locale);
        App::setLocale($locale);

        return response()->json([
            'success' => true,
            'message' => 'Locale changed successfully',
            'locale' => $locale,
            'locale_name' => self::LOCALES[$locale],
            'is_rtl' => TranslationService::isRTLLocale($locale),
        ]);
    }

    /**
     * Get current locale information
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function current()
    {
        $locale = App::getLocale();

        return response()->json([
            'locale' => $locale,
            'locale_name' => self::LOCALES[$locale] ?? 'English',
            'is_rtl' => TranslationService::isRTLLocale($locale),
            'available_locales' => self::LOCALES,
        ]);
    }

    /**
     * Get all available locales
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function locales()
    {
        return response()->json([
            'locales' => self::LOCALES,
            'rtl_locales' => ['ar'],
        ]);
    }

    /**
     * Get translation for a specific key
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function translate(Request $request)
    {
        $request->validate([
            'group' => 'required|string',
            'key' => 'required|string',
        ]);

        $locale = $request->input('locale', App::getLocale());

        $translation = TranslationService::get(
            $request->group,
            $request->key,
            [],
            $locale
        );

        return response()->json([
            'group' => $request->group,
            'key' => $request->key,
            'locale' => $locale,
            'translation' => $translation,
        ]);
    }

    /**
     * Get page content for a specific page and key
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function pageContent(Request $request)
    {
        $request->validate([
            'page' => 'required|string',
            'key' => 'required|string',
        ]);

        $locale = $request->input('locale', App::getLocale());

        $content = \App\Models\PageContent::where('page', $request->page)
            ->where('key', $request->key)
            ->where('is_active', true)
            ->first();

        if (!$content) {
            return response()->json([
                'page' => $request->page,
                'key' => $request->key,
                'locale' => $locale,
                'content' => null,
            ], 404);
        }

        // Get translated content based on locale
        $titleField = "title_{$locale}";
        $subtitleField = "subtitle_{$locale}";
        $contentField = "content_{$locale}";

        return response()->json([
            'page' => $request->page,
            'key' => $request->key,
            'locale' => $locale,
            'content' => [
                'title' => $locale !== 'en' && !empty($content->{$titleField}) ? $content->{$titleField} : $content->title,
                'subtitle' => $locale !== 'en' && !empty($content->{$subtitleField}) ? $content->{$subtitleField} : $content->subtitle,
                'body' => $locale !== 'en' && !empty($content->{$contentField}) ? $content->{$contentField} : $content->content,
                'image' => $content->image,
            ],
        ]);
    }
}
