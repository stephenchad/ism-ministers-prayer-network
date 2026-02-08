<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\TranslationLoader\LanguageLine;

class TranslationController extends Controller
{
    /**
     * Supported languages
     */
    public const LANGUAGES = [
        'en' => 'English',
        'es' => 'Español',
        'fr' => 'Français',
        'pt' => 'Português',
        'ar' => 'العربية',
    ];

    public function index(Request $request)
    {
        $query = LanguageLine::query();

        if ($request->filled('group')) {
            $query->where('group', $request->group);
        }

        if ($request->filled('search')) {
            $query->where('key', 'like', '%' . $request->search . '%');
        }

        $translations = $query->orderBy('group')->orderBy('key')->paginate(50);
        $groups = LanguageLine::distinct()->pluck('group');

        return view('admin.translations.index', compact('translations', 'groups'));
    }

    public function create()
    {
        return view('admin.translations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'group' => 'required|string',
            'key' => 'required|string',
            'text_en' => 'required|string',
            'text_es' => 'nullable|string',
            'text_fr' => 'nullable|string',
            'text_pt' => 'nullable|string',
            'text_ar' => 'nullable|string',
        ]);

        $texts = [
            'en' => $request->text_en,
            'es' => $request->text_es,
            'fr' => $request->text_fr,
            'pt' => $request->text_pt,
            'ar' => $request->text_ar,
        ];

        // Remove null values
        $texts = array_filter($texts, function ($value) {
            return $value !== null && $value !== '';
        });

        LanguageLine::create([
            'group' => $request->group,
            'key' => $request->key,
            'text' => $texts,
        ]);

        return redirect()->route('admin.translations.index')->with('success', 'Translation created successfully');
    }

    public function edit($id)
    {
        $translation = LanguageLine::findOrFail($id);
        return view('admin.translations.edit', compact('translation'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'group' => 'required|string',
            'key' => 'required|string',
            'text_en' => 'required|string',
            'text_es' => 'nullable|string',
            'text_fr' => 'nullable|string',
            'text_pt' => 'nullable|string',
            'text_ar' => 'nullable|string',
        ]);

        $translation = LanguageLine::findOrFail($id);

        $texts = [
            'en' => $request->text_en,
            'es' => $request->text_es,
            'fr' => $request->text_fr,
            'pt' => $request->text_pt,
            'ar' => $request->text_ar,
        ];

        // Remove null values
        $texts = array_filter($texts, function ($value) {
            return $value !== null && $value !== '';
        });

        $translation->update([
            'group' => $request->group,
            'key' => $request->key,
            'text' => $texts,
        ]);

        return redirect()->route('admin.translations.index')->with('success', 'Translation updated successfully');
    }

    public function destroy($id)
    {
        LanguageLine::findOrFail($id)->delete();
        return redirect()->route('admin.translations.index')->with('success', 'Translation deleted successfully');
    }

    /**
     * Get supported languages
     */
    public static function getLanguages(): array
    {
        return self::LANGUAGES;
    }
}
