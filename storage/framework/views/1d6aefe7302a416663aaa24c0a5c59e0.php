<?php $__env->startSection('title', 'My Profile'); ?>

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
                    <i class="fas fa-user me-1"></i>
                    My Profile
                </li>
            </ol>
        </nav>
    </div>

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">My Profile</h1>
            <p class="page-subtitle">Manage your account information</p>
        </div>
    </div>

    <!-- Profile Content -->
    <div class="row fade-in">
        <div class="col-lg-4 mb-4">
            <div class="admin-card">
                <div class="card-body text-center">
                    <div class="profile-avatar-lg mx-auto mb-3">
                        <?php echo e(substr(Auth::user()->name, 0, 1)); ?><?php echo e(substr(explode(' ', Auth::user()->name)[1] ?? '', 0, 1)); ?>

                    </div>
                    <h5 class="mb-1"><?php echo e(Auth::user()->name); ?></h5>
                    <p class="text-muted mb-3"><?php echo e(Auth::user()->email); ?></p>
                    <span class="badge bg-primary"><?php echo e(ucfirst(Auth::user()->role)); ?></span>
                </div>
            </div>
        </div>
        <div class="col-lg-8 mb-4">
            <div class="admin-card">
                <div class="card-header">
                    <h5 class="card-title">Profile Information</h5>
                </div>
                <div class="card-body">
                    <?php if(Session::has('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo e(Session::get('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo e(route('account.updateProfile')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo e(Auth::user()->name); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo e(Auth::user()->email); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="designation" class="form-label">Designation</label>
                                <input type="text" class="form-control" id="designation" name="designation" value="<?php echo e(Auth::user()->designation); ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="mobile" class="form-label">Mobile Number</label>
                                <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo e(Auth::user()->mobile); ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo e(Auth::user()->last_name); ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="birthday" class="form-label">Birthday</label>
                                <input type="date" class="form-control" id="birthday" name="birthday" value="<?php echo e(Auth::user()->birthday); ?>">
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="admin-card mt-4">
                <div class="card-header">
                    <h5 class="card-title">Referral Information</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Referral Code</label>
                            <div class="input-group">
                                <input type="text" class="form-control" value="<?php echo e(Auth::user()->referral_code); ?>" readonly>
                                <button class="btn btn-outline-secondary" type="button" onclick="copyReferralCode()">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Referred By</label>
                            <input type="text" class="form-control" value="<?php echo e(Auth::user()->referrer ? Auth::user()->referrer->name : 'None'); ?>" readonly>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Total Referrals</label>
                            <input type="text" class="form-control" value="<?php echo e(Auth::user()->referrals->count()); ?> users" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        function copyReferralCode() {
            navigator.clipboard.writeText('<?php echo e(Auth::user()->referral_code); ?>');
            alert('Referral code copied to clipboard!');
        }
    </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/admin/profile/index.blade.php ENDPATH**/ ?>