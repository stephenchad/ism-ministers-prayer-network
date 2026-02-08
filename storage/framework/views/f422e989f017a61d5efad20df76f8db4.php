<?php $__env->startSection('main'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Edit Prayer Resource</h1>
        <a href="<?php echo e(route('admin.prayer-resources')); ?>" class="btn btn-secondary">Back to Resources</a>
    </div>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show mb-4">
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show mb-4">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger mb-4">
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <form action="<?php echo e(route('admin.prayer-resources.update', $resource->id)); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" id="title" class="form-control" value="<?php echo e($resource->title); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="3" required><?php echo e($resource->description); ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Resource Type</label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="resource_type" id="type_file" value="file" <?php echo e($resource->resource_type === 'file' ? 'checked' : ''); ?> disabled>
                            <label class="form-check-label" for="type_file">File Download</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="resource_type" id="type_video" value="video" <?php echo e($resource->resource_type === 'video' ? 'checked' : ''); ?> disabled>
                            <label class="form-check-label" for="type_video">Video Resource</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="resource_type" id="type_guide" value="guide" <?php echo e($resource->resource_type === 'guide' ? 'checked' : ''); ?> disabled>
                            <label class="form-check-label" for="type_guide">Prayer Guide</label>
                        </div>
                        <input type="hidden" name="resource_type" value="<?php echo e($resource->resource_type); ?>">
                    </div>
                </div>

                <?php if($resource->resource_type === 'file'): ?>
                <div class="mb-3" id="file_section">
                    <label for="file" class="form-label">File</label>
                    <input type="file" name="file" id="file" class="form-control" accept=".pdf,.doc,.docx">
                    <small class="text-muted">Leave empty to keep current file. Accepted formats: PDF, DOC, DOCX (Max: 10MB)</small>
                    <?php if($resource->file_path): ?>
                        <div class="mt-2">
                            <small class="text-info">Current file: <?php echo e(basename($resource->file_path)); ?> (<?php echo e($resource->file_size); ?>)</small>
                        </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <?php if($resource->resource_type === 'video'): ?>
                <div id="video_section">
                    <div class="mb-3">
                        <label for="video_url" class="form-label">Video URL</label>
                        <input type="url" name="video_url" id="video_url" class="form-control" value="<?php echo e($resource->video_url); ?>" placeholder="https://youtube.com/watch?v=...">
                        <small class="text-muted">YouTube, Vimeo, or any video URL</small>
                    </div>
                    <div class="mb-3">
                        <label for="video_file" class="form-label">Or Upload New Video File</label>
                        <input type="file" name="video_file" id="video_file" class="form-control" accept=".mp4,.avi,.mov,.wmv">
                        <small class="text-muted">Leave empty to keep current file. Accepted formats: MP4, AVI, MOV, WMV (Max: 100MB)</small>
                        <?php if($resource->video_file): ?>
                            <div class="mt-2">
                                <small class="text-info">Current file: <?php echo e(basename($resource->video_file)); ?></small>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="duration" class="form-label">Duration</label>
                        <input type="text" name="duration" id="duration" class="form-control" value="<?php echo e($resource->duration); ?>" placeholder="e.g., 15 min">
                    </div>
                </div>
                <?php endif; ?>

                <?php if($resource->resource_type === 'guide'): ?>
                <div id="guide_section">
                    <div class="mb-3">
                        <label for="guide_content" class="form-label">Guide Content</label>
                        <textarea name="guide_content" id="guide_content" class="form-control" rows="10"><?php echo e($resource->guide_content); ?></textarea>
                        <small class="text-muted">Use the formatting toolbar to style your content</small>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="reading_time" class="form-label">Reading Time</label>
                                <input type="text" name="reading_time" id="reading_time" class="form-control" value="<?php echo e($resource->reading_time); ?>" placeholder="e.g., 5 min">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="icon" class="form-label">Icon (FontAwesome)</label>
                                <input type="text" name="icon" id="icon" class="form-control" value="<?php echo e($resource->icon); ?>" placeholder="e.g., fa-heart">
                                <small class="text-muted">FontAwesome icon class without 'fas'</small>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" name="sort_order" id="sort_order" class="form-control" value="<?php echo e($resource->sort_order); ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" <?php echo e($resource->is_active ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update Resource</button>
            </form>
        </div>
    </div>
</div>

<?php if($resource->resource_type === 'guide'): ?>
<!-- Summernote CSS and JS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Summernote for guide content
    $('#guide_content').summernote({
        height: 400,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });
});
</script>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/admin/prayer-resources/edit.blade.php ENDPATH**/ ?>