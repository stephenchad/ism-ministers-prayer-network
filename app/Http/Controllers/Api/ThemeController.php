<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\ThemeService;

class ThemeController extends Controller
{
    protected $themeService;

    public function __construct(ThemeService $themeService)
    {
        $this->themeService = $themeService;
    }

    /**
     * Get current user's theme preference
     */
    public function getTheme(Request $request)
    {
        $theme = $this->themeService->getUserTheme($request->user());
        
        return response()->json([
            'success' => true,
            'theme' => $theme
        ]);
    }

    /**
     * Save user's theme preference
     */
    public function setTheme(Request $request)
    {
        $request->validate([
            'theme' => 'required|string|in:light,dark,system'
        ]);

        $theme = $this->themeService->setUserTheme($request->theme, $request->user());

        return response()->json([
            'success' => true,
            'message' => 'Theme preference saved successfully.',
            'theme' => $theme
        ]);
    }
}
