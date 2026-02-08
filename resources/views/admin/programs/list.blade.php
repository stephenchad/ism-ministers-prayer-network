@extends('admin.layouts.app')

@section('title', 'Programs')

@section('main')
    <!-- Breadcrumb -->
    <div class="breadcrumb-container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-home me-1"></i>
                        Home
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fas fa-calendar-alt me-1"></i>
                    Programs
                </li>
            </ol>
        </nav>
    </div>

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Programs Management</h1>
            <p class="page-subtitle">Manage all ministry programs and activities</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('admin.programs.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>
                Add New
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid fade-in">
        <div class="stat-card">
            <div class="stat-icon primary">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-value">{{ $programs->count() }}</h3>
                <p class="stat-label">Total Programs</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon success">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-value">{{ $programs->where('status', 1)->count() }}</h3>
                <p class="stat-label">Active Programs</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon info">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-value">{{ date('H:i') }}</h3>
                <p class="stat-label">{{ date('M d, Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Programs Cards -->
    <div class="admin-card fade-in">
        <div class="card-header">
            <h5 class="card-title">All Programs</h5>
        </div>
        <div class="card-body p-0">
            @if($programs->count() > 0)
                <div class="row g-0">
                    @foreach($programs as $program)
                        <div class="col-lg-4 col-md-6">
                            <div class="news-card">
                                @if($program->image)
                                    <div class="news-card-image">
                                        <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->title }}">
                                    </div>
                                @else
                                    <div class="news-card-image news-card-placeholder" style="background: {{ $program->color }};">
                                        <i class="{{ $program->icon }}"></i>
                                    </div>
                                @endif
                                <div class="news-card-body">
                                    <div class="news-card-badges">
                                        <span class="badge bg-primary">PROGRAM</span>
                                        <span class="badge {{ $program->status ? 'bg-success' : 'bg-secondary' }}">{{ $program->status ? 'Active' : 'Inactive' }}</span>
                                    </div>
                                    <h6 class="news-card-title">{{ Str::limit($program->title, 50) }}</h6>
                                    <p class="news-card-text">{{ Str::limit($program->description, 80) }}</p>
                                    <div class="news-card-event">
                                        <i class="fas fa-clock"></i>
                                        <span>{{ $program->schedule }}</span>
                                    </div>
                                    <div class="news-card-event">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span>{{ $program->location }}</span>
                                    </div>
                                    <div class="news-card-footer">
                                        <small class="text-muted">{{ $program->created_at->format('M d, Y') }}</small>
                                        <div class="news-card-actions">
                                            <a href="{{ route('admin.programs.edit', $program->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger delete-btn" data-id="{{ $program->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-calendar-alt fa-4x mb-4 text-muted opacity-50"></i>
                    <h5 class="text-muted">No Programs Found</h5>
                    <p class="text-muted mb-4">Start by creating your first ministry program.</p>
                    <a href="{{ route('admin.programs.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Create First Program
                    </a>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            $('.delete-btn').click(function() {
                var id = $(this).data('id');
                if (confirm('Are you sure you want to delete this program?')) {
                    $.ajax({
                        url: '{{ route("admin.programs.destroy") }}',
                        type: 'DELETE',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status) {
                                location.reload();
                            }
                        }
                    });
                }
            });
        });
    </script>
    @endpush
@endsection
