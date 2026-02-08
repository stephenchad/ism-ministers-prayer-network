<?php $__env->startSection('main'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 style="color: #333; font-weight: 700;">Manage Coordinators</h2>
        <a href="<?php echo e(route('admin.coordinators.create')); ?>" class="btn" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 12px 25px; border-radius: 8px; font-weight: 600;">
            <i class="fas fa-plus me-2"></i>Add New Coordinator
        </a>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <?php $__empty_1 = true; $__currentLoopData = $coordinators; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coordinator): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card" style="border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); overflow: hidden;">
                <?php if($coordinator->image): ?>
                    <img src="<?php echo e(asset($coordinator->image)); ?>" class="card-img-top" style="height: 200px; object-fit: cover;" alt="<?php echo e($coordinator->name); ?>">
                <?php else: ?>
                    <div style="height: 200px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem; font-weight: 700;">
                        <?php echo e(strtoupper(substr($coordinator->name, 0, 2))); ?>

                    </div>
                <?php endif; ?>
                
                <div class="card-body" style="padding: 25px;">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="card-title" style="color: #333; font-weight: 700; margin-bottom: 5px;"><?php echo e($coordinator->name); ?></h5>
                            <p class="text-muted" style="font-size: 0.9rem; margin-bottom: 0;"><?php echo e($coordinator->title); ?></p>
                        </div>
                        <span class="badge <?php echo e($coordinator->is_active ? 'bg-success' : 'bg-secondary'); ?>">
                            <?php echo e($coordinator->is_active ? 'Active' : 'Inactive'); ?>

                        </span>
                    </div>
                    
                    <p class="card-text" style="color: #6c757d; font-size: 0.9rem; margin-bottom: 15px;"><?php echo e(Str::limit($coordinator->description, 100)); ?></p>
                    
                    <div class="mb-3">
                        <small class="text-muted d-block"><i class="fas fa-phone me-2"></i><?php echo e($coordinator->phone); ?></small>
                        <small class="text-muted d-block"><i class="fas fa-envelope me-2"></i><?php echo e($coordinator->email); ?></small>
                        <small class="text-muted d-block"><i class="fas fa-clock me-2"></i><?php echo e($coordinator->availability); ?></small>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <a href="<?php echo e(route('admin.coordinators.edit', $coordinator->id)); ?>" class="btn btn-outline-primary btn-sm flex-fill">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <button class="btn btn-outline-danger btn-sm flex-fill delete-coordinator" data-id="<?php echo e($coordinator->id); ?>" data-name="<?php echo e($coordinator->name); ?>">
                            <i class="fas fa-trash me-1"></i>Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-users" style="font-size: 4rem; color: #dee2e6; margin-bottom: 20px;"></i>
                <h4 style="color: #6c757d;">No coordinators found</h4>
                <p style="color: #adb5bd;">Start by adding your first coordinator</p>
                <a href="<?php echo e(route('admin.coordinators.create')); ?>" class="btn" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 12px 25px; border-radius: 8px; font-weight: 600;">
                    <i class="fas fa-plus me-2"></i>Add First Coordinator
                </a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.delete-coordinator').on('click', function() {
        const coordinatorId = $(this).data('id');
        const coordinatorName = $(this).data('name');
        
        if (confirm(`Are you sure you want to delete ${coordinatorName}?`)) {
            $.ajax({
                url: '<?php echo e(route("admin.coordinators.destroy")); ?>',
                method: 'DELETE',
                data: { id: coordinatorId },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    }
                },
                error: function() {
                    alert('Error deleting coordinator');
                }
            });
        }
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/admin/coordinators/index.blade.php ENDPATH**/ ?>