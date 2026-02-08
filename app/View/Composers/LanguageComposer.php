<?php

namespace App\View\Composers;

use Illuminate\Support\Facades\App;
use Illuminate\View\View;

class LanguageComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view)
    {
        $locales = [
            'en' => ['flag' => '🇺🇸', 'name' => 'English', 'native' => 'English'],
            'es' => ['flag' => '🇪🇸', 'name' => 'Spanish', 'native' => 'Español'],
            'fr' => ['flag' => '🇫🇷', 'name' => 'French', 'native' => 'Français'],
            'pt' => ['flag' => '🇧🇷', 'name' => 'Portuguese', 'native' => 'Português'],
            'ar' => ['flag' => '🇸🇦', 'name' => 'Arabic', 'native' => 'العربية'],
        ];

        $currentLocale = App::getLocale();
        $isRTL = in_array($currentLocale, ['ar']);

        $view->with([
            'locales' => $locales,
            'currentLocale' => $currentLocale,
            'isRTL' => $isRTL,
        ]);
    }
}
