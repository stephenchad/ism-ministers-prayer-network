@extends('admin.layouts.app')

@section('title', 'News & Events')

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
                    <i class="fas fa-newspaper me-1"></i>
                    News & Events
                </li>
            </ol>
        </nav>
    </div>

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">News & Events Management</h1>
            <p class="page-subtitle">Manage all news articles and events</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>
                Add New
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid fade-in">
        <div class="stat-card">
            <div class="stat-icon primary">
                <i class="fas fa-newspaper"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-value">{{ $news->count() }}</h3>
                <p class="stat-label">Total Items</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon success">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-value">{{ $news->where('type', 'event')->count() }}</h3>
                <p class="stat-label">Events</p>
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

    <!-- News Cards -->
    <div class="admin-card fade-in">
        <div class="card-header">
            <h5 class="card-title">All News & Events</h5>
        </div>
        <div class="card-body p-0">
            @if($news->count() > 0)
                <div class="row g-0">
                    @foreach($news as $article)
                        <div class="col-lg-4 col-md-6">
                            <div class="news-card">
                                @if($article->image)
                                    <div class="news-card-image">
                                        <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}">
                                    </div>
                                @else
                                    <div class="news-card-image news-card-placeholder">
                                        <i class="fas {{ $article->type == 'event' ? 'fa-calendar-alt' : 'fa-newspaper' }}"></i>
                                    </div>
                                @endif
                                <div class="news-card-body">
                                    <div class="news-card-badges">
                                        <span class="badge bg-{{ $article->type == 'event' ? 'success' : 'primary' }}">{{ strtoupper($article->type) }}</span>
                                        <span class="badge {{ $article->status ? 'bg-success' : 'bg-secondary' }}">{{ $article->status ? 'Active' : 'Inactive' }}</span>
                                    </div>
                                    <h6 class="news-card-title">{{ Str::limit($article->title, 50) }}</h6>
                                    <p class="news-card-text">{{ Str::limit($article->excerpt, 80) }}</p>
                                    @if($article->type == 'event' && $article->event_date)
                                        <div class="news-card-event">
                                            <i class="fas fa-calendar"></i>
                                            <span>{{ $article->event_date->format('M d, Y - g:i A') }}</span>
                                        </div>
                                    @endif
                                    <div class="news-card-footer">
                                        <small class="text-muted">{{ $article->created_at->format('M d, Y') }}</small>
                                        <div class="news-card-actions">
                                            <a href="{{ route('admin.news.edit', $article->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger delete-btn" data-id="{{ $article->id }}">
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
                    <i class="fas fa-newspaper fa-4x mb-4 text-muted opacity-50"></i>
                    <h5 class="text-muted">No News or Events Found</h5>
                    <p class="text-muted mb-4">Start by creating your first news article or event.</p>
                    <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Create First Article
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
                if (confirm('Are you sure you want to delete this item?')) {
                    $.ajax({
                        url: '{{ url("admin/news") }}/' + id,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
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
