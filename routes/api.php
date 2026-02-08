<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ThemeController;
use App\Http\Controllers\Api\LanguageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Theme routes - accessible to all users (guests get cookie, authenticated users get database + cookie)
Route::post('/theme', [ThemeController::class, 'setTheme']);
Route::get('/theme', [ThemeController::class, 'getTheme']);

// Language/Locale routes - accessible to all users
Route::prefix('locale')->group(function () {
    Route::get('/', [LanguageController::class, 'current']);
    Route::get('/locales', [LanguageController::class, 'locales']);
    Route::post('/switch', [LanguageController::class, 'switch']);
    Route::get('/translate', [LanguageController::class, 'translate']);
    Route::get('/content', [LanguageController::class, 'pageContent']);
});
