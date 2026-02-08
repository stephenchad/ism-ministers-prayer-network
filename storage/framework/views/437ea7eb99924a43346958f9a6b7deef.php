

<?php $__env->startSection('main'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Manage Prayer Points</h3>
                    <a href="<?php echo e(route('admin.prayer-points.create')); ?>" class="btn btn-primary float-right">Create Prayer Point</a>
                </div>
                <div class="card-body">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success">
                            <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Content</th>
                                <th>Status</th>
                                <th>User</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $prayerPoints; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $point): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($point->title); ?></td>
                                    <td><?php echo e(Str::limit($point->content, 50)); ?></td>
                                    <td>
                                        <span class="badge badge-<?php echo e($point->status == 'approved' ? 'success' : ($point->status == 'rejected' ? 'danger' : 'warning')); ?>">
                                            <?php echo e(ucfirst($point->status)); ?>

                                        </span>
                                    </td>
                                    <td><?php echo e($point->user ? $point->user->name : 'Anonymous'); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('admin.prayer-points.edit', $point->id)); ?>" class="btn btn-info btn-sm">Edit</a>
                                        <?php if($point->status != 'approved'): ?>
                                            <a href="<?php echo e(route('admin.prayer-points.approve', $point->id)); ?>" class="btn btn-success btn-sm">Approve</a>
                                        <?php endif; ?>
                                        <?php if($point->status != 'rejected'): ?>
                                            <a href="<?php echo e(route('admin.prayer-points.reject', $point->id)); ?>" class="btn btn-warning btn-sm">Reject</a>
                                        <?php endif; ?>
                                        <form action="<?php echo e(route('admin.prayer-points.destroy', $point->id)); ?>" method="POST" style="display: inline;">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <?php echo e($prayerPoints->links()); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/admin/prayer-points/index.blade.php ENDPATH**/ ?>