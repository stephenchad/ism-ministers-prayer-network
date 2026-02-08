@extends('admin.layouts.app')

@section('title', 'My Profile')

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
                    <i class="fas fa-user me-1"></i>
                    My Profile
                </li>
            </ol>
        </nav>
    </div>

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">My Profile</h1>
            <p class="page-subtitle">Manage your account information</p>
        </div>
    </div>

    <!-- Profile Content -->
    <div class="row fade-in">
        <div class="col-lg-4 mb-4">
            <div class="admin-card">
                <div class="card-body text-center">
                    <div class="profile-avatar-lg mx-auto mb-3">
                        {{ substr(Auth::user()->name, 0, 1) }}{{ substr(explode(' ', Auth::user()->name)[1] ?? '', 0, 1) }}
                    </div>
                    <h5 class="mb-1">{{ Auth::user()->name }}</h5>
                    <p class="text-muted mb-3">{{ Auth::user()->email }}</p>
                    <span class="badge bg-primary">{{ ucfirst(Auth::user()->role) }}</span>
                </div>
            </div>
        </div>
        <div class="col-lg-8 mb-4">
            <div class="admin-card">
                <div class="card-header">
                    <h5 class="card-title">Profile Information</h5>
                </div>
                <div class="card-body">
                    @if(Session::has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ Session::get('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('account.updateProfile') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="designation" class="form-label">Designation</label>
                                <input type="text" class="form-control" id="designation" name="designation" value="{{ Auth::user()->designation }}">
                            </div>
                            <div class="col-md-6">
                                <label for="mobile" class="form-label">Mobile Number</label>
                                <input type="text" class="form-control" id="mobile" name="mobile" value="{{ Auth::user()->mobile }}">
                            </div>
                            <div class="col-md-6">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ Auth::user()->last_name }}">
                            </div>
                            <div class="col-md-6">
                                <label for="birthday" class="form-label">Birthday</label>
                                <input type="date" class="form-control" id="birthday" name="birthday" value="{{ Auth::user()->birthday }}">
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="admin-card mt-4">
                <div class="card-header">
                    <h5 class="card-title">Referral Information</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Referral Code</label>
                            <div class="input-group">
                                <input type="text" class="form-control" value="{{ Auth::user()->referral_code }}" readonly>
                                <button class="btn btn-outline-secondary" type="button" onclick="copyReferralCode()">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Referred By</label>
                            <input type="text" class="form-control" value="{{ Auth::user()->referrer ? Auth::user()->referrer->name : 'None' }}" readonly>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Total Referrals</label>
                            <input type="text" class="form-control" value="{{ Auth::user()->referrals->count() }} users" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function copyReferralCode() {
            navigator.clipboard.writeText('{{ Auth::user()->referral_code }}');
            alert('Referral code copied to clipboard!');
        }
    </script>
    @endpush
@endsection
