@extends('admin.layouts.app')

@section('main')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 style="color: #333; font-weight: 700;">Edit Radio Station</h2>
        <a href="{{ route('admin.radios') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Radio Stations
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card" style="border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                <div class="card-body" style="padding: 40px;">
                    <form action="{{ route('admin.radios.update', $radio->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 600; color: #333;">Station Name *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $radio->name) }}" required style="border-radius: 8px; padding: 12px 15px;">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 600; color: #333;">Description</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3" style="border-radius: 8px; padding: 12px 15px;">{{ old('description', $radio->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 600; color: #333;">Stream URL *</label>
                            <input type="text" name="stream_url" class="form-control @error('stream_url') is-invalid @enderror" value="{{ old('stream_url', $radio->stream_url) }}" required style="border-radius: 8px; padding: 12px 15px;">
                            @error('stream_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Enter the radio stream URL</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #333;">Genre</label>
                                <input type="text" name="genre" class="form-control @error('genre') is-invalid @enderror" value="{{ old('genre', $radio->genre) }}" placeholder="e.g., Gospel, Worship, Teaching" style="border-radius: 8px; padding: 12px 15px;">
                                @error('genre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #333;">Sort Order</label>
                                <input type="number" name="sort_order" class="form-control @error('sort_order') is-invalid @enderror" value="{{ old('sort_order', $radio->sort_order) }}" style="border-radius: 8px; padding: 12px 15px;">
                                @error('sort_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" {{ old('is_active', $radio->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active" style="font-weight: 600; color: #333;">
                                    Active
                                </label>
                            </div>
                        </div>

                        <div class="d-flex gap-3">
                            <button type="submit" class="btn flex-fill" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 12px 25px; border-radius: 8px; font-weight: 600;">
                                <i class="fas fa-save me-2"></i>Update Station
                            </button>
                            <a href="{{ route('admin.radios') }}" class="btn btn-outline-secondary flex-fill" style="padding: 12px 25px; border-radius: 8px; font-weight: 600;">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection