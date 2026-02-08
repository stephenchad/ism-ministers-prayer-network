@extends('admin.layouts.app')

@section('main')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Edit Prayer Resource</h1>
        <a href="{{ route('admin.prayer-resources') }}" class="btn btn-secondary">Back to Resources</a>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.prayer-resources.update', $resource->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ $resource->title }}" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="3" required>{{ $resource->description }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Resource Type</label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="resource_type" id="type_file" value="file" {{ $resource->resource_type === 'file' ? 'checked' : '' }} disabled>
                            <label class="form-check-label" for="type_file">File Download</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="resource_type" id="type_video" value="video" {{ $resource->resource_type === 'video' ? 'checked' : '' }} disabled>
                            <label class="form-check-label" for="type_video">Video Resource</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="resource_type" id="type_guide" value="guide" {{ $resource->resource_type === 'guide' ? 'checked' : '' }} disabled>
                            <label class="form-check-label" for="type_guide">Prayer Guide</label>
                        </div>
                        <input type="hidden" name="resource_type" value="{{ $resource->resource_type }}">
                    </div>
                </div>

                @if($resource->resource_type === 'file')
                <div class="mb-3" id="file_section">
                    <label for="file" class="form-label">File</label>
                    <input type="file" name="file" id="file" class="form-control" accept=".pdf,.doc,.docx">
                    <small class="text-muted">Leave empty to keep current file. Accepted formats: PDF, DOC, DOCX (Max: 10MB)</small>
                    @if($resource->file_path)
                        <div class="mt-2">
                            <small class="text-info">Current file: {{ basename($resource->file_path) }} ({{ $resource->file_size }})</small>
                        </div>
                    @endif
                </div>
                @endif

                @if($resource->resource_type === 'video')
                <div id="video_section">
                    <div class="mb-3">
                        <label for="video_url" class="form-label">Video URL</label>
                        <input type="url" name="video_url" id="video_url" class="form-control" value="{{ $resource->video_url }}" placeholder="https://youtube.com/watch?v=...">
                        <small class="text-muted">YouTube, Vimeo, or any video URL</small>
                    </div>
                    <div class="mb-3">
                        <label for="video_file" class="form-label">Or Upload New Video File</label>
                        <input type="file" name="video_file" id="video_file" class="form-control" accept=".mp4,.avi,.mov,.wmv">
                        <small class="text-muted">Leave empty to keep current file. Accepted formats: MP4, AVI, MOV, WMV (Max: 100MB)</small>
                        @if($resource->video_file)
                            <div class="mt-2">
                                <small class="text-info">Current file: {{ basename($resource->video_file) }}</small>
                            </div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="duration" class="form-label">Duration</label>
                        <input type="text" name="duration" id="duration" class="form-control" value="{{ $resource->duration }}" placeholder="e.g., 15 min">
                    </div>
                </div>
                @endif

                @if($resource->resource_type === 'guide')
                <div id="guide_section">
                    <div class="mb-3">
                        <label for="guide_content" class="form-label">Guide Content</label>
                        <textarea name="guide_content" id="guide_content" class="form-control" rows="10">{{ $resource->guide_content }}</textarea>
                        <small class="text-muted">Use the formatting toolbar to style your content</small>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="reading_time" class="form-label">Reading Time</label>
                                <input type="text" name="reading_time" id="reading_time" class="form-control" value="{{ $resource->reading_time }}" placeholder="e.g., 5 min">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="icon" class="form-label">Icon (FontAwesome)</label>
                                <input type="text" name="icon" id="icon" class="form-control" value="{{ $resource->icon }}" placeholder="e.g., fa-heart">
                                <small class="text-muted">FontAwesome icon class without 'fas'</small>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ $resource->sort_order }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ $resource->is_active ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update Resource</button>
            </form>
        </div>
    </div>
</div>

@if($resource->resource_type === 'guide')
<!-- Summernote CSS and JS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Summernote for guide content
    $('#guide_content').summernote({
        height: 400,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });
});
</script>
@endif
@endsection