<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * Supported languages:
     * - en: English (default)
     * - es: Spanish (Español)
     * - fr: French (Français)
     * - pt: Portuguese (Português)
     * - ar: Arabic (العربية)
     */
    public function handle(Request $request, Closure $next)
    {
        // Get available languages
        $supportedLocales = ['en', 'es', 'fr', 'pt', 'ar'];

        // Check if language parameter is passed in the request (query parameter)
        if ($request->has('lang')) {
            $locale = $request->get('lang');
            if (in_array($locale, $supportedLocales)) {
                Session::put('locale', $locale);
                App::setLocale($locale);
            }
        }
        
        // Check if locale is in URL parameter (e.g., /language/es)
        $localeFromUrl = $request->segment(2);
        if (!empty($localeFromUrl) && in_array($localeFromUrl, $supportedLocales)) {
            Session::put('locale', $localeFromUrl);
            App::setLocale($localeFromUrl);
        }

        // Get locale from session or use default
        $locale = Session::get('locale', config('app.locale', 'en'));

        // Validate locale
        if (!in_array($locale, $supportedLocales)) {
            $locale = config('app.locale', 'en');
        }

        App::setLocale($locale);

        return $next($request);
    }
}
