<?php $__env->startSection('main'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Manage Testimonies</h1>
        <a href="<?php echo e(route('admin.testimonies.create')); ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add Testimony
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
                            <th>Name</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Location</th>
                            <th>Published</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $testimonies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimony): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($testimony->name); ?></td>
                            <td><?php echo e(Str::limit($testimony->title, 40)); ?></td>
                            <td><?php echo e($testimony->category); ?></td>
                            <td><?php echo e($testimony->location ?: 'N/A'); ?></td>
                            <td>
                                <span class="badge bg-<?php echo e($testimony->allow_publish ? 'success' : 'warning'); ?>">
                                    <?php echo e($testimony->allow_publish ? 'Yes' : 'No'); ?>

                                </span>
                            </td>
                            <td><?php echo e($testimony->created_at->format('M d, Y')); ?></td>
                            <td>
                                <a href="<?php echo e(route('admin.testimonies.edit', $testimony->id)); ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-danger" onclick="deleteTestimony(<?php echo e($testimony->id); ?>)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-heart fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No testimonies found</p>
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
function deleteTestimony(id) {
    if (confirm('Are you sure you want to delete this testimony?')) {
        $.ajax({
            url: '<?php echo e(route("admin.testimonies.destroy")); ?>',
            method: 'DELETE',
            data: { id: id },
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
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/admin/testimonies/index.blade.php ENDPATH**/ ?>