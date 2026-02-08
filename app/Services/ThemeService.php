<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class ThemeService
{
    const THEME_COOKIE_NAME = 'ism_theme_preference';
    const THEME_COOKIE_DAYS = 365;
    const DEFAULT_THEME = 'system';

    const VALID_THEMES = ['light', 'dark', 'system'];

    /**
     * Get the current theme for a user (authenticated or guest)
     */
    public function getUserTheme($user = null): string
    {
        // For authenticated users, check database first
        if ($user && isset($user->theme_preference)) {
            return $this->validateTheme($user->theme_preference);
        }

        // For guests, check cookie
        $cookieTheme = Cookie::get(self::THEME_COOKIE_NAME);
        if ($cookieTheme && $this->isValidTheme($cookieTheme)) {
            return $cookieTheme;
        }

        return self::DEFAULT_THEME;
    }

    /**
     * Set user's theme preference
     */
    public function setUserTheme(string $theme, $user = null): string
    {
        $validatedTheme = $this->validateTheme($theme);

        if ($user) {
            // Save to database for authenticated users
            $user->theme_preference = $validatedTheme;
            $user->save();
        }

        // Always set cookie as backup for both authenticated and guest users
        Cookie::queue(
            self::THEME_COOKIE_NAME,
            $validatedTheme,
            self::THEME_COOKIE_DAYS * 24 * 60 // minutes
        );

        return $validatedTheme;
    }

    /**
     * Get the actual theme (resolves 'system' to 'light' or 'dark')
     */
    public function getActualTheme(string $theme): string
    {
        if ($theme === 'system') {
            return $this->getSystemTheme();
        }
        return $theme;
    }

    /**
     * Get the current system theme preference
     */
    public function getSystemTheme(): string
    {
        return $this->supportsDarkMode() ? 'dark' : 'light';
    }

    /**
     * Check if the browser supports dark mode
     */
    public function supportsDarkMode(): bool
    {
        return request()->server('HTTP_SEC_CH_PREFERS_COLOR_SCHEME') === 'dark' ||
               request()->server('HTTP_SEC_CH_UA_DARK_MODE_ENABLED') === 'true' ||
               (isset($_SERVER['HTTP_SEC_CH_PREFERS_COLOR_SCHEME']) && $_SERVER['HTTP_SEC_CH_PREFERS_COLOR_SCHEME'] === 'dark');
    }

    /**
     * Check if dark mode is preferred based on Accept-CH header
     */
    public function isDarkModePreferred(): bool
    {
        $colorScheme = request()->header('Sec-CH-Prefers-Color-Scheme');
        return $colorScheme === 'dark';
    }

    /**
     * Validate theme value
     */
    protected function validateTheme(string $theme): string
    {
        return $this->isValidTheme($theme) ? $theme : self::DEFAULT_THEME;
    }

    /**
     * Check if theme is valid
     */
    protected function isValidTheme(string $theme): bool
    {
        return in_array($theme, self::VALID_THEMES, true);
    }

    /**
     * Get theme CSS class for body
     */
    public function getThemeBodyClass(string $theme): string
    {
        $actualTheme = $this->getActualTheme($theme);
        return 'theme-' . $actualTheme;
    }

    /**
     * Get data-theme attribute value
     */
    public function getThemeDataAttribute(string $theme): string
    {
        return $this->getActualTheme($theme);
    }
}
