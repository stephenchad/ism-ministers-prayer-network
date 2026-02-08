<?php $__env->startSection('main'); ?>
<style>
.modern-hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 80px 0 40px;
    color: white;
    text-align: center;
}
.modern-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    padding: 40px;
    margin-bottom: 30px;
    transition: transform 0.3s ease;
}
.modern-card:hover {
    transform: translateY(-5px);
}
.profile-avatar {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 3rem;
    font-weight: 700;
    margin: 0 auto 20px;
    border: 5px solid white;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}
.form-floating {
    margin-bottom: 20px;
}
.form-floating input, .form-floating select {
    border: 2px solid #e9ecef;
    border-radius: 12px;
    padding: 20px 15px;
}
.form-floating input:focus, .form-floating select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}
.btn-modern {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 50px;
    padding: 15px 40px;
    color: white;
    font-weight: 600;
    transition: all 0.3s ease;
}
.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
    color: white;
}
.sidebar-card {
    background: white;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    margin-bottom: 30px;
}
.nav-link-modern {
    display: flex;
    align-items: center;
    padding: 15px 20px;
    color: #6c757d;
    text-decoration: none;
    border-radius: 12px;
    margin-bottom: 10px;
    transition: all 0.3s ease;
}
.nav-link-modern:hover, .nav-link-modern.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    transform: translateX(5px);
}
.nav-link-modern i {
    margin-right: 15px;
    width: 20px;
}
</style>

<div class="modern-hero">
    <div class="container">
        <h1 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 0.5rem;">My Profile</h1>
        <p style="opacity: 0.9;">Manage your account settings and preferences</p>
    </div>
</div>

<div style="padding: 60px 0; background: #f8f9fa;">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="sidebar-card">
                    <div class="text-center mb-4">
                        <div class="profile-avatar">
                            <?php if($user->image): ?>
                                <img id="profileImage" src="<?php echo e($user->getImageUrl()); ?>" alt="Profile Picture" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                            <?php else: ?>
                                <?php echo e(strtoupper(substr($user->name, 0, 2))); ?>

                            <?php endif; ?>
                        </div>
                        <div class="mt-3">
                            <form id="profilePicForm" method="POST" action="<?php echo e(route('account.updateProfilePic')); ?>" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <input type="file" id="profilePic" name="image" accept="image/*" required style="display: none;">
                                <button type="button" onclick="document.getElementById('profilePic').click()" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-camera"></i> Change Photo
                                </button>
                            </form>
                        </div>
                        <h4 style="margin-bottom: 0.5rem; color: #333;"><?php echo e($user->name); ?></h4>
                        <p style="color: #6c757d;"><?php echo e($user->designation ?? 'Member'); ?></p>
                    </div>
                    
                    <nav>
                        <a href="#profile-section" class="nav-link-modern active" onclick="showSection('profile', event)">
                            <i class="fas fa-user"></i>
                            Profile Information
                        </a>
                        <a href="#password-section" class="nav-link-modern" onclick="showSection('password', event)">
                            <i class="fas fa-lock"></i>
                            Change Password
                        </a>
                        <a href="#settings-section" class="nav-link-modern" onclick="showSection('settings', event)">
                            <i class="fas fa-cog"></i>
                            Account Settings
                        </a>
                        <a href="#notifications-section" class="nav-link-modern" onclick="showSection('notifications', event)">
                            <i class="fas fa-bell"></i>
                            Notifications
                        </a>
                        <a href="#referrals-section" class="nav-link-modern" onclick="showSection('referrals', event)">
                            <i class="fas fa-share-alt"></i>
                            Referrals
                        </a>

                        <a href="<?php echo e(route('account.myGroups')); ?>" class="nav-link-modern">
                            <i class="fas fa-users"></i>
                            My Groups
                        </a>
                        
                        
                    </nav>
                </div>
            </div>

            <div class="col-lg-8">
                <?php echo $__env->make('front.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                
                <!-- Profile Information Section -->
                <div id="profile-section" class="section-content">
                    <div class="modern-card">
                        <h3 style="color: #333; margin-bottom: 2rem; display: flex; align-items: center;">
                            <i class="fas fa-user" style="margin-right: 15px; color: #667eea;"></i>
                            Profile Information
                        </h3>
                        
                        <form id="userForm" method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="name" id="name" value="<?php echo e($user->name); ?>" class="form-control" placeholder="Your Name" required>
                                        <label for="name">Full Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" name="email" id="email" value="<?php echo e($user->email); ?>" class="form-control" placeholder="Your Email" required>
                                        <label for="email">Email Address</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="designation" id="designation" value="<?php echo e($user->designation); ?>" class="form-control" placeholder="Your Designation">
                                        <label for="designation">Designation</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="tel" name="mobile" id="mobile" value="<?php echo e($user->mobile); ?>" class="form-control" placeholder="Your Mobile">
                                        <label for="mobile">Mobile Number</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="date" name="birthday" id="birthday" value="<?php echo e($user->birthday ? $user->birthday->format('Y-m-d') : ''); ?>" class="form-control" placeholder="Your Birthday">
                                        <label for="birthday">Birthday</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                                        <label for="image">Profile Picture (optional)</label>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mt-3">
                                <button type="submit" class="btn-modern">
                                    <i class="fas fa-save" style="margin-right: 10px;"></i>
                                    Update Profile
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Password Section -->
                <div id="password-section" class="section-content" style="display: none;">
                    <div class="modern-card">
                        <h3 style="color: #333; margin-bottom: 2rem; display: flex; align-items: center;">
                            <i class="fas fa-lock" style="margin-right: 15px; color: #667eea;"></i>
                            Change Password
                        </h3>
                        
                        <form id="changePasswordForm" method="POST" action="<?php echo e(route('account.updatePassword')); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="form-floating">
                                <input type="password" name="current_password" id="current_password" class="form-control" placeholder="Current Password" required>
                                <label for="current_password">Current Password</label>
                            </div>
                            <div class="form-floating">
                                <input type="password" name="new_password" id="new_password" class="form-control" placeholder="New Password" required>
                                <label for="new_password">New Password</label>
                            </div>
                            <div class="form-floating">
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" placeholder="Confirm Password" required>
                                <label for="new_password_confirmation">Confirm New Password</label>
                            </div>
                            <div class="text-center mt-3">
                                <button type="submit" class="btn-modern">
                                    <i class="fas fa-key" style="margin-right: 10px;"></i>
                                    Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Settings Section -->
                <div id="settings-section" class="section-content" style="display: none;">
                    <div class="modern-card">
                        <h3 style="color: #333; margin-bottom: 2rem; display: flex; align-items: center;">
                            <i class="fas fa-cog" style="margin-right: 15px; color: #667eea;"></i>
                            Account Settings
                        </h3>

                        <form id="settingsForm" method="POST" action="<?php echo e(route('account.updateSettings')); ?>">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div style="padding: 20px; background: #f8f9fa; border-radius: 12px; margin-bottom: 20px;">
                                        <h5 style="color: #333; margin-bottom: 1rem;">Email Notifications</h5>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="email_prayer" id="emailPrayer" <?php echo e($user->email_prayer ? 'checked' : ''); ?>>
                                            <label class="form-check-label" for="emailPrayer">Prayer updates</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="email_newsletter" id="emailNews" <?php echo e($user->email_newsletter ? 'checked' : ''); ?>>
                                            <label class="form-check-label" for="emailNews">Newsletter</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div style="padding: 20px; background: #f8f9fa; border-radius: 12px; margin-bottom: 20px;">
                                        <h5 style="color: #333; margin-bottom: 1rem;">Privacy Settings</h5>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="public_profile" id="profilePublic" <?php echo e($user->public_profile ? 'checked' : ''); ?>>
                                            <label class="form-check-label" for="profilePublic">Public profile</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="show_email" id="showEmail" <?php echo e($user->show_email ? 'checked' : ''); ?>>
                                            <label class="form-check-label" for="showEmail">Show email to others</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn-modern">
                                    <i class="fas fa-save" style="margin-right: 10px;"></i>
                                    Save Settings
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Notifications Section -->
                <div id="notifications-section" class="section-content" style="display: none;">
                    <div class="modern-card">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 style="color: #333; margin-bottom: 0; display: flex; align-items: center;">
                                <i class="fas fa-bell" style="margin-right: 15px; color: #667eea;"></i>
                                Your Notifications
                            </h3>
                            <?php if($user->unreadNotifications->count() > 0): ?>
                                <a href="<?php echo e(route('notifications.markAllAsRead')); ?>" class="btn btn-sm btn-outline-primary">Mark all as read</a>
                            <?php endif; ?>
                        </div>

                        <?php if($notifications->isNotEmpty()): ?>
                            <ul class="list-group list-group-flush">
                                <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-start py-3 px-0 <?php echo e($notification->read_at ? '' : 'bg-light rounded px-3'); ?>">
                                        <div class="flex-grow-1">
                                            <a href="<?php echo e(route('notifications.markAsRead', ['id' => $notification->id, 'url' => $notification->data['url'] ?? url()->current()])); ?>" class="text-decoration-none">
                                                <p class="mb-1 <?php echo e($notification->read_at ? 'text-muted' : 'fw-bold text-dark'); ?>">
                                                    <?php echo e($notification->data['message']); ?>

                                                </p>
                                                <small class="text-muted"><?php echo e($notification->created_at->diffForHumans()); ?></small>
                                            </a>
                                        </div>
                                        <?php if(!$notification->read_at): ?>
                                            <span class="badge bg-primary rounded-pill ms-3">New</span>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <div class="mt-4">
                                <?php echo e($notifications->links()); ?>

                            </div>
                        <?php else: ?>
                            <div class="text-center text-muted p-5">
                                <i class="fas fa-bell-slash fa-3x mb-3"></i>
                                <p>You have no notifications yet.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Referrals Section -->
                <div id="referrals-section" class="section-content" style="display: none;">
                    <div class="modern-card">
                        <h3 style="color: #333; margin-bottom: 2rem; display: flex; align-items: center;">
                            <i class="fas fa-share-alt" style="margin-right: 15px; color: #667eea;"></i>
                            Your Referrals
                        </h3>

                        <div class="row">
                            <div class="col-md-6">
                                <div style="padding: 20px; background: #f8f9fa; border-radius: 12px; margin-bottom: 20px;">
                                    <h5 style="color: #333; margin-bottom: 1rem;">Your Referral Link</h5>
                                    <p style="color: #6c757d; margin-bottom: 1rem;">Share this link to invite others to join:</p>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="referralLink" value="<?php echo e(url('/account/register?ref=' . $user->referral_code)); ?>" readonly>
                                        <button class="btn btn-outline-primary" type="button" onclick="copyReferralLink()">
                                            <i class="fas fa-copy"></i> Copy
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div style="padding: 20px; background: #f8f9fa; border-radius: 12px; margin-bottom: 20px;">
                                    <h5 style="color: #333; margin-bottom: 1rem;">Referral Stats</h5>
                                    <div class="row text-center">
                                        <div class="col-6">
                                            <div style="font-size: 2rem; font-weight: bold; color: #667eea;"><?php echo e($user->referrals->count()); ?></div>
                                            <div style="color: #6c757d;">Total Referrals</div>
                                        </div>
                                        <div class="col-6">
                                            <div style="font-size: 2rem; font-weight: bold; color: #28a745;"><?php echo e($user->referrals->where('email_verified_at', '!=', null)->count()); ?></div>
                                            <div style="color: #6c757d;">Verified</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h5 style="color: #333; margin-bottom: 1rem;">People You've Referred</h5>
                        <?php if($user->referrals->isNotEmpty()): ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Joined</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $user->referrals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $referral): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($referral->name); ?></td>
                                                <td><?php echo e($referral->email); ?></td>
                                                <td><?php echo e($referral->created_at->format('M d, Y')); ?></td>
                                                <td>
                                                    <?php if($referral->email_verified_at): ?>
                                                        <span class="badge bg-success">Verified</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-warning">Pending</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center text-muted p-5">
                                <i class="fas fa-users fa-3x mb-3"></i>
                                <p>You haven't referred anyone yet. Share your referral link to get started!</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showSection(sectionName, event) {
    // Hide all sections
    document.querySelectorAll('.section-content').forEach(section => {
        section.style.display = 'none';
    });
    
    // Remove active class from all nav links
    document.querySelectorAll('.nav-link-modern').forEach(link => {
        link.classList.remove('active');
    });
    
    // Show selected section
    document.getElementById(sectionName + '-section').style.display = 'block';
    
    // Add active class to clicked nav link
    event.target.classList.add('active');

    // Update URL hash
    if(history.pushState) {
        history.pushState(null, null, '#' + sectionName + '-section');
    } else {
        location.hash = '#' + sectionName + '-section';
    }
}

// On page load, check for a hash and show the correct section
document.addEventListener('DOMContentLoaded', function() {
    const hash = window.location.hash;
    if (hash) {
        // Find the corresponding nav link
        const link = document.querySelector(`a[href="${hash}"]`);
        if (link) {
            // Simulate a click to show the section and set the active state
            link.click();
        }
    }
});

</script>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('customJS'); ?>
<script>
// Profile form submission
$("#userForm").submit(function(e){
    e.preventDefault();
    
    $.ajax({
        url: '<?php echo e(route('account.updateProfile')); ?>',
        type: 'PUT',
        dataType: 'json',
        data: $("#userForm").serializeArray(),
        success: function(response) {
            if(response.status == true) {
                // Clear validation errors
                $(".form-control").removeClass('is-invalid');
                $("p").removeClass('invalid-feedback').html('');
                
                // Show success message
                alert('Profile updated successfully!');
                window.location.href = "<?php echo e(route('account.profile')); ?>";
            } else {
                // Handle validation errors
                var errors = response.errors;
                Object.keys(errors).forEach(function(key) {
                    $("#" + key).addClass('is-invalid');
                    $("#" + key).siblings('p').addClass('invalid-feedback').html(errors[key]);
                });
            }
        }
    });
});

    // Password form submission
    $("#changePasswordForm").submit(function(e){
        e.preventDefault();
        
        $.ajax({
            url: '<?php echo e(route('account.updatePassword')); ?>',
            type: 'POST',
            dataType: 'json',
            data: $("#changePasswordForm").serializeArray(),
            success: function(response) {
                if(response.status == true) {
                    // Clear form and show success
                    $("#changePasswordForm")[0].reset();
                    alert('Password changed successfully!');
                } else {
                    // Handle validation errors
                    var errors = response.errors;
                    Object.keys(errors).forEach(function(key) {
                        $("#" + key).addClass('is-invalid');
                        $("#" + key).siblings('p').addClass('invalid-feedback').html(errors[key]);
                    });
                }
            }
        });
    });

    // Profile picture upload on file change
    $('#profilePic').on('change', function() {
        var formData = new FormData($('#profilePicForm')[0]);

        $.ajax({
            url: '<?php echo e(route('account.updateProfilePic')); ?>',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if(response.status == true) {
                    alert('Profile picture updated successfully!');
                    // Update the profile avatar
                    const avatarDiv = document.querySelector('.profile-avatar');
                    avatarDiv.innerHTML = `<img id="profileImage" src="${response.imageUrl}" alt="Profile Picture" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">`;
                } else {
                    alert('Error: ' + JSON.stringify(response.errors));
                }
            }
        });
    });

// Settings form submission
$("#settingsForm").submit(function(e){
    e.preventDefault();

    $.ajax({
        url: '<?php echo e(route('account.updateSettings')); ?>',
        type: 'PUT',
        dataType: 'json',
        data: $("#settingsForm").serializeArray(),
        success: function(response) {
            if(response.status == true) {
                // Clear validation errors
                $(".form-check-input").removeClass('is-invalid');
                alert('Settings updated successfully!');
            } else {
                // Handle validation errors
                var errors = response.errors;
                Object.keys(errors).forEach(function(key) {
                    $("#" + key).addClass('is-invalid');
                    $("#" + key).siblings('p').addClass('invalid-feedback').html(errors[key]);
                });
            }
        }
    });
});

function copyReferralLink() {
    const referralLink = document.getElementById('referralLink');
    referralLink.select();
    referralLink.setSelectionRange(0, 99999); // For mobile devices
    document.execCommand('copy');

    // Show feedback
    const button = event.target.closest('button');
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-check"></i> Copied!';
    button.classList.remove('btn-outline-primary');
    button.classList.add('btn-success');

    setTimeout(() => {
        button.innerHTML = originalText;
        button.classList.remove('btn-success');
        button.classList.add('btn-outline-primary');
    }, 2000);
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/front/account/profile.blade.php ENDPATH**/ ?>