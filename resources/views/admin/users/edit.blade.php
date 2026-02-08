<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - ISM Prayer Network</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
        }
        .sidebar {
            background: linear-gradient(180deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 280px;
            z-index: 1000;
            box-shadow: 4px 0 20px rgba(0,0,0,0.1);
        }
        .main-content {
            margin-left: 280px;
            padding: 30px;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.7);
            padding: 18px 25px;
            border-radius: 12px;
            margin: 5px 15px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            transform: translateX(5px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }
        .content-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9ff 100%);
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            border: none;
        }
        .topbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            backdrop-filter: blur(20px);
            box-shadow: 0 15px 50px rgba(102, 126, 234, 0.3);
            padding: 30px;
            margin-bottom: 40px;
            border-radius: 25px;
            position: relative;
            overflow: hidden;
        }
        .topbar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="%23ffffff" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }
        .topbar-content {
            position: relative;
            z-index: 1;
        }
        .topbar-icon {
            background: rgba(255,255,255,0.2);
            border-radius: 15px;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
        }
        .form-control {
            border-radius: 12px;
            border: 2px solid #e9ecef;
            padding: 12px 16px;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn {
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="p-4 text-center" style="border-bottom: 1px solid rgba(255,255,255,0.1);">
            <div class="mb-3">
                <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                    <i class="fas fa-praying-hands text-primary" style="font-size: 24px;"></i>
                </div>
            </div>
            <h5 class="text-white mb-1 fw-bold">ISM Admin</h5>
            <small class="text-light opacity-75">Prayer Network</small>
        </div>
        <nav class="nav flex-column mt-3">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>
            <a class="nav-link active" href="{{ route('admin.users') }}">
                <i class="fas fa-users me-2"></i> Users
            </a>
            <a class="nav-link" href="{{ route('admin.groups') }}">
                <i class="fas fa-users-cog me-2"></i> Groups
            </a>
            <a class="nav-link" href="{{ route('admin.programs') }}">
                <i class="fas fa-calendar-alt me-2"></i> Programs
            </a>
            <a class="nav-link" href="{{ route('admin.news.index') }}">
                <i class="fas fa-newspaper me-2"></i> News & Events
            </a>
            <hr class="border-secondary mx-3">
            <a class="nav-link" href="{{ route('home') }}">
                <i class="fas fa-globe me-2"></i> View Website
            </a>
            <a class="nav-link" href="{{ route('admin.logout') }}">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="topbar">
            <div class="topbar-content">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="topbar-icon me-4">
                            <i class="fas fa-user-edit text-white" style="font-size: 24px;"></i>
                        </div>
                        <div>
                            <h3 class="mb-1 text-white fw-bold">Edit User</h3>
                            <p class="mb-0 text-white opacity-75">Update user information and settings</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <a href="{{ route('admin.users') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>Back to Users
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="content-card p-4">
            @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ Session::get('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            <form id="userForm" name="userForm" method="POST" action="">
                @csrf
                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-bold">Name</label>
                        <input type="text" name="name" id="name" value="{{ $user->name }}" class="form-control" placeholder="Enter full name">
                        <p class="text-danger mt-1"></p>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label fw-bold">Email</label>
                        <input type="email" name="email" id="email" value="{{ $user->email }}" class="form-control" placeholder="Enter email address">
                        <p class="text-danger mt-1"></p>
                    </div>
                    <div class="col-md-6">
                        <label for="designation" class="form-label fw-bold">Designation</label>
                        <input type="text" name="designation" id="designation" value="{{ $user->designation }}" class="form-control" placeholder="Enter designation">
                        <p class="text-danger mt-1"></p>
                    </div>
                    <div class="col-md-6">
                        <label for="mobile" class="form-label fw-bold">Mobile</label>
                        <input type="tel" name="mobile" id="mobile" value="{{ $user->mobile }}" class="form-control" placeholder="Enter phone number">
                        <p class="text-danger mt-1"></p>
                    </div>
                    <div class="col-md-6">
                        <label for="role" class="form-label fw-bold">Role</label>
                        <select name="role" id="role" class="form-control">
                            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        <p class="text-danger mt-1"></p>
                    </div>
                    <div class="col-12">
                        <div class="d-flex gap-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update User
                            </button>
                            <a href="{{ route('admin.users') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $("#userForm").submit(function(e){
            e.preventDefault();
            
            $.ajax({
                url: '{{ route("admin.users.update", $user->id) }}',
                type: 'PUT',
                dataType: 'json',
                data: $("#userForm").serializeArray(),
                success: function(response) {
                    if(response.status == true) {
                        $(".form-control").removeClass('is-invalid');
                        $("p").html('');
                        window.location.href="{{ route('admin.users') }}";
                    } else {
                        var errors = response.errors;
                        $(".form-control").removeClass('is-invalid');
                        $("p").html('');
                        
                        $.each(errors, function(key, value) {
                            $("#" + key).addClass('is-invalid').siblings('p').html(value);
                        });
                    }
                }
            });
        });
    </script>
</body>
</html>