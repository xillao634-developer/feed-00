@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
    <div class="d-block mb-4 mb-md-0">
        <h2 class="h4 fw-bold">
            <i class="fas fa-building me-2"></i>Department Dashboard
        </h2>
        <p class="mb-0">Department Head: {{ Auth::user()->name }}</p>
    </div>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <button type="button" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-chart-bar me-1"></i> Reports
            </button>
        </div>
    </div>
</div>

@yield('department-content')
@endsection