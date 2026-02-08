<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit News/Event - ISM Prayer Network</title>
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
            <a class="nav-link" href="<?php echo e(route('admin.dashboard')); ?>">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>
            <a class="nav-link" href="<?php echo e(route('admin.users')); ?>">
                <i class="fas fa-users me-2"></i> Users
            </a>
            <a class="nav-link" href="<?php echo e(route('admin.groups')); ?>">
                <i class="fas fa-users-cog me-2"></i> Groups
            </a>
            <a class="nav-link" href="<?php echo e(route('admin.programs')); ?>">
                <i class="fas fa-calendar-alt me-2"></i> Programs
            </a>
            <a class="nav-link active" href="<?php echo e(route('admin.news.index')); ?>">
                <i class="fas fa-newspaper me-2"></i> News & Events
            </a>
            <hr class="border-secondary mx-3">
            <a class="nav-link" href="<?php echo e(route('home')); ?>">
                <i class="fas fa-globe me-2"></i> View Website
            </a>
            <a class="nav-link" href="<?php echo e(route('admin.logout')); ?>">
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
                    <h4 class="mb-0" style="font-weight: 600;">Edit News/Event</h4>
                </div>
                <div class="card-body" style="padding: 40px;">
                    <form action="<?php echo e(route('admin.news.update', $news->id)); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Title</label>
                                    <input type="text" name="title" value="<?php echo e($news->title); ?>" class="form-control" style="border-radius: 15px; padding: 15px;" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Type</label>
                                    <select name="type" class="form-control" style="border-radius: 15px; padding: 15px;" required>
                                        <option value="news" <?php echo e($news->type == 'news' ? 'selected' : ''); ?>>News</option>
                                        <option value="event" <?php echo e($news->type == 'event' ? 'selected' : ''); ?>>Event</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Excerpt</label>
                            <textarea name="excerpt" class="form-control" rows="3" style="border-radius: 15px; padding: 15px;" required><?php echo e($news->excerpt); ?></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Content</label>
                            <textarea name="content" class="form-control" rows="8" style="border-radius: 15px; padding: 15px;" required><?php echo e($news->content); ?></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Image</label>
                            <?php if($news->image): ?>
                                <div class="mb-2">
                                    <img src="<?php echo e(asset('storage/' . $news->image)); ?>" alt="Current Image" style="max-width: 200px; border-radius: 10px;">
                                </div>
                            <?php endif; ?>
                            <input type="file" name="image" class="form-control" style="border-radius: 15px; padding: 15px;" accept="image/*">
                        </div>

                        <div class="row event-fields" style="<?php echo e($news->type == 'event' ? '' : 'display: none;'); ?>">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Event Date & Time</label>
                                    <input type="datetime-local" name="event_date" value="<?php echo e($news->event_date ? $news->event_date->format('Y-m-d\TH:i') : ''); ?>" class="form-control" style="border-radius: 15px; padding: 15px;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Event Location</label>
                                    <input type="text" name="event_location" value="<?php echo e($news->event_location); ?>" class="form-control" style="border-radius: 15px; padding: 15px;">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <div class="form-check">
                                        <input type="checkbox" name="is_featured" value="1" <?php echo e($news->is_featured ? 'checked' : ''); ?> class="form-check-input">
                                        <label class="form-check-label fw-bold">Featured</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <div class="form-check">
                                        <input type="checkbox" name="status" value="1" <?php echo e($news->status ? 'checked' : ''); ?> class="form-check-input">
                                        <label class="form-check-label fw-bold">Active</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="<?php echo e(route('admin.news.index')); ?>" class="btn btn-secondary" style="border-radius: 25px; padding: 12px 30px;">Cancel</a>
                            <button type="submit" class="btn btn-primary" style="border-radius: 25px; padding: 12px 30px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('select[name="type"]').change(function() {
        if ($(this).val() === 'event') {
            $('.event-fields').show();
        } else {
            $('.event-fields').hide();
        }
    });
});
</script>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/admin/news/edit.blade.php ENDPATH**/ ?>