@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
    <div class="d-block mb-4 mb-md-0">
        <h2 class="h4 fw-bold">
            <i class="fas fa-user me-2"></i>User Dashboard
        </h2>
        <p class="mb-0">Welcome, {{ Auth::user()->name }}!</p>
    </div>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('user.feedback.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus me-1"></i> Submit Feedback
        </a>
    </div>
</div>

@yield('user-content')
@endsection