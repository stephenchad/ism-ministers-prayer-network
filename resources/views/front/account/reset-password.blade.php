@extends('front.layouts.app')

@section('main')
<div class="container mt-5">
    <h2>Reset Password</h2>
    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="form-group">
            <label for="email">Email Address</label>
            <input id="email" type="email" class="form-input @error('email') is-invalid @enderror" name="email" value="{{ old('email', $request->email) }}" required autofocus>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input id="password" type="password" class="form-input @error('password') is-invalid @enderror" name="password" required>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input id="password_confirmation" type="password" class="form-input" name="password_confirmation" required>
        </div>

        <button type="submit" class="btn-login mt-3">Reset Password</button>
    </form>
</div>
@endsection
