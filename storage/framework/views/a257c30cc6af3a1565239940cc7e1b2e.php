<?php $__env->startSection('title', 'Manage Groups'); ?>

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
                    <i class="fas fa-users-cog me-1"></i>
                    Groups
                </li>
            </ol>
        </nav>
    </div>

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Prayer Groups Management</h1>
            <p class="page-subtitle">Oversee and manage all prayer group activities</p>
        </div>
        <div class="page-actions">
            <a href="<?php echo e(route('admin.groups.create')); ?>" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>
                Add New Group
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid fade-in">
        <div class="stat-card">
            <div class="stat-icon success">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-value"><?php echo e($groups->total()); ?></h3>
                <p class="stat-label">Total Groups</p>
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

    <!-- Groups Cards -->
    <div class="admin-card fade-in">
        <div class="card-header">
            <h5 class="card-title">All Groups</h5>
        </div>
        <div class="card-body">
            <?php if(Session::has('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo e(Session::get('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <?php if($groups->isNotEmpty()): ?>
                <div class="row g-4">
                    <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-xl-4 col-lg-6 col-md-6">
                            <div class="group-card">
                                <div class="group-card-header">
                                    <div class="group-avatar">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div class="group-info">
                                        <h5 class="group-name"><?php echo e($group->title); ?></h5>
                                        <span class="badge bg-primary rounded-pill"><?php echo e($group->current_members); ?>/<?php echo e($group->max_members); ?></span>
                                    </div>
                                    <div class="group-id">
                                        <small class="text-muted">ID: <?php echo e($group->id); ?></small>
                                    </div>
                                </div>
                                <div class="group-card-body">
                                    <p class="group-description"><?php echo e(Str::limit($group->description, 80)); ?></p>
                                    <div class="group-detail">
                                        <i class="fas fa-user"></i>
                                        <span>Created by <?php echo e($group->user->name); ?></span>
                                    </div>
                                    <div class="group-detail">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span><?php echo e($group->city->name ?? 'N/A'); ?>, <?php echo e($group->country->name ?? 'N/A'); ?></span>
                                    </div>
                                    <?php if($group->address): ?>
                                        <div class="group-detail">
                                            <i class="fas fa-home"></i>
                                            <span><?php echo e(Str::limit($group->address, 30)); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <div class="group-detail">
                                        <i class="fas fa-calendar"></i>
                                        <span>Created <?php echo e($group->created_at->format('M d, Y')); ?></span>
                                    </div>
                                </div>
                                <div class="group-card-actions">
                                    <a href="<?php echo e(route('admin.groups.show', $group->id)); ?>" class="btn btn-info btn-sm">
                                        <i class="fas fa-cog me-1"></i>Manage
                                    </a>
                                    <a href="<?php echo e(route('admin.groups.edit', $group->id)); ?>" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit me-1"></i>Edit
                                    </a>
                                    <button onclick="deleteGroup(<?php echo e($group->id); ?>)" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash me-1"></i>Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-users-cog fa-4x mb-4 text-muted opacity-50"></i>
                    <h5 class="text-muted">No groups found</h5>
                    <p class="text-muted mb-0">There are currently no prayer groups in the system.</p>
                </div>
            <?php endif; ?>
            
            <?php if($groups->hasPages()): ?>
                <div class="d-flex justify-content-center mt-4">
                    <?php echo e($groups->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        function deleteGroup(id) {
            if (confirm("Are you sure you want to delete this group?")) {
                $.ajax({
                    url: '/admin/groups/' + id,
                    type: 'DELETE',
                    data: { id: id, _token: '<?php echo e(csrf_token()); ?>' },
                    dataType: 'json',
                    success: function(response) {
                        if(response.status) {
                            location.reload();
                        } else {
                            alert('Error deleting group');
                        }
                    },
                    error: function(xhr) {
                        alert('Error deleting group: ' + (xhr.responseJSON?.message || 'Unknown error'));
                    }
                });
            }
        }
    </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/admin/groups/list.blade.php ENDPATH**/ ?>