<?php $__env->startSection('main'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Prayer Resources</h1>
        <a href="<?php echo e(route('admin.prayer-resources.create')); ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add Resource
        </a>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
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
                            <th>Description</th>
                            <th>File Type</th>
                            <th>File Size</th>
                            <th>Status</th>
                            <th>Sort Order</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $resources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $resource): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($resource->title); ?></td>
                            <td><?php echo e(Str::limit($resource->description, 50)); ?></td>
                            <td>
                                <span class="badge bg-info"><?php echo e(strtoupper($resource->file_type)); ?></span>
                            </td>
                            <td><?php echo e($resource->file_size); ?></td>
                            <td>
                                <?php if($resource->is_active): ?>
                                    <span class="badge bg-success">Active</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($resource->sort_order); ?></td>
                            <td>
                                <a href="<?php echo e(route('admin.prayer-resources.edit', $resource->id)); ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-danger" onclick="deleteResource(<?php echo e($resource->id); ?>)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <p class="text-muted mb-0">No prayer resources found</p>
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
function deleteResource(id) {
    if (confirm('Are you sure you want to delete this resource?')) {
        $.ajax({
            url: '<?php echo e(route("admin.prayer-resources.destroy")); ?>',
            type: 'DELETE',
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
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/admin/prayer-resources/index.blade.php ENDPATH**/ ?>