<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageContent;
use App\Models\PageSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageContentController extends Controller
{
    /**
     * Supported languages for translations
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
        $page = $request->get('page', 'home');

        $contents = PageContent::where('page', $page)
            ->orderBy('section')
            ->orderBy('sort_order')
            ->get()
            ->groupBy('section');

        $pages = PageContent::select('page')
            ->distinct()
            ->orderBy('page')
            ->pluck('page');

        return view('admin.page-content.index', compact('contents', 'page', 'pages'));
    }

    public function create(Request $request)
    {
        $page = $request->get('page', 'home');
        return view('admin.page-content.create', compact('page'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'page' => 'required|string|max:100',
            'section' => 'nullable|string|max:100',
            'key' => 'required|string|max:100|unique:page_contents,key',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'nullable',
            'image' => 'nullable|string|max:255',
            'image_mobile' => 'nullable|string|max:255',
            'video_url' => 'nullable|string|max:255',
            'video_embed' => 'nullable',
            'video_thumbnail' => 'nullable|string|max:255',
            'link_text' => 'nullable|string|max:100',
            'link_url' => 'nullable|string|max:255',
            'link_style' => 'nullable|string|max:50',
            // Layout fields
            'layout_style' => 'nullable|string|max:50',
            'column_count' => 'nullable|string|max:10',
            'content_width' => 'nullable|string|max:50',
            'bg_type' => 'nullable|string|max:50',
            'bg_color' => 'nullable|string|max:20',
            'bg_image' => 'nullable|string|max:255',
            'bg_gradient' => 'nullable|string|max:255',
            'padding_top' => 'nullable|string|max:50',
            'padding_bottom' => 'nullable|string|max:50',
            'text_align' => 'nullable|string|max:20',
            'css_class' => 'nullable|string|max:100',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
            // Multilingual fields
            'title_es' => 'nullable|string|max:255',
            'subtitle_es' => 'nullable|string|max:255',
            'content_es' => 'nullable',
            'title_fr' => 'nullable|string|max:255',
            'subtitle_fr' => 'nullable|string|max:255',
            'content_fr' => 'nullable',
            'title_pt' => 'nullable|string|max:255',
            'subtitle_pt' => 'nullable|string|max:255',
            'content_pt' => 'nullable',
            'title_ar' => 'nullable|string|max:255',
            'subtitle_ar' => 'nullable|string|max:255',
            'content_ar' => 'nullable',
        ]);

        try {
            DB::beginTransaction();

            $data = [
                'page' => $validated['page'],
                'section' => $validated['section'] ?? null,
                'key' => $validated['key'],
                'title' => $validated['title'] ?? null,
                'subtitle' => $validated['subtitle'] ?? null,
                'content' => $validated['content'] ?? null,
                'image' => $validated['image'] ?? null,
                'image_mobile' => $validated['image_mobile'] ?? null,
                'video_url' => $validated['video_url'] ?? null,
                'video_embed' => $validated['video_embed'] ?? null,
                'video_thumbnail' => $validated['video_thumbnail'] ?? null,
                'link_text' => $validated['link_text'] ?? null,
                'link_url' => $validated['link_url'] ?? null,
                'link_style' => $validated['link_style'] ?? 'primary',
                // Layout fields
                'layout_style' => $validated['layout_style'] ?? 'default',
                'column_count' => $validated['column_count'] ?? '1',
                'content_width' => $validated['content_width'] ?? 'default',
                'bg_type' => $validated['bg_type'] ?? 'none',
                'bg_color' => $validated['bg_color'] ?? null,
                'bg_image' => $validated['bg_image'] ?? null,
                'bg_gradient' => $validated['bg_gradient'] ?? null,
                'padding_top' => $validated['padding_top'] ?? 'default',
                'padding_bottom' => $validated['padding_bottom'] ?? 'default',
                'text_align' => $validated['text_align'] ?? 'default',
                'css_class' => $validated['css_class'] ?? null,
                'sort_order' => $validated['sort_order'] ?? 0,
                'is_active' => $validated['is_active'] ?? true,
            ];

            // Add multilingual fields
            foreach (['es', 'fr', 'pt', 'ar'] as $locale) {
                $data["title_{$locale}"] = $validated["title_{$locale}"] ?? null;
                $data["subtitle_{$locale}"] = $validated["subtitle_{$locale}"] ?? null;
                $data["content_{$locale}"] = $validated["content_{$locale}"] ?? null;
            }

            PageContent::create($data);

            DB::commit();

            return redirect()
                ->route('admin.page-content.index', ['page' => $validated['page']])
                ->with('success', 'Content created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error creating content: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $content = PageContent::findOrFail($id);
        return view('admin.page-content.edit', compact('content'));
    }

    public function update(Request $request, $id)
    {
        $content = PageContent::findOrFail($id);

        $validated = $request->validate([
            'page' => 'required|string|max:100',
            'section' => 'nullable|string|max:100',
            'key' => 'required|string|max:100|unique:page_contents,key,' . $id,
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'nullable',
            'image' => 'nullable|string|max:255',
            'image_mobile' => 'nullable|string|max:255',
            'video_url' => 'nullable|string|max:255',
            'video_embed' => 'nullable',
            'video_thumbnail' => 'nullable|string|max:255',
            'link_text' => 'nullable|string|max:100',
            'link_url' => 'nullable|string|max:255',
            'link_style' => 'nullable|string|max:50',
            // Layout fields
            'layout_style' => 'nullable|string|max:50',
            'column_count' => 'nullable|string|max:10',
            'content_width' => 'nullable|string|max:50',
            'bg_type' => 'nullable|string|max:50',
            'bg_color' => 'nullable|string|max:20',
            'bg_image' => 'nullable|string|max:255',
            'bg_gradient' => 'nullable|string|max:255',
            'padding_top' => 'nullable|string|max:50',
            'padding_bottom' => 'nullable|string|max:50',
            'text_align' => 'nullable|string|max:20',
            'css_class' => 'nullable|string|max:100',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
            // Multilingual fields
            'title_es' => 'nullable|string|max:255',
            'subtitle_es' => 'nullable|string|max:255',
            'content_es' => 'nullable',
            'title_fr' => 'nullable|string|max:255',
            'subtitle_fr' => 'nullable|string|max:255',
            'content_fr' => 'nullable',
            'title_pt' => 'nullable|string|max:255',
            'subtitle_pt' => 'nullable|string|max:255',
            'content_pt' => 'nullable',
            'title_ar' => 'nullable|string|max:255',
            'subtitle_ar' => 'nullable|string|max:255',
            'content_ar' => 'nullable',
        ]);

        try {
            DB::beginTransaction();

            $data = [
                'page' => $validated['page'],
                'section' => $validated['section'] ?? null,
                'key' => $validated['key'],
                'title' => $validated['title'] ?? null,
                'subtitle' => $validated['subtitle'] ?? null,
                'content' => $validated['content'] ?? null,
                'image' => $validated['image'] ?? null,
                'image_mobile' => $validated['image_mobile'] ?? null,
                'video_url' => $validated['video_url'] ?? null,
                'video_embed' => $validated['video_embed'] ?? null,
                'video_thumbnail' => $validated['video_thumbnail'] ?? null,
                'link_text' => $validated['link_text'] ?? null,
                'link_url' => $validated['link_url'] ?? null,
                'link_style' => $validated['link_style'] ?? 'primary',
                // Layout fields
                'layout_style' => $validated['layout_style'] ?? 'default',
                'column_count' => $validated['column_count'] ?? '1',
                'content_width' => $validated['content_width'] ?? 'default',
                'bg_type' => $validated['bg_type'] ?? 'none',
                'bg_color' => $validated['bg_color'] ?? null,
                'bg_image' => $validated['bg_image'] ?? null,
                'bg_gradient' => $validated['bg_gradient'] ?? null,
                'padding_top' => $validated['padding_top'] ?? 'default',
                'padding_bottom' => $validated['padding_bottom'] ?? 'default',
                'text_align' => $validated['text_align'] ?? 'default',
                'css_class' => $validated['css_class'] ?? null,
                'sort_order' => $validated['sort_order'] ?? 0,
                'is_active' => $validated['is_active'] ?? true,
            ];

            // Add multilingual fields
            foreach (['es', 'fr', 'pt', 'ar'] as $locale) {
                $data["title_{$locale}"] = $validated["title_{$locale}"] ?? null;
                $data["subtitle_{$locale}"] = $validated["subtitle_{$locale}"] ?? null;
                $data["content_{$locale}"] = $validated["content_{$locale}"] ?? null;
            }

            $content->update($data);

            DB::commit();

            return redirect()
                ->route('admin.page-content.index', ['page' => $content->page])
                ->with('success', 'Content updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error updating content: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $content = PageContent::findOrFail($id);
        $page = $content->page;

        try {
            $content->delete();
            return redirect()
                ->route('admin.page-content.index', ['page' => $page])
                ->with('success', 'Content deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting content: ' . $e->getMessage());
        }
    }

    /**
     * Get all supported languages
     */
    public static function getLanguages(): array
    {
        return self::LANGUAGES;
    }

    /**
     * Display sliders management page
     */
    public function sliders(Request $request)
    {
        $page = $request->get('page', 'home');
        $sliders = PageSlider::where('page', $page)
            ->orderBy('sort_order')
            ->get();
        
        return view('admin.page-content.sliders', compact('sliders', 'page'));
    }

    /**
     * Store a new slider
     */
    public function storeSlider(Request $request)
    {
        $validated = $request->validate([
            'page' => 'required|string|max:100',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:100',
            'button_url' => 'nullable|string|max:255',
            'desktop_image' => 'nullable|string|max:255',
            'mobile_image' => 'nullable|string|max:255',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        try {
            $data = [
                'page' => $validated['page'],
                'title' => $validated['title'] ?? null,
                'subtitle' => $validated['subtitle'] ?? null,
                'button_text' => $validated['button_text'] ?? null,
                'button_url' => $validated['button_url'] ?? null,
                'desktop_image' => $validated['desktop_image'] ?? null,
                'mobile_image' => $validated['mobile_image'] ?? null,
                'sort_order' => $validated['sort_order'] ?? 0,
                'is_active' => $validated['is_active'] ?? true,
            ];

            PageSlider::create($data);

            return back()->with('success', 'Slider created successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error creating slider: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Update an existing slider
     */
    public function updateSlider(Request $request, $id)
    {
        $slider = PageSlider::findOrFail($id);

        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:100',
            'button_url' => 'nullable|string|max:255',
            'desktop_image' => 'nullable|string|max:255',
            'mobile_image' => 'nullable|string|max:255',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        try {
            $data = [
                'title' => $validated['title'] ?? null,
                'subtitle' => $validated['subtitle'] ?? null,
                'button_text' => $validated['button_text'] ?? null,
                'button_url' => $validated['button_url'] ?? null,
                'desktop_image' => $validated['desktop_image'] ?? null,
                'mobile_image' => $validated['mobile_image'] ?? null,
                'sort_order' => $validated['sort_order'] ?? 0,
                'is_active' => $validated['is_active'] ?? true,
            ];

            $slider->update($data);

            return back()->with('success', 'Slider updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error updating slider: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Delete a slider
     */
    public function destroySlider($id)
    {
        $slider = PageSlider::findOrFail($id);

        try {
            $slider->delete();
            return back()->with('success', 'Slider deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting slider: ' . $e->getMessage());
        }
    }
}
