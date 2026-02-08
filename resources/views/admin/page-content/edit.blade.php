@extends('admin.layouts.app')

@section('title', 'Edit Page Content')

@section('main')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Page Content</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('admin.page-content.index', ['page' => $pageContent->page]) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.page-content.update', $pageContent->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Language Tabs -->
                <div class="language-tabs">
                    <button type="button" class="tab-btn active" data-tab="english">
                        🇺🇸 English
                    </button>
                    <button type="button" class="tab-btn" data-tab="spanish">
                        🇪🇸 Español
                    </button>
                    <button type="button" class="tab-btn" data-tab="french">
                        🇫🇷 Français
                    </button>
                    <button type="button" class="tab-btn" data-tab="portuguese">
                        🇧🇷 Português
                    </button>
                    <button type="button" class="tab-btn" data-tab="arabic">
                        🇸🇦 العربية
                    </button>
                    <button type="button" class="tab-btn" data-tab="media">
                        <i class="fas fa-image"></i> Media
                    </button>
                    <button type="button" class="tab-btn" data-tab="layout">
                        <i class="fas fa-th"></i> Layout
                    </button>
                    <button type="button" class="tab-btn" data-tab="settings">
                        <i class="fas fa-cog"></i> Settings
                    </button>
                </div>

                <!-- Tab Content -->
                <div class="tab-content-wrapper">
                    <!-- English Tab -->
                    <div class="tab-pane active" id="english">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">English Content</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Title (English) *</label>
                                            <input type="text" name="title" class="form-control"
                                                   placeholder="Content title in English"
                                                   value="{{ old('title', $pageContent->title) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Subtitle (English)</label>
                                            <input type="text" name="subtitle" class="form-control"
                                                   placeholder="Content subtitle in English"
                                                   value="{{ old('subtitle', $pageContent->subtitle) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Content (English)</label>
                                    <textarea name="content" class="form-control content-editor"
                                              rows="8"
                                              placeholder="Main content in English (supports HTML)">{{ old('content', $pageContent->content) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Spanish Tab -->
                    <div class="tab-pane" id="spanish">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Spanish Content (Español)</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Title (Español)</label>
                                            <input type="text" name="title_es" class="form-control"
                                                   placeholder="Título en español"
                                                   value="{{ old('title_es', $pageContent->title_es) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Subtitle (Español)</label>
                                            <input type="text" name="subtitle_es" class="form-control"
                                                   placeholder="Subtítulo en español"
                                                   value="{{ old('subtitle_es', $pageContent->subtitle_es) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Content (Español)</label>
                                    <textarea name="content_es" class="form-control content-editor"
                                              rows="8"
                                              placeholder="Contenido principal en español">{{ old('content_es', $pageContent->content_es) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- French Tab -->
                    <div class="tab-pane" id="french">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">French Content (Français)</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Title (Français)</label>
                                            <input type="text" name="title_fr" class="form-control"
                                                   placeholder="Titre en français"
                                                   value="{{ old('title_fr', $pageContent->title_fr) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Subtitle (Français)</label>
                                            <input type="text" name="subtitle_fr" class="form-control"
                                                   placeholder="Sous-titre en français"
                                                   value="{{ old('subtitle_fr', $pageContent->subtitle_fr) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Content (Français)</label>
                                    <textarea name="content_fr" class="form-control content-editor"
                                              rows="8"
                                              placeholder="Contenu principal en français">{{ old('content_fr', $pageContent->content_fr) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Portuguese Tab -->
                    <div class="tab-pane" id="portuguese">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Portuguese Content (Português)</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Title (Português)</label>
                                            <input type="text" name="title_pt" class="form-control"
                                                   placeholder="Título em português"
                                                   value="{{ old('title_pt', $pageContent->title_pt) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Subtitle (Português)</label>
                                            <input type="text" name="subtitle_pt" class="form-control"
                                                   placeholder="Subtítulo em português"
                                                   value="{{ old('subtitle_pt', $pageContent->subtitle_pt) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Content (Português)</label>
                                    <textarea name="content_pt" class="form-control content-editor"
                                              rows="8"
                                              placeholder="Conteúdo principal em português">{{ old('content_pt', $pageContent->content_pt) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Arabic Tab -->
                    <div class="tab-pane" id="arabic">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Arabic Content (العربية)</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Title (العربية)</label>
                                            <input type="text" name="title_ar" class="form-control"
                                                   placeholder="العنوان بالعربية"
                                                   value="{{ old('title_ar', $pageContent->title_ar) }}"
                                                   dir="rtl">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Subtitle (العربية)</label>
                                            <input type="text" name="subtitle_ar" class="form-control"
                                                   placeholder="العنوان الفرعي بالعربية"
                                                   value="{{ old('subtitle_ar', $pageContent->subtitle_ar) }}"
                                                   dir="rtl">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Content (العربية)</label>
                                    <textarea name="content_ar" class="form-control content-editor"
                                              rows="8"
                                              placeholder="المحتوى الرئيسي بالعربية"
                                              dir="rtl">{{ old('content_ar', $pageContent->content_ar) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Media Tab -->
                    <div class="tab-pane" id="media">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Images, Videos & Links</h5>
                            </div>
                            <div class="card-body">
                                <!-- Images -->
                                <h6>Images</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Desktop Image URL</label>
                                            <input type="text" name="image" class="form-control"
                                                   placeholder="e.g., assets/images/section/image.jpg"
                                                   value="{{ old('image', $pageContent->image) }}">
                                            <small class="text-muted">Full image for desktop displays</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Mobile Image URL</label>
                                            <input type="text" name="image_mobile" class="form-control"
                                                   placeholder="e.g., assets/images/section/mobile.jpg"
                                                   value="{{ old('image_mobile', $pageContent->image_mobile) }}">
                                            <small class="text-muted">Optimized image for mobile devices</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Videos -->
                                <hr>
                                <h6>Videos</h6>
                                <div class="form-group">
                                    <label>Video URL (YouTube, Vimeo, etc.)</label>
                                    <input type="text" name="video_url" class="form-control"
                                           placeholder="e.g., https://www.youtube.com/watch?v=..."
                                           value="{{ old('video_url', $pageContent->video_url) }}">
                                    <small class="text-muted">Direct link to video platform</small>
                                </div>

                                <div class="form-group">
                                    <label>Video Embed Code</label>
                                    <textarea name="video_embed" class="form-control"
                                              rows="4"
                                              placeholder="<iframe>...</iframe> or <video>...</video>">{{ old('video_embed', $pageContent->video_embed) }}</textarea>
                                    <small class="text-muted">Custom embed code (YouTube, Vimeo, etc.)</small>
                                </div>

                                <div class="form-group">
                                    <label>Video Thumbnail URL</label>
                                    <input type="text" name="video_thumbnail" class="form-control"
                                           placeholder="e.g., assets/images/video-thumb.jpg"
                                           value="{{ old('video_thumbnail', $pageContent->video_thumbnail) }}">
                                </div>

                                <!-- Links/Buttons -->
                                <hr>
                                <h6>Call to Action (CTA)</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Button Text</label>
                                            <input type="text" name="link_text" class="form-control"
                                                   placeholder="e.g., Learn More, Register Now"
                                                   value="{{ old('link_text', $pageContent->link_text) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Button URL</label>
                                            <input type="text" name="link_url" class="form-control"
                                                   placeholder="e.g., /register, https://..."
                                                   value="{{ old('link_url', $pageContent->link_url) }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Link/Button Style</label>
                                    <select name="link_style" class="form-select">
                                        <option value="primary" {{ old('link_style', $pageContent->link_style) == 'primary' ? 'selected' : '' }}>Primary (Gradient)</option>
                                        <option value="secondary" {{ old('link_style', $pageContent->link_style) == 'secondary' ? 'selected' : '' }}>Secondary (Outline)</option>
                                        <option value="success" {{ old('link_style', $pageContent->link_style) == 'success' ? 'selected' : '' }}>Success (Green)</option>
                                        <option value="danger" {{ old('link_style', $pageContent->link_style) == 'danger' ? 'selected' : '' }}>Danger (Red)</option>
                                        <option value="warning" {{ old('link_style', $pageContent->link_style) == 'warning' ? 'selected' : '' }}>Warning (Yellow)</option>
                                        <option value="info" {{ old('link_style', $pageContent->link_style) == 'info' ? 'selected' : '' }}>Info (Blue)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Layout Tab -->
                    <div class="tab-pane" id="layout">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Layout & Display Options</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Layout Style</label>
                                            <select name="layout_style" class="form-select">
                                                <option value="default" {{ old('layout_style', $pageContent->layout_style ?? 'default') == 'default' ? 'selected' : '' }}>Default (Content First)</option>
                                                <option value="image-left" {{ old('layout_style', $pageContent->layout_style ?? '') == 'image-left' ? 'selected' : '' }}>Image Left, Content Right</option>
                                                <option value="image-right" {{ old('layout_style', $pageContent->layout_style ?? '') == 'image-right' ? 'selected' : '' }}>Image Right, Content Left</option>
                                                <option value="image-top" {{ old('layout_style', $pageContent->layout_style ?? '') == 'image-top' ? 'selected' : '' }}>Image Top, Content Bottom</option>
                                                <option value="image-bottom" {{ old('layout_style', $pageContent->layout_style ?? '') == 'image-bottom' ? 'selected' : '' }}>Image Bottom, Content Top</option>
                                                <option value="full-width" {{ old('layout_style', $pageContent->layout_style ?? '') == 'full-width' ? 'selected' : '' }}>Full Width Image</option>
                                                <option value="boxed" {{ old('layout_style', $pageContent->layout_style ?? '') == 'boxed' ? 'selected' : '' }}>Boxed Content</option>
                                                <option value="centered" {{ old('layout_style', $pageContent->layout_style ?? '') == 'centered' ? 'selected' : '' }}>Centered Content</option>
                                                <option value="card" {{ old('layout_style', $pageContent->layout_style ?? '') == 'card' ? 'selected' : '' }}>Card/Box Style</option>
                                            </select>
                                            <small class="text-muted">How content and media are arranged</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Column Count</label>
                                            <select name="column_count" class="form-select">
                                                <option value="1" {{ old('column_count', $pageContent->column_count ?? '1') == '1' ? 'selected' : '' }}>1 Column (Single)</option>
                                                <option value="2" {{ old('column_count', $pageContent->column_count ?? '') == '2' ? 'selected' : '' }}>2 Columns (Half/Half)</option>
                                                <option value="3" {{ old('column_count', $pageContent->column_count ?? '') == '3' ? 'selected' : '' }}>3 Columns (Thirds)</option>
                                                <option value="4" {{ old('column_count', $pageContent->column_count ?? '') == '4' ? 'selected' : '' }}>4 Columns (Quarter)</option>
                                            </select>
                                            <small class="text-muted">Number of columns for this content</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Background Type</label>
                                            <select name="bg_type" class="form-select" onchange="toggleBgOptions()">
                                                <option value="none" {{ old('bg_type', $pageContent->bg_type ?? 'none') == 'none' ? 'selected' : '' }}>None (Transparent)</option>
                                                <option value="color" {{ old('bg_type', $pageContent->bg_type ?? '') == 'color' ? 'selected' : '' }}>Solid Color</option>
                                                <option value="image" {{ old('bg_type', $pageContent->bg_type ?? '') == 'image' ? 'selected' : '' }}>Background Image</option>
                                                <option value="gradient" {{ old('bg_type', $pageContent->bg_type ?? '') == 'gradient' ? 'selected' : '' }}>Gradient</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6" id="bgColorOption" style="display: {{ old('bg_type', $pageContent->bg_type ?? '') == 'color' ? 'block' : 'none' }};">
                                        <div class="form-group">
                                            <label>Background Color</label>
                                            <input type="color" name="bg_color" class="form-control"
                                                   value="{{ old('bg_color', $pageContent->bg_color ?? '#ffffff') }}" style="height: 40px;">
                                        </div>
                                    </div>
                                    <div class="col-md-6" id="bgImageOption" style="display: {{ old('bg_type', $pageContent->bg_type ?? '') == 'image' ? 'block' : 'none' }};">
                                        <div class="form-group">
                                            <label>Background Image URL</label>
                                            <input type="text" name="bg_image" class="form-control"
                                                   placeholder="e.g., assets/images/bg/pattern.jpg"
                                                   value="{{ old('bg_image', $pageContent->bg_image ?? '') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" id="gradientOption" style="display: {{ old('bg_type', $pageContent->bg_type ?? '') == 'gradient' ? 'block' : 'none' }};">
                                    <label>Gradient Colors (comma separated)</label>
                                    <input type="text" name="bg_gradient" class="form-control"
                                           placeholder="#667eea, #764ba2"
                                           value="{{ old('bg_gradient', $pageContent->bg_gradient ?? '') }}">
                                    <small class="text-muted">Enter hex colors separated by comma</small>
                                </div>

                                <hr>
                                <h6>Spacing</h6>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Padding Top</label>
                                            <select name="padding_top" class="form-select">
                                                <option value="default" {{ old('padding_top', $pageContent->padding_top ?? 'default') == 'default' ? 'selected' : '' }}>Default</option>
                                                <option value="0" {{ old('padding_top', $pageContent->padding_top ?? '') == '0' ? 'selected' : '' }}>None</option>
                                                <option value="small" {{ old('padding_top', $pageContent->padding_top ?? '') == 'small' ? 'selected' : '' }}>Small (20px)</option>
                                                <option value="medium" {{ old('padding_top', $pageContent->padding_top ?? '') == 'medium' ? 'selected' : '' }}>Medium (40px)</option>
                                                <option value="large" {{ old('padding_top', $pageContent->padding_top ?? '') == 'large' ? 'selected' : '' }}>Large (60px)</option>
                                                <option value="xlarge" {{ old('padding_top', $pageContent->padding_top ?? '') == 'xlarge' ? 'selected' : '' }}>Extra Large (80px)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Padding Bottom</label>
                                            <select name="padding_bottom" class="form-select">
                                                <option value="default" {{ old('padding_bottom', $pageContent->padding_bottom ?? 'default') == 'default' ? 'selected' : '' }}>Default</option>
                                                <option value="0" {{ old('padding_bottom', $pageContent->padding_bottom ?? '') == '0' ? 'selected' : '' }}>None</option>
                                                <option value="small" {{ old('padding_bottom', $pageContent->padding_bottom ?? '') == 'small' ? 'selected' : '' }}>Small (20px)</option>
                                                <option value="medium" {{ old('padding_bottom', $pageContent->padding_bottom ?? '') == 'medium' ? 'selected' : '' }}>Medium (40px)</option>
                                                <option value="large" {{ old('padding_bottom', $pageContent->padding_bottom ?? '') == 'large' ? 'selected' : '' }}>Large (60px)</option>
                                                <option value="xlarge" {{ old('padding_bottom', $pageContent->padding_bottom ?? '') == 'xlarge' ? 'selected' : '' }}>Extra Large (80px)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Text Alignment</label>
                                            <select name="text_align" class="form-select">
                                                <option value="default" {{ old('text_align', $pageContent->text_align ?? 'default') == 'default' ? 'selected' : '' }}>Default</option>
                                                <option value="left" {{ old('text_align', $pageContent->text_align ?? '') == 'left' ? 'selected' : '' }}>Left</option>
                                                <option value="center" {{ old('text_align', $pageContent->text_align ?? '') == 'center' ? 'selected' : '' }}>Center</option>
                                                <option value="right" {{ old('text_align', $pageContent->text_align ?? '') == 'right' ? 'selected' : '' }}>Right</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Custom CSS Class</label>
                                            <input type="text" name="css_class" class="form-control"
                                                   placeholder="e.g., shadow-lg"
                                                   value="{{ old('css_class', $pageContent->css_class ?? '') }}">
                                            <small class="text-muted">Additional CSS classes</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Settings Tab -->
                    <div class="tab-pane" id="settings">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Content Settings</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Page *</label>
                                            <select name="page" class="form-select" required>
                                                @foreach(['home', 'about', 'contact', 'prayer-room', 'stream', 'radio', 'testimonies', 'groups', 'news', 'events'] as $pageName)
                                                    <option value="{{ $pageName }}" {{ $pageContent->page == $pageName ? 'selected' : '' }}>
                                                        {{ ucfirst(str_replace('-', ' ', $pageName)) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Section</label>
                                            <div class="section-selector">
                                                <select name="section_select" class="form-select" id="sectionSelect" onchange="handleSectionChange()">
                                                    <option value="">-- Select Existing Section --</option>
                                                    <option value="new">+ Create New Section</option>
                                                    @php
                                                    $commonSections = ['hero', 'features', 'about', 'services', 'testimonials', 'cta', 'footer', 'header', 'sidebar', 'content', 'gallery', 'team', 'pricing', 'faq', 'contact'];
                                                    @endphp
                                                    @foreach($commonSections as $section)
                                                        <option value="{{ $section }}" {{ $pageContent->section == $section ? 'selected' : '' }}>{{ ucfirst($section) }}</option>
                                                    @endforeach
                                                    @if($pageContent->section && !in_array($pageContent->section, $commonSections))
                                                        <option value="{{ $pageContent->section }}" selected>{{ ucfirst($pageContent->section) }}</option>
                                                    @endif
                                                </select>
                                                <input type="text" name="section" class="form-control mt-2" 
                                                       id="sectionInput" 
                                                       placeholder="Enter new section name"
                                                       style="display: none;">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Content Key *</label>
                                    <input type="text" name="key" class="form-control"
                                           placeholder="e.g., hero_title, welcome_text"
                                           value="{{ old('key', $pageContent->key) }}" required>
                                    <small class="text-muted">Unique identifier for this content (no spaces)</small>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Sort Order</label>
                                            <input type="number" name="sort_order" class="form-control"
                                                   value="{{ old('sort_order', $pageContent->sort_order) }}" min="0">
                                            <small class="text-muted">Lower numbers appear first</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select name="is_active" class="form-select">
                                                <option value="1" {{ $pageContent->is_active ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{ !$pageContent->is_active ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.page-content.index', ['page' => $pageContent->page]) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Content
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.language-tabs {
    display: flex;
    flex-wrap: wrap;
    gap: 4px;
    margin-bottom: 16px;
    border-bottom: 1px solid var(--admin-border-color);
    padding-bottom: 16px;
}

.tab-btn {
    padding: 10px 16px;
    border: 1px solid var(--admin-border-color);
    border-radius: var(--admin-border-radius-sm);
    background: var(--admin-bg-light);
    color: var(--admin-text-primary);
    cursor: pointer;
    font-size: 14px;
    transition: all var(--transition-fast);
}

.tab-btn:hover {
    background: var(--admin-border-color);
}

.tab-btn.active {
    background: linear-gradient(135deg, var(--admin-primary), var(--admin-secondary));
    color: white;
    border-color: transparent;
}

.tab-content-wrapper {
    margin-bottom: 24px;
}

.tab-pane {
    display: none;
}

.tab-pane.active {
    display: block;
}

.card {
    background: var(--admin-bg-card);
    border: 1px solid var(--admin-border-color);
    border-radius: var(--admin-border-radius);
    margin-bottom: 16px;
}

.card-header {
    padding: 16px 20px;
    border-bottom: 1px solid var(--admin-border-color);
    background: var(--admin-bg-light);
}

.card-header:first-child {
    border-radius: var(--admin-border-radius) var(--admin-border-radius) 0 0;
}

.card-body {
    padding: 20px;
}

.form-group {
    margin-bottom: 16px;
}

.form-group label {
    display: block;
    margin-bottom: 6px;
    font-weight: 500;
    color: var(--admin-text-primary);
}

.form-control {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid var(--admin-border-color);
    border-radius: var(--admin-border-radius-sm);
    background: var(--admin-bg-light);
    color: var(--admin-text-primary);
    font-size: 14px;
    transition: all var(--transition-fast);
}

.form-control:focus {
    outline: none;
    border-color: var(--admin-primary);
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.form-select {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid var(--admin-border-color);
    border-radius: var(--admin-border-radius-sm);
    background: var(--admin-bg-light);
    color: var(--admin-text-primary);
    font-size: 14px;
    cursor: pointer;
}

.content-editor {
    min-height: 200px;
    font-family: monospace;
}

.mt-2 {
    margin-top: 8px;
}

.btn {
    padding: 10px 20px;
    border-radius: var(--admin-border-radius-sm);
    font-weight: 500;
    cursor: pointer;
    border: none;
    transition: all var(--transition-fast);
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    text-decoration: none;
}

.btn-primary {
    background: linear-gradient(135deg, var(--admin-primary), var(--admin-secondary));
    color: white;
}

.btn-primary:hover {
    opacity: 0.9;
    transform: translateY(-1px);
}

.btn-secondary {
    background: var(--admin-bg-light);
    color: var(--admin-text-primary);
    border: 1px solid var(--admin-border-color);
}

.form-actions {
    display: flex;
    justify-content: space-between;
    padding-top: 16px;
    border-top: 1px solid var(--admin-border-color);
}

.text-right {
    text-align: right;
}

.text-muted {
    color: var(--admin-text-muted);
    font-size: 12px;
    display: block;
    margin-top: 4px;
}

.row {
    display: flex;
    flex-wrap: wrap;
    margin: 0 -8px;
}

.col-md-6 {
    flex: 0 0 50%;
    max-width: 50%;
    padding: 0 8px;
}

.col-md-3 {
    flex: 0 0 25%;
    max-width: 25%;
    padding: 0 8px;
}

hr {
    border: none;
    border-top: 1px solid var(--admin-border-color);
    margin: 20px 0;
}

h6 {
    margin-bottom: 16px;
    color: var(--admin-text-primary);
}

@media (max-width: 768px) {
    .col-md-6, .col-md-3 {
        flex: 0 0 100%;
        max-width: 100%;
    }
}
</style>

<script>
function handleSectionChange() {
    const select = document.getElementById('sectionSelect');
    const input = document.getElementById('sectionInput');
    
    if (select.value === 'new') {
        input.style.display = 'block';
        input.focus();
        select.name = 'section_dummy';
        input.name = 'section';
    } else if (select.value === '') {
        input.style.display = 'none';
        input.name = 'section_dummy';
        select.name = 'section_select';
    } else {
        input.style.display = 'none';
        input.name = 'section_dummy';
        select.name = 'section_select';
    }
}

function toggleBgOptions() {
    const bgType = document.querySelector('select[name="bg_type"]').value;
    const colorOption = document.getElementById('bgColorOption');
    const imageOption = document.getElementById('bgImageOption');
    const gradientOption = document.getElementById('gradientOption');
    
    colorOption.style.display = 'none';
    imageOption.style.display = 'none';
    gradientOption.style.display = 'none';
    
    if (bgType === 'color') {
        colorOption.style.display = 'block';
    } else if (bgType === 'image') {
        imageOption.style.display = 'block';
    } else if (bgType === 'gradient') {
        gradientOption.style.display = 'block';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabPanes = document.querySelectorAll('.tab-pane');

    tabBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            const tabId = this.getAttribute('data-tab');
            tabBtns.forEach(function(b) {
                b.classList.remove('active');
            });
            this.classList.add('active');
            tabPanes.forEach(function(pane) {
                pane.classList.remove('active');
                if (pane.id === tabId) {
                    pane.classList.add('active');
                }
            });
        });
    });
});
</script>
@endsection
