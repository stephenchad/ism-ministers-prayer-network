@extends('admin.layouts.app')

@section('main')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 style="color: #333; font-weight: 700;">Manage Radio Stations</h2>
        <a href="{{ route('admin.radios.create') }}" class="btn" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 12px 25px; border-radius: 8px; font-weight: 600;">
            <i class="fas fa-plus me-2"></i>Add New Station
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        @forelse($radios as $radio)
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card" style="border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                <div class="card-body" style="padding: 25px;">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="card-title" style="color: #333; font-weight: 700; margin-bottom: 5px;">{{ $radio->name }}</h5>
                            @if($radio->genre)
                                <span class="badge bg-info me-2">{{ $radio->genre }}</span>
                            @endif
                            <span class="badge {{ $radio->is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $radio->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                        <i class="fas fa-radio" style="font-size: 2rem; color: #667eea;"></i>
                    </div>
                    
                    @if($radio->description)
                        <p class="card-text" style="color: #6c757d; font-size: 0.9rem; margin-bottom: 15px;">{{ Str::limit($radio->description, 100) }}</p>
                    @endif
                    
                    <div class="mb-3">
                        <small class="text-muted d-block"><i class="fas fa-link me-2"></i>{{ Str::limit($radio->stream_url, 50) }}</small>
                        <small class="text-muted d-block"><i class="fas fa-sort-numeric-up me-2"></i>Sort Order: {{ $radio->sort_order }}</small>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.radios.edit', $radio->id) }}" class="btn btn-outline-primary btn-sm flex-fill">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <button class="btn btn-outline-danger btn-sm flex-fill delete-radio" data-id="{{ $radio->id }}" data-name="{{ $radio->name }}">
                            <i class="fas fa-trash me-1"></i>Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-radio" style="font-size: 4rem; color: #dee2e6; margin-bottom: 20px;"></i>
                <h4 style="color: #6c757d;">No radio stations found</h4>
                <p style="color: #adb5bd;">Start by adding your first radio station</p>
                <a href="{{ route('admin.radios.create') }}" class="btn" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 12px 25px; border-radius: 8px; font-weight: 600;">
                    <i class="fas fa-plus me-2"></i>Add First Station
                </a>
            </div>
        </div>
        @endforelse
    </div>
</div>

<script>
$(document).ready(function() {
    $('.delete-radio').on('click', function() {
        const radioId = $(this).data('id');
        const radioName = $(this).data('name');
        
        if (confirm(`Are you sure you want to delete "${radioName}"?`)) {
            $.ajax({
                url: '{{ route("admin.radios.destroy") }}',
                method: 'DELETE',
                data: { 
                    id: radioId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    }
                },
                error: function(xhr) {
                    console.error('Delete error:', xhr.responseText);
                    alert('Error deleting radio station: ' + (xhr.responseJSON?.message || 'Unknown error'));
                }
            });
        }
    });
});
</script>
@endsection