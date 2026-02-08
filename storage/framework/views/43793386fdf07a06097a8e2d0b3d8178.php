<?php $__env->startSection('main'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Add Video Resource</h1>
        <a href="<?php echo e(route('admin.video-resources')); ?>" class="btn btn-secondary">Back to Videos</a>
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
            <form action="<?php echo e(route('admin.video-resources.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" id="title" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Video Type</label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="video_type" id="video_url" value="url" checked>
                            <label class="form-check-label" for="video_url">External URL</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="video_type" id="video_file" value="file">
                            <label class="form-check-label" for="video_file">Upload File</label>
                        </div>
                    </div>
                </div>

                <div class="mb-3" id="url_field">
                    <label for="video_url_input" class="form-label">Video URL</label>
                    <input type="url" name="video_url" id="video_url_input" class="form-control" placeholder="https://youtube.com/watch?v=...">
                    <small class="text-muted">YouTube, Vimeo, or any video URL</small>
                </div>

                <div class="mb-3" id="file_field" style="display: none;">
                    <label for="video_file_input" class="form-label">Video File</label>
                    <input type="file" name="video_file" id="video_file_input" class="form-control" accept=".mp4,.avi,.mov,.wmv">
                    <small class="text-muted">Accepted formats: MP4, AVI, MOV, WMV (Max: 100MB)</small>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="duration" class="form-label">Duration</label>
                            <input type="text" name="duration" id="duration" class="form-control" placeholder="e.g., 15 min">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" name="sort_order" id="sort_order" class="form-control" value="0">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" checked>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Create Video Resource</button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const urlRadio = document.getElementById('video_url');
    const fileRadio = document.getElementById('video_file');
    const urlField = document.getElementById('url_field');
    const fileField = document.getElementById('file_field');

    function toggleFields() {
        if (urlRadio.checked) {
            urlField.style.display = 'block';
            fileField.style.display = 'none';
        } else {
            urlField.style.display = 'none';
            fileField.style.display = 'block';
        }
    }

    urlRadio.addEventListener('change', toggleFields);
    fileRadio.addEventListener('change', toggleFields);
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/admin/video-resources/create.blade.php ENDPATH**/ ?>