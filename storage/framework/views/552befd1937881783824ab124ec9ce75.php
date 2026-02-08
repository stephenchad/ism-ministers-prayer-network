<?php $__env->startSection('main'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Edit Worship Music</h1>
        <a href="<?php echo e(route('admin.worship-music')); ?>" class="btn btn-secondary">Back to Music</a>
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
            <form action="<?php echo e(route('admin.worship-music.update', $music->id)); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" id="title" class="form-control" value="<?php echo e($music->title); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="artist" class="form-label">Artist</label>
                            <input type="text" name="artist" id="artist" class="form-control" value="<?php echo e($music->artist); ?>">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="3"><?php echo e($music->description); ?></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Music Type</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="music_type" id="streaming" value="streaming" <?php echo e($music->music_type == 'streaming' ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="streaming">Streaming</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="music_type" id="download" value="download" <?php echo e($music->music_type == 'download' ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="download">Download</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="duration" class="form-label">Duration</label>
                            <input type="text" name="duration" id="duration" class="form-control" placeholder="e.g., 3:45" value="<?php echo e($music->duration); ?>">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="file" class="form-label">Music File</label>
                    <?php if($music->file_path): ?>
                        <div class="mb-2">
                            <strong>Current file:</strong> <?php echo e(basename($music->file_path)); ?> (<?php echo e($music->file_size); ?>)
                        </div>
                    <?php endif; ?>
                    <input type="file" name="file" id="file" class="form-control" accept=".mp3,.wav,.m4a">
                    <small class="text-muted">Accepted formats: MP3, WAV, M4A (Max: 50MB). Leave empty to keep current file.</small>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" name="sort_order" id="sort_order" class="form-control" value="<?php echo e($music->sort_order); ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" <?php echo e($music->is_active ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update Music</button>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/admin/worship-music/edit.blade.php ENDPATH**/ ?>