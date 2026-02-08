@extends('admin.layouts.app')

@section('main')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 style="color: #333; font-weight: 700;">Manage Coordinators</h2>
        <a href="{{ route('admin.coordinators.create') }}" class="btn" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 12px 25px; border-radius: 8px; font-weight: 600;">
            <i class="fas fa-plus me-2"></i>Add New Coordinator
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        @forelse($coordinators as $coordinator)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card" style="border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); overflow: hidden;">
                @if($coordinator->image)
                    <img src="{{ asset($coordinator->image) }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="{{ $coordinator->name }}">
                @else
                    <div style="height: 200px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem; font-weight: 700;">
                        {{ strtoupper(substr($coordinator->name, 0, 2)) }}
                    </div>
                @endif
                
                <div class="card-body" style="padding: 25px;">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="card-title" style="color: #333; font-weight: 700; margin-bottom: 5px;">{{ $coordinator->name }}</h5>
                            <p class="text-muted" style="font-size: 0.9rem; margin-bottom: 0;">{{ $coordinator->title }}</p>
                        </div>
                        <span class="badge {{ $coordinator->is_active ? 'bg-success' : 'bg-secondary' }}">
                            {{ $coordinator->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    
                    <p class="card-text" style="color: #6c757d; font-size: 0.9rem; margin-bottom: 15px;">{{ Str::limit($coordinator->description, 100) }}</p>
                    
                    <div class="mb-3">
                        <small class="text-muted d-block"><i class="fas fa-phone me-2"></i>{{ $coordinator->phone }}</small>
                        <small class="text-muted d-block"><i class="fas fa-envelope me-2"></i>{{ $coordinator->email }}</small>
                        <small class="text-muted d-block"><i class="fas fa-clock me-2"></i>{{ $coordinator->availability }}</small>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.coordinators.edit', $coordinator->id) }}" class="btn btn-outline-primary btn-sm flex-fill">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <button class="btn btn-outline-danger btn-sm flex-fill delete-coordinator" data-id="{{ $coordinator->id }}" data-name="{{ $coordinator->name }}">
                            <i class="fas fa-trash me-1"></i>Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-users" style="font-size: 4rem; color: #dee2e6; margin-bottom: 20px;"></i>
                <h4 style="color: #6c757d;">No coordinators found</h4>
                <p style="color: #adb5bd;">Start by adding your first coordinator</p>
                <a href="{{ route('admin.coordinators.create') }}" class="btn" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 12px 25px; border-radius: 8px; font-weight: 600;">
                    <i class="fas fa-plus me-2"></i>Add First Coordinator
                </a>
            </div>
        </div>
        @endforelse
    </div>
</div>

<script>
$(document).ready(function() {
    $('.delete-coordinator').on('click', function() {
        const coordinatorId = $(this).data('id');
        const coordinatorName = $(this).data('name');
        
        if (confirm(`Are you sure you want to delete ${coordinatorName}?`)) {
            $.ajax({
                url: '{{ route("admin.coordinators.destroy") }}',
                method: 'DELETE',
                data: { id: coordinatorId },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    }
                },
                error: function() {
                    alert('Error deleting coordinator');
                }
            });
        }
    });
});
</script>
@endsection