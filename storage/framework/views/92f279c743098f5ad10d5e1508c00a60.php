<?php $__env->startSection('title', 'Referral Management'); ?>

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
                    <i class="fas fa-share-alt me-1"></i>
                    Referrals
                </li>
            </ol>
        </nav>
    </div>

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Referral Management</h1>
            <p class="page-subtitle">Manage user referrals and referral codes</p>
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
                <i class="fas fa-share-alt"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-value"><?php echo e($users->where('referrer_id', '!=', null)->count()); ?></h3>
                <p class="stat-label">Referred Users</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon info">
                <i class="fas fa-code-branch"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-value"><?php echo e($users->sum(function($u) { return $u->referrals->count(); })); ?></h3>
                <p class="stat-label">Total Referrals</p>
            </div>
        </div>
    </div>

    <!-- Referrals Table -->
    <div class="admin-card fade-in">
        <div class="card-header">
            <h5 class="card-title">All Referrals</h5>
        </div>
        <div class="card-body p-0">
            <?php if(Session::has('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin: 20px;">
                    <?php echo e(Session::get('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <?php if($users->isNotEmpty()): ?>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Email</th>
                                <th>Referral Code</th>
                                <th>Referred By</th>
                                <th>Referrals Count</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="user-avatar-sm">
                                            <?php echo e(substr($user->name, 0, 1)); ?>

                                        </div>
                                        <?php echo e($user->name); ?>

                                    </div>
                                </td>
                                <td><?php echo e($user->email); ?></td>
                                <td><code><?php echo e($user->referral_code); ?></code></td>
                                <td><?php echo e($user->referrer ? $user->referrer->name : 'N/A'); ?></td>
                                <td>
                                    <span class="badge bg-primary"><?php echo e($user->referrals->count()); ?></span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="<?php echo e(route('admin.referrals.edit', $user->id)); ?>" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit me-1"></i>Edit
                                        </a>
                                        <button class="btn btn-sm btn-warning" onclick="resetReferralCode(<?php echo e($user->id); ?>)">
                                            <i class="fas fa-sync me-1"></i>Reset
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-share-alt fa-4x mb-4 text-muted opacity-50"></i>
                    <h5 class="text-muted">No referral data found</h5>
                    <p class="text-muted mb-0">There are no users with referral data.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if($users->hasPages()): ?>
        <div class="d-flex justify-content-center mt-4">
            <?php echo e($users->links()); ?>

        </div>
    <?php endif; ?>

    <?php $__env->startPush('scripts'); ?>
    <script>
        function resetReferralCode(userId) {
            if(confirm('Are you sure you want to reset the referral code for this user?')) {
                $.post('<?php echo e(route("admin.referrals.resetCode")); ?>', {
                    id: userId,
                    _token: '<?php echo e(csrf_token()); ?>'
                }, function(response) {
                    if(response.status) {
                        alert(response.message + '\nNew Code: ' + response.new_code);
                        location.reload();
                    } else {
                        alert('Failed to reset referral code: ' + response.message);
                    }
                });
            }
        }
    </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/admin/referrals/index.blade.php ENDPATH**/ ?>