@extends('admin.layouts.app')

@section('main')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 style="color: #333; font-weight: 700;">Manage Streams</h2>
        <a href="{{ route('admin.streams.create') }}" class="btn" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 12px 25px; border-radius: 8px; font-weight: 600;">
            <i class="fas fa-plus me-2"></i>Add New Stream
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        @forelse($streams as $stream)
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card" style="border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                <div class="card-body" style="padding: 25px;">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="card-title" style="color: #333; font-weight: 700; margin-bottom: 5px;">{{ $stream->title }}</h5>
                            <span class="badge {{ $stream->type === 'live' ? 'bg-danger' : 'bg-info' }} me-2">{{ ucfirst($stream->type) }}</span>
                            <span class="badge bg-warning text-dark me-2">{{ strtoupper($stream->format ?? 'URL') }}</span>
                            <span class="badge {{ $stream->is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $stream->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                    
                    @if($stream->description)
                        <p class="card-text" style="color: #6c757d; font-size: 0.9rem; margin-bottom: 15px;">{{ Str::limit($stream->description, 100) }}</p>
                    @endif
                    
                    <div class="mb-3">
                        <small class="text-muted d-block"><i class="fas fa-link me-2"></i>{{ Str::limit($stream->stream_url, 50) }}</small>
                        @if($stream->scheduled_at)
                            <small class="text-muted d-block"><i class="fas fa-calendar me-2"></i>{{ $stream->scheduled_at->format('M d, Y H:i') }}</small>
                        @endif
                    </div>
                    
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.streams.edit', $stream->id) }}" class="btn btn-outline-primary btn-sm flex-fill">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <button class="btn btn-outline-danger btn-sm flex-fill delete-stream" data-id="{{ $stream->id }}" data-title="{{ $stream->title }}">
                            <i class="fas fa-trash me-1"></i>Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-video" style="font-size: 4rem; color: #dee2e6; margin-bottom: 20px;"></i>
                <h4 style="color: #6c757d;">No streams found</h4>
                <p style="color: #adb5bd;">Start by adding your first stream</p>
                <a href="{{ route('admin.streams.create') }}" class="btn" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 12px 25px; border-radius: 8px; font-weight: 600;">
                    <i class="fas fa-plus me-2"></i>Add First Stream
                </a>
            </div>
        </div>
        @endforelse
    </div>
</div>

<script>
$(document).ready(function() {
    $('.delete-stream').on('click', function() {
        const streamId = $(this).data('id');
        const streamTitle = $(this).data('title');
        
        if (confirm(`Are you sure you want to delete "${streamTitle}"?`)) {
            $.ajax({
                url: '{{ route("admin.streams.destroy") }}',
                method: 'DELETE',
                data: { id: streamId },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    }
                },
                error: function() {
                    alert('Error deleting stream');
                }
            });
        }
    });
});
</script>
@endsection