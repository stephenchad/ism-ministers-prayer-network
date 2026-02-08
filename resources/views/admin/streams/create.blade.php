@extends('admin.layouts.app')

@section('main')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 style="color: #333; font-weight: 700;">Add New Stream</h2>
        <a href="{{ route('admin.streams') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Streams
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card" style="border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                <div class="card-body" style="padding: 40px;">
                    <form action="{{ route('admin.streams.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 600; color: #333;">Title *</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required style="border-radius: 8px; padding: 12px 15px;">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 600; color: #333;">Description</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3" style="border-radius: 8px; padding: 12px 15px;">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 600; color: #333;">Stream URL *</label>
                            <input type="text" name="stream_url" class="form-control @error('stream_url') is-invalid @enderror" value="{{ old('stream_url') }}" required style="border-radius: 8px; padding: 12px 15px;">
                            @error('stream_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Enter the streaming URL or HLS stream path</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="font-weight: 600; color: #333;">Format *</label>
                            <select name="format" class="form-control @error('format') is-invalid @enderror" required style="border-radius: 8px; padding: 12px 15px;">
                                <option value="url" {{ old('format') === 'url' ? 'selected' : '' }}>Direct Video URL (MP4, etc.)</option>
                                <option value="hls" {{ old('format') === 'hls' ? 'selected' : '' }}>HLS Stream (.m3u8)</option>
                            </select>
                            @error('format')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Note: For YouTube/Vimeo, use embed links or direct video URLs if available. RTMP is not supported.</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #333;">Type *</label>
                                <select name="type" class="form-control @error('type') is-invalid @enderror" required style="border-radius: 8px; padding: 12px 15px;">
                                    <option value="live" {{ old('type') === 'live' ? 'selected' : '' }}>Live Stream</option>
                                    <option value="recorded" {{ old('type') === 'recorded' ? 'selected' : '' }}>Recorded</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-weight: 600; color: #333;">Scheduled At</label>
                                <input type="datetime-local" name="scheduled_at" class="form-control @error('scheduled_at') is-invalid @enderror" value="{{ old('scheduled_at') }}" style="border-radius: 8px; padding: 12px 15px;">
                                @error('scheduled_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active" style="font-weight: 600; color: #333;">
                                    Active
                                </label>
                            </div>
                        </div>

                        <div class="d-flex gap-3">
                            <button type="submit" class="btn flex-fill" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 12px 25px; border-radius: 8px; font-weight: 600;">
                                <i class="fas fa-save me-2"></i>Create Stream
                            </button>
                            <a href="{{ route('admin.streams') }}" class="btn btn-outline-secondary flex-fill" style="padding: 12px 25px; border-radius: 8px; font-weight: 600;">
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