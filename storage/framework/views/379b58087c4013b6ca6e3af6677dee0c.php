

<?php $__env->startSection('main'); ?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Prayer Requests Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Prayer Requests</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">All Prayer Requests</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Prayer Type</th>
                                <th>Request</th>
                                <th>Status</th>
                                <th>Submitted</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $prayerRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($request->id); ?></td>
                                    <td><?php echo e($request->name ?: 'Anonymous'); ?></td>
                                    <td><?php echo e($request->email ?: 'N/A'); ?></td>
                                    <td><?php echo e($request->prayer_type); ?></td>
                                    <td><?php echo e(Str::limit($request->prayer_request, 50)); ?></td>
                                    <td>
                                        <span class="badge badge-<?php echo e($request->status == 'approved' ? 'success' : ($request->status == 'rejected' ? 'danger' : 'warning')); ?>">
                                            <?php echo e(ucfirst($request->status)); ?>

                                        </span>
                                    </td>
                                    <td><?php echo e($request->created_at ? $request->created_at->format('M d, Y H:i') : 'N/A'); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('admin.prayer-requests.edit', $request->id)); ?>" class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <?php if($request->status == 'pending'): ?>
                                            <form action="<?php echo e(route('admin.prayer-requests.approve', $request->id)); ?>" method="POST" style="display: inline;">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                            </form>
                                            <form action="<?php echo e(route('admin.prayer-requests.reject', $request->id)); ?>" method="POST" style="display: inline;">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                            </form>
                                        <?php else: ?>
                                            <span class="text-muted"><?php echo e(ucfirst($request->status)); ?></span>
                                        <?php endif; ?>
                                        <form action="<?php echo e(route('admin.prayer-requests.destroy', $request->id)); ?>" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this prayer request?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-dark btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="8" class="text-center">No prayer requests found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <?php if($prayerRequests->hasPages()): ?>
                    <div class="card-footer">
                        <?php echo e($prayerRequests->links()); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/admin/prayer-requests/index.blade.php ENDPATH**/ ?>