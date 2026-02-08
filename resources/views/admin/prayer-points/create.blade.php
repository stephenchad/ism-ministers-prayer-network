@extends('admin.layouts.app')

@section('main')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create New Prayer Point</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.prayer-points.store') }}" method="POST">
                        @csrf

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" id="languageTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="english-tab" data-bs-toggle="tab" data-bs-target="#english" type="button" role="tab" aria-controls="english" aria-selected="true">🇺🇸 English *</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="spanish-tab" data-bs-toggle="tab" data-bs-target="#spanish" type="button" role="tab" aria-controls="spanish" aria-selected="false">🇪🇸 Spanish</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="french-tab" data-bs-toggle="tab" data-bs-target="#french" type="button" role="tab" aria-controls="french" aria-selected="false">🇫🇷 French</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="chinese-tab" data-bs-toggle="tab" data-bs-target="#chinese" type="button" role="tab" aria-controls="chinese" aria-selected="false">🇨🇳 Mandarin</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="arabic-tab" data-bs-toggle="tab" data-bs-target="#arabic" type="button" role="tab" aria-controls="arabic" aria-selected="false">🇸🇦 Arabic</button>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content mt-3" id="languageTabsContent">
                            <div class="tab-pane fade show active" id="english" role="tabpanel" aria-labelledby="english-tab">
                                <div class="form-group">
                                    <label for="title">Title (English) <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="content">Content (English) <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('content') is-invalid @enderror rich-text" id="content" name="content" rows="5" required>{{ old('content') }}</textarea>
                                    @error('content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="tab-pane fade" id="spanish" role="tabpanel" aria-labelledby="spanish-tab">
                                <div class="form-group">
                                    <label for="title_es">Title (Spanish)</label>
                                    <input type="text" class="form-control @error('title_es') is-invalid @enderror" id="title_es" name="title_es" value="{{ old('title_es') }}">
                                    @error('title_es')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="content_es">Content (Spanish)</label>
                                    <textarea class="form-control @error('content_es') is-invalid @enderror rich-text" id="content_es" name="content_es" rows="5">{{ old('content_es') }}</textarea>
                                    @error('content_es')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="tab-pane fade" id="french" role="tabpanel" aria-labelledby="french-tab">
                                <div class="form-group">
                                    <label for="title_fr">Title (French)</label>
                                    <input type="text" class="form-control @error('title_fr') is-invalid @enderror" id="title_fr" name="title_fr" value="{{ old('title_fr') }}">
                                    @error('title_fr')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="content_fr">Content (French)</label>
                                    <textarea class="form-control @error('content_fr') is-invalid @enderror rich-text" id="content_fr" name="content_fr" rows="5">{{ old('content_fr') }}</textarea>
                                    @error('content_fr')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="tab-pane fade" id="chinese" role="tabpanel" aria-labelledby="chinese-tab">
                                <div class="form-group">
                                    <label for="title_zh">Title (Mandarin Chinese)</label>
                                    <input type="text" class="form-control @error('title_zh') is-invalid @enderror" id="title_zh" name="title_zh" value="{{ old('title_zh') }}">
                                    @error('title_zh')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="content_zh">Content (Mandarin Chinese)</label>
                                    <textarea class="form-control @error('content_zh') is-invalid @enderror rich-text" id="content_zh" name="content_zh" rows="5">{{ old('content_zh') }}</textarea>
                                    @error('content_zh')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="tab-pane fade" id="arabic" role="tabpanel" aria-labelledby="arabic-tab">
                                <div class="form-group">
                                    <label for="title_ar">Title (Arabic)</label>
                                    <input type="text" class="form-control @error('title_ar') is-invalid @enderror" id="title_ar" name="title_ar" value="{{ old('title_ar') }}">
                                    @error('title_ar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="content_ar">Content (Arabic)</label>
                                    <textarea class="form-control @error('content_ar') is-invalid @enderror rich-text" id="content_ar" name="content_ar" rows="5">{{ old('content_ar') }}</textarea>
                                    @error('content_ar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary">Create Prayer Point</button>
                            <a href="{{ route('admin.prayer-points.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.ckeditor.com/4.25.1-lts/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replaceAll('.rich-text');
</script>
@endsection
