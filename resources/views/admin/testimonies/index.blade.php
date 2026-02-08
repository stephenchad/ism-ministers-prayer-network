@extends('admin.layouts.app')

@section('main')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Manage Testimonies</h1>
        <a href="{{ route('admin.testimonies.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add Testimony
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
                            <th>Name</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Location</th>
                            <th>Published</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($testimonies as $testimony)
                        <tr>
                            <td>{{ $testimony->name }}</td>
                            <td>{{ Str::limit($testimony->title, 40) }}</td>
                            <td>{{ $testimony->category }}</td>
                            <td>{{ $testimony->location ?: 'N/A' }}</td>
                            <td>
                                <span class="badge bg-{{ $testimony->allow_publish ? 'success' : 'warning' }}">
                                    {{ $testimony->allow_publish ? 'Yes' : 'No' }}
                                </span>
                            </td>
                            <td>{{ $testimony->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('admin.testimonies.edit', $testimony->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-danger" onclick="deleteTestimony({{ $testimony->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-heart fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No testimonies found</p>
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
function deleteTestimony(id) {
    if (confirm('Are you sure you want to delete this testimony?')) {
        $.ajax({
            url: '{{ route("admin.testimonies.destroy") }}',
            method: 'DELETE',
            data: { id: id },
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