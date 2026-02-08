@extends('admin.layouts.app')

@section('main')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Manage Prayer Points</h3>
                    <a href="{{ route('admin.prayer-points.create') }}" class="btn btn-primary float-right">Create Prayer Point</a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Content</th>
                                <th>Status</th>
                                <th>User</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($prayerPoints as $point)
                                <tr>
                                    <td>{{ $point->title }}</td>
                                    <td>{{ Str::limit($point->content, 50) }}</td>
                                    <td>
                                        <span class="badge badge-{{ $point->status == 'approved' ? 'success' : ($point->status == 'rejected' ? 'danger' : 'warning') }}">
                                            {{ ucfirst($point->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $point->user ? $point->user->name : 'Anonymous' }}</td>
                                    <td>
                                        <a href="{{ route('admin.prayer-points.edit', $point->id) }}" class="btn btn-info btn-sm">Edit</a>
                                        @if($point->status != 'approved')
                                            <a href="{{ route('admin.prayer-points.approve', $point->id) }}" class="btn btn-success btn-sm">Approve</a>
                                        @endif
                                        @if($point->status != 'rejected')
                                            <a href="{{ route('admin.prayer-points.reject', $point->id) }}" class="btn btn-warning btn-sm">Reject</a>
                                        @endif
                                        <form action="{{ route('admin.prayer-points.destroy', $point->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $prayerPoints->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
