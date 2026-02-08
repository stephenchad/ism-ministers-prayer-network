@extends('admin.layouts.app')

@section('title', 'Settings')

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
                    <i class="fas fa-cog me-1"></i>
                    Settings
                </li>
            </ol>
        </nav>
    </div>

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Account Settings</h1>
            <p class="page-subtitle">Manage your account preferences and settings</p>
        </div>
    </div>

    <!-- Settings Content -->
    <div class="row fade-in">
        <div class="col-lg-8 mx-auto">
            <!-- Notification Settings -->
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="card-title">Notification Preferences</h5>
                </div>
                <div class="card-body">
                    @if(Session::has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ Session::get('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('account.updateSettings') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="settings-group">
                            <div class="settings-item">
                                <div class="settings-info">
                                    <h6>Email Notifications</h6>
                                    <p class="text-muted mb-0">Receive email notifications for important updates</p>
                                </div>
                                <div class="settings-action">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="email_notifications" name="email_notifications" {{ Auth::user()->email_notifications ? 'checked' : '' }}>
                                        <label class="form-check-label" for="email_notifications"></label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="settings-item">
                                <div class="settings-info">
                                    <h6>Push Notifications</h6>
                                    <p class="text-muted mb-0">Receive push notifications in your browser</p>
                                </div>
                                <div class="settings-action">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="push_notifications" name="push_notifications" {{ Auth::user()->push_notifications ? 'checked' : '' }}>
                                        <label class="form-check-label" for="push_notifications"></label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="settings-item">
                                <div class="settings-info">
                                    <h6>Prayer Request Alerts</h6>
                                    <p class="text-muted mb-0">Get notified when new prayer requests are submitted</p>
                                </div>
                                <div class="settings-action">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="prayer_alerts" name="prayer_alerts" {{ Auth::user()->prayer_alerts ? 'checked' : '' }}>
                                        <label class="form-check-label" for="prayer_alerts"></label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="settings-item">
                                <div class="settings-info">
                                    <h6>Group Updates</h6>
                                    <p class="text-muted mb-0">Receive updates from your groups</p>
                                </div>
                                <div class="settings-action">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="group_updates" name="group_updates" {{ Auth::user()->group_updates ? 'checked' : '' }}>
                                        <label class="form-check-label" for="group_updates"></label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="settings-item">
                                <div class="settings-info">
                                    <h6>Marketing Emails</h6>
                                    <p class="text-muted mb-0">Receive promotional and marketing emails</p>
                                </div>
                                <div class="settings-action">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="marketing_emails" name="marketing_emails" {{ Auth::user()->marketing_emails ? 'checked' : '' }}>
                                        <label class="form-check-label" for="marketing_emails"></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>
                                Save Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Privacy Settings -->
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h5 class="card-title">Privacy Settings</h5>
                </div>
                <div class="card-body">
                    <div class="settings-group">
                        <div class="settings-item">
                            <div class="settings-info">
                                <h6>Profile Visibility</h6>
                                <p class="text-muted mb-0">Control who can see your profile information</p>
                            </div>
                            <div class="settings-action">
                                <select class="form-select" name="profile_visibility" style="width: auto;">
                                    <option value="public" {{ Auth::user()->profile_visibility == 'public' ? 'selected' : '' }}>Public</option>
                                    <option value="members" {{ Auth::user()->profile_visibility == 'members' ? 'selected' : '' }}>Members Only</option>
                                    <option value="private" {{ Auth::user()->profile_visibility == 'private' ? 'selected' : '' }}>Private</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="settings-item">
                            <div class="settings-info">
                                <h6>Show Email Address</h6>
                                <p class="text-muted mb-0">Display your email on your profile</p>
                            </div>
                            <div class="settings-action">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="show_email" name="show_email" {{ Auth::user()->show_email ? 'checked' : '' }}>
                                    <label class="form-check-label" for="show_email"></label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="settings-item">
                            <div class="settings-info">
                                <h6>Show Online Status</h6>
                                <p class="text-muted mb-0">Let others see when you're online</p>
                            </div>
                            <div class="settings-action">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="show_online" name="show_online" {{ Auth::user()->show_online ? 'checked' : '' }}>
                                    <label class="form-check-label" for="show_online"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="admin-card">
                <div class="card-header" style="background: rgba(239, 68, 68, 0.1); border-bottom-color: rgba(239, 68, 68, 0.2);">
                    <h5 class="card-title" style="color: var(--admin-danger);">Danger Zone</h5>
                </div>
                <div class="card-body">
                    <div class="settings-item">
                        <div class="settings-info">
                            <h6>Delete Account</h6>
                            <p class="text-muted mb-0">Permanently delete your account and all data</p>
                        </div>
                        <div class="settings-action">
                            <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                                <i class="fas fa-trash me-1"></i>
                                Delete Account
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function confirmDelete() {
            if (confirm('Are you sure you want to delete your account? This action cannot be undone.')) {
                // Implement account deletion
                alert('Account deletion would be processed here.');
            }
        }
    </script>
    @endpush

    @push('styles')
    <style>
        .settings-group {
            display: flex;
            flex-direction: column;
            gap: 0;
        }
        
        .settings-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 0;
            border-bottom: 1px solid var(--admin-border-color);
        }
        
        .settings-item:last-child {
            border-bottom: none;
        }
        
        .settings-info h6 {
            font-size: 15px;
            font-weight: 600;
            color: var(--admin-text-primary);
            margin: 0 0 4px 0;
        }
        
        .settings-info p {
            font-size: 13px;
        }
        
        .settings-action {
            flex-shrink: 0;
        }
        
        .form-switch .form-check-input {
            width: 3rem;
            height: 1.5rem;
            cursor: pointer;
        }
        
        .form-switch .form-check-input:checked {
            background-color: var(--admin-success);
            border-color: var(--admin-success);
        }
    </style>
    @endpush
@endsection
