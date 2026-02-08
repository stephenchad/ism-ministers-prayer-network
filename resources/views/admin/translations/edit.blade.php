@extends('admin.layouts.app')

@section('main')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Edit Translation</h1>
        <a href="{{ route('admin.translations.index') }}" class="btn btn-secondary">Back</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.translations.update', $translation->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Group *</label>
                        <input type="text" name="group" class="form-control @error('group') is-invalid @enderror" value="{{ old('group', $translation->group) }}" required>
                        @error('group')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Key *</label>
                        <input type="text" name="key" class="form-control @error('key') is-invalid @enderror" value="{{ old('key', $translation->key) }}" required>
                        @error('key')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <hr>

                <div class="mb-3">
                    <label class="form-label">English * 🇬🇧</label>
                    <textarea name="text_en" class="form-control @error('text_en') is-invalid @enderror" rows="2" required>{{ old_string('text_en', is_array($translation->text) ? ($translation->text['en'] ?? '') : '') }}</textarea>
                    @error('text_en')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Spanish 🇪🇸</label>
                    <textarea name="text_es" class="form-control @error('text_es') is-invalid @enderror" rows="2">{{ old_string('text_es', is_array($translation->text) ? ($translation->text['es'] ?? '') : '') }}</textarea>
                    @error('text_es')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">French 🇫🇷</label>
                    <textarea name="text_fr" class="form-control @error('text_fr') is-invalid @enderror" rows="2">{{ old_string('text_fr', is_array($translation->text) ? ($translation->text['fr'] ?? '') : '') }}</textarea>
                    @error('text_fr')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Portuguese 🇵🇹</label>
                    <textarea name="text_pt" class="form-control @error('text_pt') is-invalid @enderror" rows="2">{{ old_string('text_pt', is_array($translation->text) ? ($translation->text['pt'] ?? '') : '') }}</textarea>
                    @error('text_pt')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">German 🇩🇪</label>
                    <textarea name="text_de" class="form-control @error('text_de') is-invalid @enderror" rows="2">{{ old_string('text_de', is_array($translation->text) ? ($translation->text['de'] ?? '') : '') }}</textarea>
                    @error('text_de')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <button type="submit" class="btn btn-primary">Update Translation</button>
            </form>
        </div>
    </div>
</div>
@endsection
