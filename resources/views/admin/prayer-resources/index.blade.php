@extends('admin.layouts.app')

@section('main')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Prayer Resources</h1>
        <a href="{{ route('admin.prayer-resources.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add Resource
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
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
                            <th>Description</th>
                            <th>File Type</th>
                            <th>File Size</th>
                            <th>Status</th>
                            <th>Sort Order</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($resources as $resource)
                        <tr>
                            <td>{{ $resource->title }}</td>
                            <td>{{ Str::limit($resource->description, 50) }}</td>
                            <td>
                                <span class="badge bg-info">{{ strtoupper($resource->file_type) }}</span>
                            </td>
                            <td>{{ $resource->file_size }}</td>
                            <td>
                                @if($resource->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $resource->sort_order }}</td>
                            <td>
                                <a href="{{ route('admin.prayer-resources.edit', $resource->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-danger" onclick="deleteResource({{ $resource->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <p class="text-muted mb-0">No prayer resources found</p>
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
function deleteResource(id) {
    if (confirm('Are you sure you want to delete this resource?')) {
        $.ajax({
            url: '{{ route("admin.prayer-resources.destroy") }}',
            type: 'DELETE',
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