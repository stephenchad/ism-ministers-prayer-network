<?php $__env->startSection('title', 'Change Password'); ?>

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
                <li class="breadcrumb-item">
                    <a href="<?php echo e(route('admin.profile')); ?>">
                        <i class="fas fa-user me-1"></i>
                        My Profile
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fas fa-key me-1"></i>
                    Change Password
                </li>
            </ol>
        </nav>
    </div>

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Change Password</h1>
            <p class="page-subtitle">Update your account password</p>
        </div>
    </div>

    <!-- Password Form -->
    <div class="row fade-in">
        <div class="col-lg-6 mx-auto">
            <div class="admin-card">
                <div class="card-header">
                    <h5 class="card-title">Password Settings</h5>
                </div>
                <div class="card-body">
                    <?php if(Session::has('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo e(Session::get('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if(Session::has('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo e(Session::get('error')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo e(route('account.updatePassword')); ?>" method="POST" id="passwordForm">
                        <?php echo csrf_field(); ?>
                        
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="current_password" name="current_password" required>
                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="current_password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="new_password" name="password" required minlength="8">
                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="new_password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <small class="text-muted">Password must be at least 8 characters long</small>
                        </div>

                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm New Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="confirm_password" name="password_confirmation" required>
                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="confirm_password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="password-strength" id="passwordStrength">
                                <div class="strength-bar">
                                    <div class="strength-fill" id="strengthFill"></div>
                                </div>
                                <small class="strength-text" id="strengthText">Enter a password to see strength</small>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-key me-1"></i>
                            Update Password
                        </button>
                    </form>
                </div>
            </div>

            <div class="admin-card mt-4">
                <div class="card-header">
                    <h5 class="card-title">Password Requirements</h5>
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li class="mb-2">At least 8 characters long</li>
                        <li class="mb-2">Contains both uppercase and lowercase letters</li>
                        <li class="mb-2">Contains at least one number</li>
                        <li>Contains at least one special character</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        // Toggle password visibility
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const target = document.getElementById(this.dataset.target);
                const icon = this.querySelector('i');
                
                if (target.type === 'password') {
                    target.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    target.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });

        // Password strength indicator
        const newPassword = document.getElementById('new_password');
        const strengthFill = document.getElementById('strengthFill');
        const strengthText = document.getElementById('strengthText');

        newPassword.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            let color = '#ef4444';
            let text = 'Very Weak';

            if (password.length >= 8) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;

            switch(strength) {
                case 0:
                case 1:
                    color = '#ef4444';
                    text = 'Very Weak';
                    break;
                case 2:
                    color = '#f59e0b';
                    text = 'Weak';
                    break;
                case 3:
                    color = '#3b82f6';
                    text = 'Medium';
                    break;
                case 4:
                    color = '#10b981';
                    text = 'Strong';
                    break;
                case 5:
                    color = '#059669';
                    text = 'Very Strong';
                    break;
            }

            strengthFill.style.width = (strength * 20) + '%';
            strengthFill.style.background = color;
            strengthText.textContent = text;
            strengthText.style.color = color;
        });
    </script>
    <?php $__env->stopPush(); ?>

    <?php $__env->startPush('styles'); ?>
    <style>
        .password-strength {
            margin-top: 8px;
        }
        .strength-bar {
            height: 6px;
            background: var(--admin-bg-light);
            border-radius: 3px;
            overflow: hidden;
            margin-bottom: 8px;
        }
        .strength-fill {
            height: 100%;
            width: 0;
            transition: all 0.3s ease;
            border-radius: 3px;
        }
        .strength-text {
            font-size: 12px;
            color: var(--admin-text-muted);
        }
    </style>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/admin/profile/change-password.blade.php ENDPATH**/ ?>