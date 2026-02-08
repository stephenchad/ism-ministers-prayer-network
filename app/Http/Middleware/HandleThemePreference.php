<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Services\ThemeService;

class HandleThemePreference
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check for theme query parameter
        $theme = $request->query('theme');
        
        if ($theme && in_array($theme, ['light', 'dark', 'system'])) {
            // Set the theme cookie
            Cookie::queue(
                ThemeService::THEME_COOKIE_NAME,
                $theme,
                ThemeService::THEME_COOKIE_DAYS * 24 * 60
            );
            
            // Also set in session
            session(['theme' => $theme]);
            
            // Redirect back without the query parameter
            return redirect()->to($request->url());
        }
        
        return $next($request);
    }
}
