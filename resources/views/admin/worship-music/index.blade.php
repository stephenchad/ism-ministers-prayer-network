@extends('admin.layouts.app')

@section('main')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Manage Worship Music</h1>
        <a href="{{ route('admin.worship-music.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add Music
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Artist</th>
                            <th>Type</th>
                            <th>Duration</th>
                            <th>Size</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($music as $item)
                        <tr>
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->artist ?: 'N/A' }}</td>
                            <td>
                                <span class="badge bg-{{ $item->music_type == 'streaming' ? 'info' : 'success' }}">
                                    {{ ucfirst($item->music_type) }}
                                </span>
                            </td>
                            <td>{{ $item->duration ?: 'N/A' }}</td>
                            <td>{{ $item->file_size }}</td>
                            <td>
                                <span class="badge bg-{{ $item->is_active ? 'success' : 'secondary' }}">
                                    {{ $item->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.worship-music.edit', $item->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-danger" onclick="deleteMusic({{ $item->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-music fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No worship music found</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function deleteMusic(id) {
    if (confirm('Are you sure you want to delete this music?')) {
        $.ajax({
            url: '{{ route("admin.worship-music.destroy") }}',
            method: 'DELETE',
            data: { 
                id: id,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                }
            }
        });
    }
}
</script>
@endsection