@extends('admin.layouts.app')

@section('title', 'View Notification')

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
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.notifications.index') }}">
                        <i class="fas fa-bell me-1"></i>
                        Notifications
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fas fa-eye me-1"></i>
                    View
                </li>
            </ol>
        </nav>
    </div>

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Notification Details</h1>
            <p class="page-subtitle">View detailed information about this notification</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i>
                Back
            </a>
        </div>
    </div>

    <!-- Notification Details -->
    <div class="admin-card fade-in">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title">{{ class_basename($notification->type) }}</h5>
                <div class="d-flex gap-2">
                    @if(!$notification->read_at)
                        <span class="badge bg-success">Unread</span>
                    @else
                        <span class="badge bg-secondary">Read</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-body">
            @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ Session::get('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="notification-detail-card {{ $notification->read_at ? '' : 'unread' }}">
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3">Message</h5>
                            <p class="fs-5">{{ $notification->data['message'] ?? 'No message content' }}</p>
                        </div>

                        @if(isset($notification->data['url']))
                            <div class="mb-4">
                                <h5 class="fw-bold mb-3">Related Link</h5>
                                <a href="{{ $notification->data['url'] }}" target="_blank" class="btn btn-outline-primary">
                                    <i class="fas fa-external-link-alt me-2"></i>View Related Content
                                </a>
                            </div>
                        @endif

                        <div class="mb-4">
                            <h5 class="fw-bold mb-3">Raw Data</h5>
                            <div class="data-json">{{ json_encode($notification->data, JSON_PRETTY_PRINT) }}</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="info-card">
                            <div class="info-card-header">
                                <i class="fas fa-info-circle me-2"></i>Notification Info
                            </div>
                            <div class="info-card-body">
                                <div class="info-item">
                                    <strong>ID:</strong>
                                    <span>{{ $notification->id }}</span>
                                </div>
                                <div class="info-item">
                                    <strong>Type:</strong>
                                    <span>{{ $notification->type }}</span>
                                </div>
                                <div class="info-item">
                                    <strong>Recipient:</strong>
                                    <span>
                                        @if($notification->notifiable)
                                            {{ $notification->notifiable->name }} (ID: {{ $notification->notifiable->id }})
                                        @else
                                            Unknown User
                                        @endif
                                    </span>
                                </div>
                                <div class="info-item">
                                    <strong>Created:</strong>
                                    <span>{{ $notification->created_at->format('M d, Y H:i:s') }}</span>
                                </div>
                                <div class="info-item">
                                    <strong>Read At:</strong>
                                    <span>
                                        @if($notification->read_at)
                                            {{ $notification->read_at->format('M d, Y H:i:s') }}
                                        @else
                                            Not read yet
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>

                        @if($notification->notifiable)
                            <div class="info-card mt-3">
                                <div class="info-card-header">
                                    <i class="fas fa-user me-2"></i>Recipient Details
                                </div>
                                <div class="info-card-body">
                                    <div class="text-center mb-3">
                                        <div class="user-avatar-lg mx-auto">
                                            {{ substr($notification->notifiable->name, 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <strong>Name:</strong>
                                        <span>{{ $notification->notifiable->name }}</span>
                                    </div>
                                    <div class="info-item">
                                        <strong>Email:</strong>
                                        <span>{{ $notification->notifiable->email }}</span>
                                    </div>
                                    <div class="info-item">
                                        <strong>Role:</strong>
                                        <span>{{ ucfirst($notification->notifiable->role) }}</span>
                                    </div>
                                    <div class="text-center mt-3">
                                        <a href="{{ route('admin.users.edit', $notification->notifiable->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye me-1"></i>View User
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="d-flex gap-2 mt-3">
                            @if($notification->read_at)
                                <form method="POST" action="{{ route('admin.notifications.markAsUnread', $notification->id) }}" style="flex: 1;">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-outline-warning w-100">
                                        <i class="fas fa-envelope me-1"></i>Mark Unread
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('admin.notifications.markAsRead', $notification->id) }}" style="flex: 1;">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-outline-success w-100">
                                        <i class="fas fa-check me-1"></i>Mark Read
                                    </button>
                                </form>
                            @endif
                            <form method="POST" action="{{ route('admin.notifications.destroy', $notification->id) }}" onsubmit="return confirm('Are you sure you want to delete this notification?')" style="flex: 1;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger w-100">
                                    <i class="fas fa-trash me-1"></i>Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .notification-detail-card {
            background: var(--admin-bg-light);
            border-radius: var(--admin-border-radius);
            padding: 24px;
            border-left: 4px solid var(--admin-primary);
        }
        
        .notification-detail-card.unread {
            border-left-color: var(--admin-success);
            background: rgba(16, 185, 129, 0.05);
        }
        
        .data-json {
            background: var(--admin-bg-card);
            border: 1px solid var(--admin-border-color);
            border-radius: var(--admin-border-radius-sm);
            padding: 16px;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            white-space: pre-wrap;
            word-wrap: break-word;
            overflow-x: auto;
        }
        
        .info-card {
            background: var(--admin-bg-card);
            border: 1px solid var(--admin-border-color);
            border-radius: var(--admin-border-radius);
            overflow: hidden;
        }
        
        .info-card-header {
            padding: 12px 16px;
            background: var(--admin-bg-light);
            border-bottom: 1px solid var(--admin-border-color);
            font-weight: 600;
            font-size: 14px;
            color: var(--admin-text-primary);
        }
        
        .info-card-body {
            padding: 16px;
        }
        
        .info-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid var(--admin-border-color);
            font-size: 14px;
        }
        
        .info-item:last-child {
            border-bottom: none;
        }
        
        .info-item strong {
            color: var(--admin-text-secondary);
            font-weight: 500;
        }
        
        .info-item span {
            color: var(--admin-text-primary);
            text-align: right;
            max-width: 60%;
            word-break: break-word;
        }
        
        .user-avatar-lg {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--admin-primary), var(--admin-secondary));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 24px;
        }
    </style>
    @endpush
@endsection
