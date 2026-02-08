@extends('front.layouts.app')

@section('main')
<style>
.forgot-hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    padding: 60px 0;
}
.forgot-card {
    background: white;
    border-radius: 25px;
    box-shadow: 0 25px 50px rgba(0,0,0,0.15);
    padding: 50px;
    max-width: 450px;
    margin: 0 auto;
}
.forgot-header {
    text-align: center;
    margin-bottom: 40px;
}
.forgot-header h2 {
    color: #333;
    font-weight: 700;
    font-size: 2.5rem;
    margin-bottom: 10px;
}
.forgot-header p {
    color: #6c757d;
    font-size: 1rem;
}
.forgot-header a {
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
.btn-forgot {
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
.btn-forgot:hover {
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
</style>

<div class="forgot-hero">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="forgot-card">
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
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif

                    <div class="forgot-header">
                        <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                            <i class="fas fa-key" style="font-size: 2rem; color: white;"></i>
                        </div>
                        <h2>Forgot Password?</h2>
                        <p>No worries! Enter your email and we'll send you a reset link.</p>
                    </div>

                    <form action="{{ route('account.forgot-password.email') }}" method="post">
                        @csrf

                        <div class="form-group">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-input @error('email') is-invalid @enderror" placeholder="Enter your email" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn-forgot">
                            <i class="fas fa-paper-plane"></i>
                            Send Reset Link
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <a href="{{ route('account.login') }}" style="color: #667eea; text-decoration: none; font-weight: 600;">
                            <i class="fas fa-arrow-left"></i> Back to Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
