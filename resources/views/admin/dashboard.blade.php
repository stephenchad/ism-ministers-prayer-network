@extends('admin.layouts.app')

@section('title', 'Dashboard')

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
                    <i class="fas fa-tachometer-alt me-1"></i>
                    Dashboard
                </li>
            </ol>
        </nav>
    </div>

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Admin Dashboard</h1>
            <p class="page-subtitle">Welcome back, {{ Auth::user()->name ?? 'Admin' }}! Here's what's happening with your prayer network.</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('home') }}" class="btn btn-secondary" target="_blank">
                <i class="fas fa-external-link-alt"></i>
                View Website
            </a>
            <a href="{{ route('admin.reports') }}" class="btn btn-secondary">
                <i class="fas fa-chart-bar"></i>
                Reports
            </a>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions">
        <a href="{{ route('admin.users.create') }}" class="quick-action-btn">
            <i class="fas fa-user-plus"></i>
            <span>Add User</span>
        </a>
        <a href="{{ route('admin.groups.create') }}" class="quick-action-btn">
            <i class="fas fa-users-cog"></i>
            <span>Create Group</span>
        </a>
        <a href="{{ route('admin.programs.create') }}" class="quick-action-btn">
            <i class="fas fa-calendar-plus"></i>
            <span>Add Program</span>
        </a>
        <a href="{{ route('admin.news.create') }}" class="quick-action-btn">
            <i class="fas fa-newspaper"></i>
            <span>Post News</span>
        </a>
        <a href="{{ route('admin.testimonies.create') }}" class="quick-action-btn">
            <i class="fas fa-heart"></i>
            <span>Add Testimony</span>
        </a>
        <a href="{{ route('admin.bulk-messages.create') }}" class="quick-action-btn">
            <i class="fas fa-paper-plane"></i>
            <span>Send Message</span>
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid fade-in">
        <div class="stat-card">
            <div class="stat-icon primary">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-value">{{ $stats['users'] ?? 0 }}</h3>
                <p class="stat-label">Total Users</p>
                <div class="stat-trend up">
                    <i class="fas fa-arrow-up"></i>
                    <span>+12% this month</span>
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon success">
                <i class="fas fa-users-cog"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-value">{{ $stats['groups'] ?? 0 }}</h3>
                <p class="stat-label">Prayer Groups</p>
                <div class="stat-trend up">
                    <i class="fas fa-arrow-up"></i>
                    <span>+8% this month</span>
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon warning">
                <i class="fas fa-praying-hands"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-value">{{ $stats['prayers'] ?? 0 }}</h3>
                <p class="stat-label">Prayer Requests</p>
                <div class="stat-trend up">
                    <i class="fas fa-arrow-up"></i>
                    <span>+15% this month</span>
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon info">
                <i class="fas fa-user-tie"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-value">{{ $stats['coordinators'] ?? 0 }}</h3>
                <p class="stat-label">Coordinators</p>
                <div class="stat-trend up">
                    <i class="fas fa-check"></i>
                    <span>All active</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Stats -->
    <div class="stats-grid fade-in" style="animation-delay: 0.2s;">
        <div class="stat-card">
            <div class="stat-icon primary">
                <i class="fas fa-newspaper"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-value">{{ $stats['news'] ?? 0 }}</h3>
                <p class="stat-label">News & Events</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon success">
                <i class="fas fa-heart"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-value">{{ $stats['testimonies'] ?? 0 }}</h3>
                <p class="stat-label">Testimonies</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon warning">
                <i class="fas fa-video"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-value">{{ $stats['streams'] ?? 0 }}</h3>
                <p class="stat-label">Live Streams</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon danger">
                <i class="fas fa-bell"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-value">{{ $stats['notifications_unread'] ?? 0 }}</h3>
                <p class="stat-label">Unread Notifications</p>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row g-4 mt-2 fade-in" style="animation-delay: 0.3s;">
        <div class="col-lg-6">
            <div class="admin-card">
                <div class="card-header">
                    <div>
                        <h5 class="card-title">Recent Users</h5>
                        <small class="card-subtitle">Latest registered users</small>
                    </div>
                    <a href="{{ route('admin.users') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-eye me-1"></i>View All
                    </a>
                </div>
                <div class="card-body p-0">
                    @if($stats['recent_users']->isNotEmpty())
                        <div class="table-responsive">
                            <table class="admin-table mb-0">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Role</th>
                                        <th>Joined</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($stats['recent_users']->take(5) as $user)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="profile-avatar" style="width: 36px; height: 36px; font-size: 12px;">
                                                        {{ substr($user->name, 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold">{{ $user->name }}</div>
                                                        <small class="text-muted">{{ $user->email }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $user->role === 'admin' ? 'danger' : 'primary' }}">
                                                    {{ ucfirst($user->role) }}
                                                </span>
                                            </td>
                                            <td>{{ $user->created_at->diffForHumans() }}</td>
                                            <td>
                                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-icon btn-secondary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-users fa-2x mb-2 text-muted opacity-50"></i>
                            <p class="text-muted mb-0">No recent users</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="admin-card">
                <div class="card-header">
                    <div>
                        <h5 class="card-title">Prayer Coordinators</h5>
                        <small class="card-subtitle">Active coordinators</small>
                    </div>
                    <a href="{{ route('admin.coordinators') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-eye me-1"></i>View All
                    </a>
                </div>
                <div class="card-body p-0">
                    @if($stats['recent_coordinators']->isNotEmpty())
                        <div class="table-responsive">
                            <table class="admin-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Coordinator</th>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($stats['recent_coordinators']->take(5) as $coordinator)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-3">
                                                    @if($coordinator->image)
                                                        <img src="{{ asset($coordinator->image) }}" class="rounded-circle" style="width: 36px; height: 36px; object-fit: cover;" alt="{{ $coordinator->name }}">
                                                    @else
                                                        <div class="profile-avatar" style="width: 36px; height: 36px; font-size: 12px;">
                                                            {{ substr($coordinator->name, 0, 1) }}
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <div class="fw-semibold">{{ $coordinator->name }}</div>
                                                        <small class="text-muted">{{ $coordinator->email }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $coordinator->title }}</td>
                                            <td>
                                                <span class="badge badge-{{ $coordinator->is_active ? 'success' : 'secondary' }}">
                                                    {{ $coordinator->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.coordinators.edit', $coordinator) }}" class="btn btn-sm btn-icon btn-secondary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-user-tie fa-2x mb-2 text-muted opacity-50"></i>
                            <p class="text-muted mb-0">No coordinators found</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity & Prayer Requests -->
    <div class="row g-4 mt-2 fade-in" style="animation-delay: 0.4s;">
        <div class="col-lg-6">
            <div class="admin-card">
                <div class="card-header">
                    <div>
                        <h5 class="card-title">Recent Prayer Requests</h5>
                        <small class="card-subtitle">Latest prayer needs</small>
                    </div>
                    <a href="{{ route('admin.prayer-requests.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-eye me-1"></i>View All
                    </a>
                </div>
                <div class="card-body">
                    @if(isset($stats['recent_prayers']) && $stats['recent_prayers']->isNotEmpty())
                        @foreach($stats['recent_prayers']->take(3) as $prayer)
                            <div class="d-flex gap-3 p-3 border-bottom" style="border-color: var(--admin-border-color);">
                                <div class="stat-icon warning" style="width: 40px; height: 40px; font-size: 14px;">
                                    <i class="fas fa-pray"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-semibold">{{ $prayer->title ?? 'Prayer Request' }}</div>
                                    <small class="text-muted">{{ Str::limit($prayer->content ?? '', 80) }}</small>
                                    <div class="d-flex justify-content-between mt-2">
                                        <small class="text-muted">{{ $prayer->created_at->diffForHumans() }}</small>
                                        <span class="badge badge-{{ $prayer->isanswered ? 'success' : 'warning' }}">
                                            {{ $prayer->isanswered ? 'Answered' : 'Pending' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-praying-hands fa-2x mb-2 text-muted opacity-50"></i>
                            <p class="text-muted mb-0">No prayer requests</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="admin-card">
                <div class="card-header">
                    <div>
                        <h5 class="card-title">Quick Links</h5>
                        <small class="card-subtitle">Frequently accessed</small>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <a href="{{ route('admin.groups') }}" class="quick-action-btn w-100" style="justify-content: flex-start;">
                                <i class="fas fa-users text-primary"></i>
                                <span>Manage Groups</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('admin.programs') }}" class="quick-action-btn w-100" style="justify-content: flex-start;">
                                <i class="fas fa-calendar-alt text-success"></i>
                                <span>Programs</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('admin.streams') }}" class="quick-action-btn w-100" style="justify-content: flex-start;">
                                <i class="fas fa-video text-warning"></i>
                                <span>Live Streams</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('admin.radios') }}" class="quick-action-btn w-100" style="justify-content: flex-start;">
                                <i class="fas fa-broadcast-tower text-danger"></i>
                                <span>Radio</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('admin.books.index') }}" class="quick-action-btn w-100" style="justify-content: flex-start;">
                                <i class="fas fa-book text-info"></i>
                                <span>Books</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('admin.page-content.index') }}" class="quick-action-btn w-100" style="justify-content: flex-start;">
                                <i class="fas fa-file-alt text-secondary"></i>
                                <span>Site Content</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
