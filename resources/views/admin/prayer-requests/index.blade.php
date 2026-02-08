@extends('admin.layouts.app')

@section('main')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Prayer Requests Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Prayer Requests</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{ session('success') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">All Prayer Requests</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Prayer Type</th>
                                <th>Request</th>
                                <th>Status</th>
                                <th>Submitted</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($prayerRequests as $request)
                                <tr>
                                    <td>{{ $request->id }}</td>
                                    <td>{{ $request->name ?: 'Anonymous' }}</td>
                                    <td>{{ $request->email ?: 'N/A' }}</td>
                                    <td>{{ $request->prayer_type }}</td>
                                    <td>{{ Str::limit($request->prayer_request, 50) }}</td>
                                    <td>
                                        <span class="badge badge-{{ $request->status == 'approved' ? 'success' : ($request->status == 'rejected' ? 'danger' : 'warning') }}">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $request->created_at ? $request->created_at->format('M d, Y H:i') : 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('admin.prayer-requests.edit', $request->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        @if($request->status == 'pending')
                                            <form action="{{ route('admin.prayer-requests.approve', $request->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                            </form>
                                            <form action="{{ route('admin.prayer-requests.reject', $request->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                            </form>
                                        @else
                                            <span class="text-muted">{{ ucfirst($request->status) }}</span>
                                        @endif
                                        <form action="{{ route('admin.prayer-requests.destroy', $request->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this prayer request?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-dark btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No prayer requests found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($prayerRequests->hasPages())
                    <div class="card-footer">
                        {{ $prayerRequests->links() }}
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection
