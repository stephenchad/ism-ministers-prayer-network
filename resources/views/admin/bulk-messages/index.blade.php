@extends('admin.layouts.app')

@section('title', 'Bulk Messages')

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
                    <i class="fas fa-envelope me-1"></i>
                    Bulk Messages
                </li>
            </ol>
        </nav>
    </div>

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Bulk Messages</h1>
            <p class="page-subtitle">Send bulk SMS and email messages to users</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('admin.bulk-messages.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>
                Send New Message
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid fade-in">
        <div class="stat-card">
            <div class="stat-icon primary">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-value">{{ $bulkMessages->total() }}</h3>
                <p class="stat-label">Total Messages</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon success">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-value">{{ $bulkMessages->whereNotNull('sent_at')->count() }}</h3>
                <p class="stat-label">Sent</p>
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

    <!-- Bulk Messages Table -->
    <div class="admin-card fade-in">
        <div class="card-header">
            <h5 class="card-title">All Bulk Messages</h5>
        </div>
        <div class="card-body p-0">
            @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin: 20px;">
                    {{ Session::get('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($bulkMessages->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Type</th>
                                <th>Subject</th>
                                <th>Recipients</th>
                                <th>Sent</th>
                                <th>Failed</th>
                                <th>Sent At</th>
                                <th>Sender</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bulkMessages as $message)
                                <tr>
                                    <td>{{ $message->id }}</td>
                                    <td>
                                        <span class="badge bg-{{ $message->type === 'email' ? 'primary' : 'success' }}">
                                            <i class="fas fa-{{ $message->type === 'email' ? 'envelope' : 'sms' }} me-1"></i>
                                            {{ ucfirst($message->type) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($message->subject)
                                            {{ Str::limit($message->subject, 30) }}
                                        @else
                                            <em class="text-muted">N/A</em>
                                        @endif
                                    </td>
                                    <td>{{ $message->total_recipients }}</td>
                                    <td>
                                        <span class="badge bg-success">{{ $message->sent_count }}</span>
                                    </td>
                                    <td>
                                        @if($message->failed_count > 0)
                                            <span class="badge bg-danger">{{ $message->failed_count }}</span>
                                        @else
                                            <span class="badge bg-secondary">0</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($message->sent_at)
                                            {{ $message->sent_at->format('M d, Y H:i') }}
                                        @else
                                            <em class="text-muted">Pending</em>
                                        @endif
                                    </td>
                                    <td>{{ $message->sender->name ?? 'Unknown' }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.bulk-messages.show', $message->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button onclick="deleteMessage({{ $message->id }})" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-envelope fa-4x mb-4 text-muted opacity-50"></i>
                    <h5 class="text-muted">No bulk messages found</h5>
                    <p class="text-muted mb-0">There are currently no bulk messages in the system.</p>
                </div>
            @endif
        </div>
    </div>

    @if($bulkMessages->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $bulkMessages->links() }}
        </div>
    @endif

    @push('scripts')
    <script>
        function deleteMessage(id) {
            if (confirm("Are you sure you want to delete this bulk message?")) {
                $.ajax({
                    url: '{{ route("admin.bulk-messages.destroy", ":id") }}'.replace(':id', id),
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    dataType: 'json',
                    success: function(response) {
                        if(response.status) {
                            location.reload();
                        } else {
                            alert('Error deleting message');
                        }
                    },
                    error: function(xhr) {
                        alert('Error deleting message: ' + (xhr.responseJSON?.message || 'Unknown error'));
                    }
                });
            }
        }
    </script>
    @endpush
@endsection
