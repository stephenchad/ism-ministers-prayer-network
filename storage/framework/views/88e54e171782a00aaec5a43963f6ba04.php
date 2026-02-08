<?php $__env->startSection('main'); ?>
<style>
.login-hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    padding: 60px 0;
}
.login-card {
    background: white;
    border-radius: 25px;
    box-shadow: 0 25px 50px rgba(0,0,0,0.15);
    padding: 50px;
    max-width: 450px;
    margin: 0 auto;
}
.login-header {
    text-align: center;
    margin-bottom: 40px;
}
.login-header h2 {
    color: #333;
    font-weight: 700;
    font-size: 2.5rem;
    margin-bottom: 10px;
}
.login-header p {
    color: #6c757d;
    font-size: 1rem;
}
.login-header a {
    color: #667eea;
    text-decoration: none;
    font-weight: 600;
}
.form-group {
    margin-bottom: 25px;
}
.form-label {
    color: #333;
    font-weight: 600;
    margin-bottom: 8px;
    display: block;
}
.form-input {
    width: 100%;
    padding: 15px 20px;
    border: 2px solid #e9ecef;
    border-radius: 15px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: #f8f9fa;
}
.form-input:focus {
    outline: none;
    border-color: #667eea;
    background: white;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}
.form-input.is-invalid {
    border-color: #dc3545;
}
.invalid-feedback {
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 5px;
}
.remember-forgot {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    font-size: 0.9rem;
}
.remember-forgot label {
    display: flex;
    align-items: center;
    color: #6c757d;
    cursor: pointer;
}
.remember-forgot input {
    margin-right: 8px;
}
.remember-forgot a {
    color: #667eea;
    text-decoration: none;
}
.btn-login {
    width: 100%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 15px;
    padding: 15px;
    color: white;
    font-weight: 600;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}
.btn-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 30px rgba(102, 126, 234, 0.3);
}
.alert {
    border-radius: 15px;
    padding: 15px 20px;
    margin-bottom: 25px;
    border: none;
}
.alert-success {
    background: #d4edda;
    color: #155724;
}
.alert-danger {
    background: #f8d7da;
    color: #721c24;
}
.social-login {
    margin-top: 30px;
}
.divider {
    text-align: center;
    margin-bottom: 20px;
    position: relative;
}
.divider::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 1px;
    background: #e9ecef;
}
.divider span {
    background: white;
    padding: 0 15px;
    color: #6c757d;
    font-weight: 600;
}
.social-buttons {
    display: flex;
    flex-direction: column;
    gap: 15px;
}
.btn-social {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 12px 20px;
    border: 2px solid #e9ecef;
    border-radius: 15px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    background: white;
    color: #333;
}
.btn-social:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}
.btn-google:hover {
    border-color: #db4437;
    color: #db4437;
}
.btn-facebook:hover {
    border-color: #4267B2;
    color: #4267B2;
}
.btn-github:hover {
    border-color: #333;
    color: #333;
}
.btn-instagram:hover {
    border-color: #E4405F;
    color: #E4405F;
}
.btn-tiktok:hover {
    border-color: #000000;
    color: #000000;
}
.btn-twitter:hover {
    border-color: #1DA1F2;
    color: #1DA1F2;
}
.btn-linkedin:hover {
    border-color: #0077B5;
    color: #0077B5;
}
.btn-youtube:hover {
    border-color: #FF0000;
    color: #FF0000;
}
.btn-kingschat:hover {
    border-color: #4a90e2;
    color: #4a90e2;
}
</style>

<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '-icon');
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>

<div class="login-hero">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="login-card">
                    <?php if(Session::has('success')): ?>
                    <div class="alert alert-success">
                        <?php echo e(Session::get('success')); ?>

                    </div>
                    <?php endif; ?>
                    <?php if(Session::has('error')): ?>
                    <div class="alert alert-danger">
                        <?php echo e(Session::get('error')); ?>

                    </div>
                    <?php endif; ?>
                    
                    <div class="login-header">
                        <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                            <i class="fas fa-praying-hands" style="font-size: 2rem; color: white;"></i>
                        </div>
                        <h2>Welcome back</h2>
                        <p>Don’t have an account? <a href="<?php echo e(route('account.registration')); ?>">Create one</a></p>
                    </div>

                    <form action="<?php echo e(route('account.authenticate')); ?>" method="post">
                        <?php echo csrf_field(); ?>
                        
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="<?php echo e(old('email')); ?>" class="form-input <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Enter your email" required>
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Password</label>
                            <div style="position: relative;">
                                <input type="password" name="password" id="password" class="form-input <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Enter your password" required>
                                <button type="button" onclick="togglePassword('password')" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #6c757d;" aria-label="Toggle password visibility">
                                    <i class="fas fa-eye" id="password-icon"></i>
                                </button>
                            </div>
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="remember-forgot">
                            <label>
                                <input type="checkbox" name="remember"> Remember me
                            </label>
                            <a href="<?php echo e(route('account.forgot-password')); ?>">Forgot password?</a>
                        </div>

                        <button type="submit" class="btn-login">
                            <i class="fas fa-sign-in-alt"></i>
                            Sign in
                        </button>
                    </form>

                    <div class="social-login">
                        <div class="divider">
                            <span>or</span>
                        </div>
                        <div class="social-buttons">
                            <a href="<?php echo e(route('social.login', 'google')); ?>" class="btn-social btn-google">
                                <i class="fab fa-google"></i>
                                Continue with Google
                            </a>
                            <a href="<?php echo e(route('social.login', 'facebook')); ?>" class="btn-social btn-facebook">
                                <i class="fab fa-facebook-f"></i>
                                Continue with Facebook
                            </a>
                           

                            <!-- TikTok login button removed due to unsupported driver -->
                            <!-- <a href="<?php echo e(route('social.login', 'tiktok')); ?>" class="btn-social btn-tiktok">
                                <i class="fab fa-tiktok"></i>
                                Continue with TikTok
                            </a>
                            <a href="<?php echo e(route('social.login', 'twitter')); ?>" class="btn-social btn-twitter">
                                <i class="fab fa-twitter"></i>
                                Continue with Twitter
                            </a>
                            <a href="<?php echo e(route('social.login', 'linkedin')); ?>" class="btn-social btn-linkedin">
                                <i class="fab fa-linkedin-in"></i>
                                Continue with LinkedIn
                            </a>
                            <!-- KingsChat login button removed due to unsupported driver -->
                            <!-- <a href="<?php echo e(route('social.login', 'kingschat')); ?>" class="btn-social btn-kingschat">
                                <i class="fas fa-comments"></i>
                                Continue with KingsChat
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/ism_ministers_prayer_network/resources/views/front/account/login.blade.php ENDPATH**/ ?>