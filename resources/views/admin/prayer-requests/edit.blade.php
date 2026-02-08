@extends('admin.layouts.app')

@section('main')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Prayer Request</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.prayer-requests.index') }}">Prayer Requests</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Edit Prayer Request Details</h3>
                        </div>
                        <form action="{{ route('admin.prayer-requests.update', $prayerRequest->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $prayerRequest->name) }}" required>
                                    @error('name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $prayerRequest->email) }}" required>
                                    @error('email')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="prayer_type">Prayer Type</label>
                                    <input type="text" name="prayer_type" id="prayer_type" class="form-control @error('prayer_type') is-invalid @enderror" value="{{ old('prayer_type', $prayerRequest->prayer_type) }}" required>
                                    @error('prayer_type')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="request">Prayer Request</label>
                                    <textarea name="request" id="request" rows="6" class="form-control @error('request') is-invalid @enderror" required>{{ old('request', $prayerRequest->prayer_request) }}</textarea>
                                    @error('request')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                        <option value="pending" {{ old('status', $prayerRequest->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ old('status', $prayerRequest->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="rejected" {{ old('status', $prayerRequest->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update Prayer Request
                                </button>
                                <a href="{{ route('admin.prayer-requests.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Request Information</h3>
                        </div>
                        <div class="card-body">
                            <p><strong>Submitted:</strong><br>{{ $prayerRequest->created_at->format('M d, Y H:i A') }}</p>
                            <p><strong>Last Updated:</strong><br>{{ $prayerRequest->updated_at->format('M d, Y H:i A') }}</p>
                            <p><strong>Current Status:</strong><br>
                                <span class="badge badge-{{ $prayerRequest->status == 'approved' ? 'success' : ($prayerRequest->status == 'rejected' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($prayerRequest->status) }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-danger">
                            <h3 class="card-title">Danger Zone</h3>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">Once you delete this prayer request, there is no going back.</p>
                            <form action="{{ route('admin.prayer-requests.destroy', $prayerRequest->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this prayer request? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-block">
                                    <i class="fas fa-trash"></i> Delete Prayer Request
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
