<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Program - ISM Prayer Network</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
    </style>
</head>
<body>
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
            <a class="nav-link" href="{{ route('admin.users') }}">
                <i class="fas fa-users me-2"></i> Users
            </a>
            <a class="nav-link" href="{{ route('admin.groups') }}">
                <i class="fas fa-users-cog me-2"></i> Groups
            </a>
            <a class="nav-link active" href="{{ route('admin.programs') }}">
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
    <div class="main-content">
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">
                <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 25px 30px; border: none;">
                    <h4 class="mb-0" style="font-weight: 600;">Create Program</h4>
                </div>
                <div class="card-body" style="padding: 40px;">
                    <form action="{{ route('admin.programs.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Title</label>
                            <input type="text" name="title" class="form-control" style="border-radius: 15px; padding: 15px;" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Description</label>
                            <textarea name="description" class="form-control" rows="3" style="border-radius: 15px; padding: 15px;" required></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Details</label>
                            <textarea name="details" class="form-control" rows="5" style="border-radius: 15px; padding: 15px;" required></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Schedule</label>
                                    <input type="text" name="schedule" class="form-control" style="border-radius: 15px; padding: 15px;" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Location</label>
                                    <input type="text" name="location" class="form-control" style="border-radius: 15px; padding: 15px;" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Icon</label>
                                    <input type="text" name="icon" class="form-control" style="border-radius: 15px; padding: 15px;" placeholder="fas fa-praying-hands" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Color</label>
                                    <input type="color" name="color" class="form-control" style="border-radius: 15px; padding: 15px;" value="#667eea" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Image</label>
                            <input type="file" name="image" class="form-control" style="border-radius: 15px; padding: 15px;" accept="image/*">
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input type="checkbox" name="status" value="1" class="form-check-input" checked>
                                <label class="form-check-label fw-bold">Active</label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.programs') }}" class="btn btn-secondary" style="border-radius: 25px; padding: 12px 30px;">Cancel</a>
                            <button type="submit" class="btn btn-primary" style="border-radius: 25px; padding: 12px 30px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>