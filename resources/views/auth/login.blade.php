@extends('layouts.auth')

@section('title', 'Login')
@section('subtitle', 'Sign in to your account')

@section('content')
<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
               name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
               name="password" required autocomplete="current-password">
        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="mb-3 form-check">
        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
        <label class="form-check-label" for="remember">Remember Me</label>
    </div>

    <div class="d-grid gap-2">
        <button type="submit" class="btn btn-primary btn-lg">
            <i class="fas fa-sign-in-alt me-2"></i> Sign In
        </button>
    </div>

    <div class="text-center mt-3">
        @if (Route::has('password.request'))
            <a class="text-decoration-none" href="{{ route('password.request') }}">
                Forgot Your Password?
            </a>
        @endif
    </div>

    <div class="text-center mt-3">
        <p class="mb-0">Don't have an account? 
            <a href="{{ route('register') }}" class="text-decoration-none">Sign up</a>
        </p>
    </div>
</form>
@endsection