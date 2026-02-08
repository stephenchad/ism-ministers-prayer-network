<?php $__env->startSection('title', 'Bulk Uploads'); ?>

<?php $__env->startSection('main'); ?>
    <!-- Breadcrumb -->
    <div class="breadcrumb-container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="<?php echo e(route('admin.dashboard')); ?>">
                        <i class="fas fa-home me-1"></i>
                        Home
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fas fa-upload me-1"></i>
                    Bulk Uploads
                </li>
            </ol>
        </nav>
    </div>

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Bulk Uploads</h1>
            <p class="page-subtitle">Upload CSV files to import data into the database</p>
        </div>
        <div class="page-actions">
            <a href="<?php echo e(route('admin.bulk-uploads.create')); ?>" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>
                Upload New File
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid fade-in">
        <div class="stat-card">
            <div class="stat-icon primary">
                <i class="fas fa-file-csv"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-value"><?php echo e($uploads->total()); ?></h3>
                <p class="stat-label">Total Uploads</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon success">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-value"><?php echo e($uploads->where('status', 'completed')->count()); ?></h3>
                <p class="stat-label">Completed</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon info">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-value"><?php echo e(date('H:i')); ?></h3>
                <p class="stat-label"><?php echo e(date('M d, Y')); ?></p>
            </div>
        </div>
    </div>

    <!-- Bulk Uploads Table -->
    <div class="admin-card fade-in">
        <div class="card-header">
            <h5 class="card-title">All Bulk Uploads</h5>
        </div>
        <div class="card-body p-0">
            <?php if(Session::has('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin: 20px;">
                    <?php echo e(Session::get('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if($uploads->isNotEmpty()): ?>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>File Name</th>
                                <th>Model Type</th>
                                <th>Status</th>
                                <th>Uploaded By</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $uploads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $upload): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($upload->id); ?></td>
                                    <td><?php echo e($upload->file_name); ?></td>
                                    <td>
                                        <span class="badge bg-primary"><?php echo e($upload->model_type); ?></span>
                                    </td>
                                    <td>
                                        <?php if($upload->status === 'completed'): ?>
                                            <span class="badge bg-success"><?php echo e(ucfirst($upload->status)); ?></span>
                                        <?php elseif($upload->status === 'failed'): ?>
                                            <span class="badge bg-danger"><?php echo e(ucfirst($upload->status)); ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-warning"><?php echo e(ucfirst($upload->status)); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($upload->uploader->name ?? 'Unknown'); ?></td>
                                    <td><?php echo e($upload->created_at->format('M d, Y H:i')); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('admin.bulk-uploads.show', $upload->id)); ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-upload fa-4x mb-4 text-muted opacity-50"></i>
                    <h5 class="text-muted">No bulk uploads found</h5>
                    <p class="text-muted mb-0">There are currently no bulk uploads in the system.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if($uploads->hasPages()): ?>
        <div class="d-flex justify-content-center mt-4">
            <?php echo e($uploads->links()); ?>

        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/admin/bulk-uploads/index.blade.php ENDPATH**/ ?>