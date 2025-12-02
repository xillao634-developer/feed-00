@extends('layouts.admin')

@section('admin-content')
<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Feedback
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalFeedback }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-comments fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Resolved
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $resolvedFeedback }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Pending
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingFeedback }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            In Progress
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $inProgressFeedback }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-spinner fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row mb-4">
    <div class="col-md-6">
        @include('components.charts.category-chart', ['data' => $categoryData])
    </div>
    <div class="col-md-6">
        @include('components.charts.status-chart', ['data' => $statusData])
    </div>
</div>

<!-- Recent Feedback -->
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header bg-white py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-history me-2"></i>Recent Feedback
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Reference</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Submitted</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentFeedback as $feedback)
                                <tr>
                                    <td>
                                        <span class="badge bg-light text-dark">#{{ $feedback->reference_code }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.feedback.show', $feedback) }}" class="text-decoration-none">
                                            {{ Str::limit($feedback->title, 50) }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $feedback->category->name ?? 'Uncategorized' }}</span>
                                    </td>
                                    <td>
                                        <span class="badge @include('components.status-badge', ['status' => $feedback->status])">
                                            {{ ucfirst(str_replace('_', ' ', $feedback->status)) }}
                                        </span>
                                    </td>
                                    <td>{{ $feedback->created_at->diffForHumans() }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.feedback.show', $feedback) }}" 
                                               class="btn btn-outline-primary" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.feedback.edit', $feedback) }}" 
                                               class="btn btn-outline-secondary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <i class="fas fa-inbox fa-2x text-muted mb-3"></i>
                                        <p class="text-muted">No feedback submitted yet.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($recentFeedback->hasPages())
                    <div class="d-flex justify-content-center mt-3">
                        {{ $recentFeedback->links() }}
                    </div>
                @endif
                
                <div class="text-center mt-3">
                    <a href="{{ route('admin.feedback.index') }}" class="btn btn-primary">
                        <i class="fas fa-list me-1"></i> View All Feedback
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection