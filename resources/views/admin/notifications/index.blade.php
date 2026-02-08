@extends('admin.layouts.app')

@section('title', 'Notifications')

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
                    <i class="fas fa-bell me-1"></i>
                    Notifications
                </li>
            </ol>
        </nav>
    </div>

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Notification Management</h1>
            <p class="page-subtitle">Monitor and manage all system notifications.</p>
        </div>
        <div class="page-actions">
            <form method="POST" action="{{ route('admin.notifications.clearAll') }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to clear all notifications?')">
                    <i class="fas fa-trash-alt me-1"></i>
                    Clear All
                </button>
            </form>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid fade-in">
        <div class="stat-card">
            <div class="stat-icon primary">
                <i class="fas fa-bell"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-value">{{ $stats['total'] }}</h3>
                <p class="stat-label">Total Notifications</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon success">
                <i class="fas fa-envelope-open"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-value">{{ $stats['read'] }}</h3>
                <p class="stat-label">Read</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon warning">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-value">{{ $stats['unread'] }}</h3>
                <p class="stat-label">Unread</p>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="admin-card mb-4 fade-in" style="animation-delay: 0.1s;">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.notifications.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Notification Type</label>
                    <select name="type" class="form-select">
                        <option value="">All Types</option>
                        @foreach($notificationTypes as $type)
                            <option value="{{ $type['value'] }}" {{ request('type') == $type['value'] ? 'selected' : '' }}>
                                {{ $type['label'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Read</option>
                        <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>Unread</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">User ID</label>
                    <input type="text" name="user_id" value="{{ is_string(request('user_id')) ? request('user_id') : '' }}" class="form-control" placeholder="Enter User ID">
                </div>
                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1">
                        <i class="fas fa-filter me-1"></i>Filter
                    </button>
                    <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bulk Actions -->
    <div class="admin-card mb-4 fade-in" style="animation-delay: 0.15s;">
        <div class="card-body py-3">
            <form id="bulkActionForm" method="POST" style="display: inline;">
                @csrf
                <div class="d-flex flex-wrap gap-2 align-items-center">
                    <button type="submit" formaction="{{ route('admin.notifications.markMultipleAsRead') }}" class="btn btn-success btn-sm" onclick="return confirmBulkAction('mark as read')">
                        <i class="fas fa-check me-1"></i>Mark Selected as Read
                    </button>
                    <button type="submit" formaction="{{ route('admin.notifications.destroyMultiple') }}" class="btn btn-danger btn-sm" onclick="return confirmBulkAction('delete')">
                        <i class="fas fa-trash me-1"></i>Delete Selected
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Notifications List -->
    <div class="admin-card fade-in" style="animation-delay: 0.2s;">
        @if(Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                {{ Session::get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card-body p-0">
            @if($notifications->isNotEmpty())
                <form id="notificationsForm">
                    <div class="p-3 border-bottom" style="border-color: var(--admin-border-color);">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="selectAll">
                            <label class="form-check-label fw-semibold" for="selectAll">
                                Select All Notifications
                            </label>
                        </div>
                    </div>

                    @foreach($notifications as $notification)
                        <div class="notification-item {{ $notification->read_at ? '' : 'unread' }}" style="padding: 16px 20px; border-bottom: 1px solid var(--admin-border-color);">
                            <div class="d-flex align-items-start gap-3">
                                <div class="form-check mt-1">
                                    <input class="form-check-input notification-checkbox" type="checkbox" name="notification_ids[]" value="{{ $notification->id }}">
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1 fw-semibold">
                                                {{ class_basename($notification->type) }}
                                                @if(!$notification->read_at)
                                                    <span class="badge badge-success ms-2">New</span>
                                                @endif
                                            </h6>
                                            <p class="mb-1 text-secondary">{{ $notification->data['message'] ?? 'No message' }}</p>
                                            <small class="text-muted">
                                                <i class="fas fa-user me-1"></i>{{ $notification->notifiable->name ?? 'Unknown User' }}
                                                <span class="mx-2">•</span>
                                                <i class="fas fa-clock me-1"></i>{{ $notification->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.notifications.show', $notification->id) }}" class="btn btn-sm btn-secondary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($notification->read_at)
                                                <form method="POST" action="{{ route('admin.notifications.markAsUnread', $notification->id) }}" style="display: inline;">
                                                    @csrf
                                                    @method('POST')
                                                    <button type="submit" class="btn btn-sm btn-outline-warning">
                                                        <i class="fas fa-envelope"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('admin.notifications.markAsRead', $notification->id) }}" style="display: inline;">
                                                    @csrf
                                                    @method('POST')
                                                    <button type="submit" class="btn btn-sm btn-outline-success">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <form method="POST" action="{{ route('admin.notifications.destroy', $notification->id) }}" style="display: inline;" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </form>

                <div class="p-3 border-top" style="border-color: var(--admin-border-color);">
                    {{ $notifications->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-bell-slash fa-3x mb-3 text-muted opacity-50"></i>
                    <h5 class="text-muted">No notifications found</h5>
                    <p class="text-muted mb-0">There are currently no notifications in the system.</p>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        // Select all checkboxes functionality
        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.notification-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        function confirmBulkAction(action) {
            const checkedBoxes = document.querySelectorAll('.notification-checkbox:checked');
            if (checkedBoxes.length === 0) {
                alert('Please select at least one notification.');
                return false;
            }
            return confirm(`Are you sure you want to ${action} the selected notifications?`);
        }

        // Add notification_ids to bulk action form
        document.getElementById('bulkActionForm').addEventListener('submit', function() {
            const checkedBoxes = document.querySelectorAll('.notification-checkbox:checked');
            const form = document.getElementById('notificationsForm');

            // Clone checked inputs to the bulk form
            checkedBoxes.forEach(checkbox => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'notification_ids[]';
                input.value = checkbox.value;
                this.appendChild(input);
            });
        });
    </script>
    @endpush
@endsection
