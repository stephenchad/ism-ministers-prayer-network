@extends('front.layouts.auth')

@section('main')
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
    max-width: 500px;
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
    margin-bottom: 20px;
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
    margin-top: 10px;
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
                    @if(Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                    @endif
                    @if(Session::has('error'))
                    <div class="alert alert-danger">
                        {{ Session::get('error') }}
                    </div>
                    @endif
                    
                    <div class="login-header">
                        <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                            <i class="fas fa-praying-hands" style="font-size: 2rem; color: white;"></i>
                        </div>
                        <h2>Create Your Account</h2>
                        <p>Already have an account? <a href="{{ route('account.login') }}">Log In</a></p>
                    </div>

                    <form action="" name="registrationForm" id="registrationForm">
                        @csrf
                        
                        <!-- Hidden Referral Code -->
                        <input type="hidden" name="referral_code" value="{{ is_string(request('ref')) ? request('ref') : '' }}">

                        <div class="form-group">
                            <label class="form-label">Name</label>
                            <input type="text" id="name" name="name" class="form-input @error('name') is-invalid @enderror" placeholder="Enter your name" value="{{ old('name') }}" required>
                            <p class="invalid-feedback"></p>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-input @error('email') is-invalid @enderror" placeholder="Enter your email" value="{{ old('email') }}" required>
                            <p class="invalid-feedback"></p>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Password</label>
                            <div style="position: relative;">
                                <input type="password" id="password" name="password" class="form-input @error('password') is-invalid @enderror" placeholder="Enter your password" required>
                                <button type="button" onclick="togglePassword('password')" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #6c757d;" aria-label="Toggle password visibility">
                                    <i class="fas fa-eye" id="password-icon"></i>
                                </button>
                            </div>
                            <p class="invalid-feedback"></p>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Confirm Password</label>
                            <div style="position: relative;">
                                <input type="password" id="confirm_password" name="confirm_password" class="form-input @error('confirm_password') is-invalid @enderror" placeholder="Confirm your password" required>
                                <button type="button" onclick="togglePassword('confirm_password')" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #6c757d;" aria-label="Toggle password visibility">
                                    <i class="fas fa-eye" id="confirm_password-icon"></i>
                                </button>
                            </div>
                            <p class="invalid-feedback"></p>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Designation</label>
                            <input type="text" id="designation" name="designation" class="form-input @error('designation') is-invalid @enderror" placeholder="Enter your designation" value="{{ old('designation') }}">
                            <p class="invalid-feedback"></p>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Mobile</label>
                            <input type="tel" id="mobile" name="mobile" class="form-input @error('mobile') is-invalid @enderror" placeholder="Enter your mobile number" value="{{ old('mobile') }}">
                            <p class="invalid-feedback"></p>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Birthday</label>
                            <input type="date" id="birthday" name="birthday" class="form-input @error('birthday') is-invalid @enderror" value="{{ old('birthday') }}">
                            <p class="invalid-feedback"></p>
                        </div>

                        <button type="submit" class="btn-login">
                            <i class="fas fa-user-plus"></i>
                            Create Account
                        </button>
                    </form>

                    <div class="social-login">
                        <div class="divider">
                            <span>or</span>
                        </div>
                        <div class="social-buttons">
                            <a href="{{ route('social.login', 'google') }}" class="btn-social btn-google">
                                <i class="fab fa-google"></i>
                                Continue with Google
                            </a>
                            <a href="{{ route('social.login', 'facebook') }}" class="btn-social btn-facebook">
                                <i class="fab fa-facebook-f"></i>
                                Continue with Facebook
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customJS')
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

$("#registrationForm").submit(function(e){
    e.preventDefault();
    
    $.ajax({
        url: '{{ route("account.processRegistration") }}',
        type: 'post',
        data: $("#registrationForm").serializeArray(),
        dataType: 'json',
        
        success: function(response){
            if(response.status == false){
                var errors = response.errors;

                if(errors.name){
                    $("#name").addClass('is-invalid')
                    .siblings('p')
                    .addClass('invalid-feedback')
                    .html(errors.name)
                }else{
                    $("#name").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback')
                    .html('')
                }

                if(errors.email){
                    $("#email").addClass('is-invalid')
                    .siblings('p')
                    .addClass('invalid-feedback')
                    .html(errors.email)
                }else{
                    $("#email").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback')
                    .html('')
                }

                if(errors.password){
                    $("#password").addClass('is-invalid')
                    .siblings('p')
                    .addClass('invalid-feedback')
                    .html(errors.password)
                }else{
                    $("#password").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback')
                    .html('')
                }

                if(errors.confirm_password){
                    $("#confirm_password").addClass('is-invalid')
                    .siblings('p')
                    .addClass('invalid-feedback')
                    .html(errors.confirm_password)
                }else{
                    $("#confirm_password").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback')
                    .html('')
                }

                if(errors.designation){
                    $("#designation").addClass('is-invalid')
                    .siblings('p')
                    .addClass('invalid-feedback')
                    .html(errors.designation)
                }else{
                    $("#designation").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback')
                    .html('')
                }

                if(errors.mobile){
                    $("#mobile").addClass('is-invalid')
                    .siblings('p')
                    .addClass('invalid-feedback')
                    .html(errors.mobile)
                }else{
                    $("#mobile").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback')
                    .html('')
                }

                if(errors.birthday){
                    $("#birthday").addClass('is-invalid')
                    .siblings('p')
                    .addClass('invalid-feedback')
                    .html(errors.birthday)
                }else{
                    $("#birthday").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback')
                    .html('')
                }

            } else{
                $("#name").removeClass('is-invalid')
                .siblings('p')
                .addClass('invalid-feedback')
                .html('');

                $("#email").removeClass('is-invalid')
                .siblings('p')
                .addClass('invalid-feedback')
                .html('');

                $("#password").removeClass('is-invalid')
                .siblings('p')
                .removeClass('invalid-feedback')
                .html('')

                $("#confirm_password").removeClass('is-invalid')
                .siblings('p')
                .removeClass('invalid-feedback')
                .html('')

                $("#designation").removeClass('is-invalid')
                .siblings('p')
                .removeClass('invalid-feedback')
                .html('')

                $("#mobile").removeClass('is-invalid')
                .siblings('p')
                .removeClass('invalid-feedback')
                .html('')

                window.location.href = "{{ route('account.login') }}";
            }
        }
    })
})
</script>
@endsection
