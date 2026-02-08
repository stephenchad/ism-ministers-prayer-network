<?php $__env->startSection('main'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Manage Worship Music</h1>
        <a href="<?php echo e(route('admin.worship-music.create')); ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add Music
        </a>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Artist</th>
                            <th>Type</th>
                            <th>Duration</th>
                            <th>Size</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $music; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($item->title); ?></td>
                            <td><?php echo e($item->artist ?: 'N/A'); ?></td>
                            <td>
                                <span class="badge bg-<?php echo e($item->music_type == 'streaming' ? 'info' : 'success'); ?>">
                                    <?php echo e(ucfirst($item->music_type)); ?>

                                </span>
                            </td>
                            <td><?php echo e($item->duration ?: 'N/A'); ?></td>
                            <td><?php echo e($item->file_size); ?></td>
                            <td>
                                <span class="badge bg-<?php echo e($item->is_active ? 'success' : 'secondary'); ?>">
                                    <?php echo e($item->is_active ? 'Active' : 'Inactive'); ?>

                                </span>
                            </td>
                            <td>
                                <a href="<?php echo e(route('admin.worship-music.edit', $item->id)); ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-danger" onclick="deleteMusic(<?php echo e($item->id); ?>)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-music fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No worship music found</p>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function deleteMusic(id) {
    if (confirm('Are you sure you want to delete this music?')) {
        $.ajax({
            url: '<?php echo e(route("admin.worship-music.destroy")); ?>',
            method: 'DELETE',
            data: { 
                id: id,
                _token: '<?php echo e(csrf_token()); ?>'
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                }
            }
        });
    }
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/admin/worship-music/index.blade.php ENDPATH**/ ?>