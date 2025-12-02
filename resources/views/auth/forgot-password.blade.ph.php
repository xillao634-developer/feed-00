@extends('layouts.auth')

@section('title', 'Forgot Password')
@section('subtitle', 'Reset your password')

@section('content')
@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif

<form method="POST" action="{{ route('password.email') }}">
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

    <div class="d-grid gap-2">
        <button type="submit" class="btn btn-primary btn-lg">
            <i class="fas fa-paper-plane me-2"></i> Send Reset Link
        </button>
    </div>

    <div class="text-center mt-3">
        <a href="{{ route('login') }}" class="text-decoration-none">
            <i class="fas fa-arrow-left me-1"></i> Back to Login
        </a>
    </div>
</form>
@endsection