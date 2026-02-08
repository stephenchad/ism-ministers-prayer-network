@extends('admin.layouts.app')

@section('main')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Add Worship Music</h1>
        <a href="{{ route('admin.worship-music') }}" class="btn btn-secondary">Back to Music</a>
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
            <form action="{{ route('admin.worship-music.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" id="title" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="artist" class="form-label">Artist</label>
                            <input type="text" name="artist" id="artist" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Music Type</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="music_type" id="streaming" value="streaming" checked>
                                    <label class="form-check-label" for="streaming">Streaming</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="music_type" id="download" value="download">
                                    <label class="form-check-label" for="download">Download</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="duration" class="form-label">Duration</label>
                            <input type="text" name="duration" id="duration" class="form-control" placeholder="e.g., 3:45">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="file" class="form-label">Music File</label>
                    <input type="file" name="file" id="file" class="form-control" accept=".mp3,.wav,.m4a" required>
                    <small class="text-muted">Accepted formats: MP3, WAV, M4A (Max: 50MB)</small>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" name="sort_order" id="sort_order" class="form-control" value="0">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" checked>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Add Music</button>
            </form>
        </div>
    </div>
</div>
@endsection