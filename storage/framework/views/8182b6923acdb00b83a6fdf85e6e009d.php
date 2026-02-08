<?php $__env->startSection('title', 'Manage Users'); ?>

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
                    <i class="fas fa-users me-1"></i>
                    Users
                </li>
            </ol>
        </nav>
    </div>

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">User Management</h1>
            <p class="page-subtitle">Monitor and manage all registered users</p>
        </div>
        <div class="page-actions">
            <a href="<?php echo e(route('admin.users.create')); ?>" class="btn btn-primary">
                <i class="fas fa-user-plus me-1"></i>
                Add New User
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid fade-in">
        <div class="stat-card">
            <div class="stat-icon primary">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-value"><?php echo e($users->total()); ?></h3>
                <p class="stat-label">Total Users</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon success">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-value"><?php echo e($users->where('role', 'admin')->count()); ?></h3>
                <p class="stat-label">Admins</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon info">
                <i class="fas fa-calendar"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-value"><?php echo e(date('H:i')); ?></h3>
                <p class="stat-label"><?php echo e(date('M d, Y')); ?></p>
            </div>
        </div>
    </div>

    <!-- Users Cards -->
    <div class="admin-card fade-in">
        <div class="card-header">
            <h5 class="card-title">All Users</h5>
        </div>
        <div class="card-body">
            <?php if(Session::has('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo e(Session::get('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <?php if($users->isNotEmpty()): ?>
                <div class="row g-4">
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-xl-4 col-lg-6 col-md-6">
                            <div class="user-card">
                                <div class="user-card-header">
                                    <div class="user-avatar">
                                        <?php echo e(substr($user->name, 0, 1)); ?><?php echo e(substr(explode(' ', $user->name)[1] ?? '', 0, 1)); ?>

                                    </div>
                                    <div class="user-info">
                                        <h5 class="user-name"><?php echo e($user->name); ?></h5>
                                        <span class="badge bg-<?php echo e($user->role === 'admin' ? 'danger' : 'secondary'); ?> rounded-pill"><?php echo e(ucfirst($user->role)); ?></span>
                                    </div>
                                    <div class="user-id">
                                        <small class="text-muted">ID: <?php echo e($user->id); ?></small>
                                    </div>
                                </div>
                                <div class="user-card-body">
                                    <div class="user-detail">
                                        <i class="fas fa-envelope"></i>
                                        <span><?php echo e($user->email); ?></span>
                                    </div>
                                    <?php if($user->designation): ?>
                                        <div class="user-detail">
                                            <i class="fas fa-briefcase"></i>
                                            <span><?php echo e($user->designation); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($user->mobile): ?>
                                        <div class="user-detail">
                                            <i class="fas fa-phone"></i>
                                            <span><?php echo e($user->mobile); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <div class="user-detail">
                                        <i class="fas fa-calendar"></i>
                                        <span>Joined <?php echo e($user->created_at->format('M d, Y')); ?></span>
                                    </div>
                                    <div class="user-detail">
                                        <i class="fas fa-share-alt"></i>
                                        <span>Referral Code: <?php echo e($user->referral_code); ?></span>
                                    </div>
                                    <div class="user-detail">
                                        <i class="fas fa-users"></i>
                                        <span><?php echo e($user->referrals->count()); ?> Referrals</span>
                                    </div>
                                </div>
                                <div class="user-card-actions">
                                    <a href="<?php echo e(route('admin.users.edit', $user->id)); ?>" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit me-1"></i>Edit
                                    </a>
                                    <button onclick="deleteUser(<?php echo e($user->id); ?>)" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash me-1"></i>Delete
                                    </button>
                                    <button onclick="toggleAdmin(<?php echo e($user->id); ?>, '<?php echo e($user->role); ?>')" class="btn btn-<?php echo e($user->role === 'admin' ? 'warning' : 'success'); ?> btn-sm">
                                        <i class="fas fa-<?php echo e($user->role === 'admin' ? 'user-minus' : 'user-shield'); ?> me-1"></i>
                                        <?php echo e($user->role === 'admin' ? 'Remove Admin' : 'Make Admin'); ?>

                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-users fa-4x mb-4 text-muted opacity-50"></i>
                    <h5 class="text-muted">No users found</h5>
                    <p class="text-muted mb-0">There are currently no registered users in the system.</p>
                </div>
            <?php endif; ?>
            
            <?php if($users->hasPages()): ?>
                <div class="d-flex justify-content-center mt-4">
                    <?php echo e($users->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        function deleteUser(id) {
            if (confirm("Are you sure you want to delete this user?")) {
                $.ajax({
                    url: '<?php echo e(route("admin.users.destroy")); ?>',
                    type: 'DELETE',
                    data: { id: id, _token: '<?php echo e(csrf_token()); ?>' },
                    dataType: 'json',
                    success: function(response) {
                        if(response.status) {
                            location.reload();
                        } else {
                            alert('Error deleting user');
                        }
                    },
                    error: function(xhr) {
                        alert('Error deleting user: ' + (xhr.responseJSON?.message || 'Unknown error'));
                    }
                });
            }
        }

        function toggleAdmin(id, currentRole) {
            const newRole = currentRole === 'admin' ? 'user' : 'admin';
            const action = newRole === 'admin' ? 'make this user an admin' : 'remove admin privileges from this user';
            
            if (confirm(`Are you sure you want to ${action}?`)) {
                $.ajax({
                    url: '<?php echo e(route("admin.users.toggle-admin")); ?>',
                    type: 'POST',
                    data: { id: id, role: newRole, _token: '<?php echo e(csrf_token()); ?>' },
                    dataType: 'json',
                    success: function(response) {
                        if(response.status) {
                            location.reload();
                        } else {
                            alert('Error updating user role');
                        }
                    },
                    error: function(xhr) {
                        alert('Error updating user role: ' + (xhr.responseJSON?.message || 'Unknown error'));
                    }
                });
            }
        }
    </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/admin/users/list.blade.php ENDPATH**/ ?>