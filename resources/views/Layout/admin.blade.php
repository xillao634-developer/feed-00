@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
    <div class="d-block mb-4 mb-md-0">
        <h2 class="h4 fw-bold">
            <i class="fas fa-tachometer-alt me-2"></i>Admin Dashboard
        </h2>
        <p class="mb-0">Welcome back, {{ Auth::user()->name }}!</p>
    </div>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <button type="button" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-download me-1"></i> Export
            </button>
            <button type="button" class="btn btn-sm btn-primary">
                <i class="fas fa-plus me-1"></i> New Feedback
            </button>
        </div>
    </div>
</div>

@yield('admin-content')
@endsection