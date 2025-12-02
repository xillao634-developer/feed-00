@extends('layouts.user')

@section('title', 'My Feedback History')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">My Feedback History</h1>
    <div>
        <a href="{{ route('user.feedback.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> New Feedback
        </a>
    </div>
</div>

<!-- Stats Summary -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3">
                        <div class="p-3">
                            <h3 class="text-primary">{{ $feedback->total() }}</h3>
                            <p class="text-muted mb-0">Total Submitted</p>
                        </div>
                    </div>
                    <div class="col-md-3 border-start">
                        <div class="p-3">
                            <h3 class="text-warning">{{ $feedback->where('status', 'pending')->count() }}</h3>
                            <p class="text-muted mb-0">Pending Review</p>
                        </div>
                    </div>
                    <div class="col-md-3 border-start">
                        <div class="p-3">
                            <h3 class="text-info">{{ $feedback->where('status', 'in_progress')->count() }}</h3>
                            <p class="text-muted mb-0">In Progress</p>
                        </div>
                    </div>
                    <div class="col-md-3 border-start">
                        <div class="p-3">
                            <h3 class="text-success">{{ $feedback->where('status', 'resolved')->count() }}</h3>
                            <p class="text-muted mb-0">Resolved</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Feedback Table -->
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h5 class="card-title mb-0">Recent Feedback Submissions</h5>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search feedback..." id="searchFeedback">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="feedbackTable">
                <thead>
                    <tr>
                        <th>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'title', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}" 
                               class="text-decoration-none text-dark">
                                Title
                                <i class="fas fa-sort ms-1"></i>
                            </a>
                        </th>
                        <th>Category</th>
                        <th>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'status', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}" 
                               class="text-decoration-none text-dark">
                                Status
                                <i class="fas fa-sort ms-1"></i>
                            </a>
                        </th>
                        <th>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}" 
                               class="text-decoration-none text-dark">
                                Submitted
                                <i class="fas fa-sort ms-1"></i>
                            </a>
                        </th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($feedback as $item)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar-circle bg-light text-dark">
                                            <i class="fas fa-comment"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">{{ Str::limit($item->title, 40) }}</h6>
                                        <small class="text-muted">{{ $item->reference_code }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark">
                                    {{ $item->category->name }}
                                </span>
                            </td>
                            <td>
                                @include('components.status-badge', ['status' => $item->status])
                            </td>
                            <td>
                                <small>{{ $item->created_at->format('M d, Y') }}</small>
                                <br>
                                <small class="text-muted">{{ $item->created_at->diffForHumans() }}</small>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('user.feedback.show', $item) }}" 
                                       class="btn btn-sm btn-outline-primary" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($item->status === 'pending')
                                        <form action="{{ route('user.feedback.destroy', $item) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                    onclick="return confirm('Delete this feedback?')"
                                                    title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3"></i>
                                    <h5>No feedback submitted yet</h5>
                                    <p>Start by submitting your first feedback</p>
                                    <a href="{{ route('user.feedback.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i> Submit Feedback
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($feedback->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Showing {{ $feedback->firstItem() }} to {{ $feedback->lastItem() }} of {{ $feedback->total() }} entries
                </div>
                <nav>
                    {{ $feedback->links() }}
                </nav>
            </div>
        @endif
    </div>
</div>

<!-- Export Options -->
<div class="card mt-4">
    <div class="card-header">
        <h5 class="card-title mb-0">Export Options</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="card border-primary">
                    <div class="card-body text-center">
                        <i class="fas fa-file-pdf fa-2x text-danger mb-3"></i>
                        <h6>Export as PDF</h6>
                        <p class="text-muted small">Download your feedback history as PDF</p>
                        <button class="btn btn-outline-danger w-100" id="exportPdf">
                            <i class="fas fa-download me-2"></i> Export PDF
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-primary">
                    <div class="card-body text-center">
                        <i class="fas fa-file-excel fa-2x text-success mb-3"></i>
                        <h6>Export as Excel</h6>
                        <p class="text-muted small">Download your feedback history as Excel</p>
                        <button class="btn btn-outline-success w-100" id="exportExcel">
                            <i class="fas fa-download me-2"></i> Export Excel
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-primary">
                    <div class="card-body text-center">
                        <i class="fas fa-print fa-2x text-primary mb-3"></i>
                        <h6>Print Report</h6>
                        <p class="text-muted small">Print your feedback summary</p>
                        <button class="btn btn-outline-primary w-100" onclick="window.print()">
                            <i class="fas fa-print me-2"></i> Print Report
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .avatar-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
    
    #feedbackTable tbody tr {
        transition: background-color 0.2s;
    }
    
    #feedbackTable tbody tr:hover {
        background-color: #f8f9fa;
        cursor: pointer;
    }
    
    #feedbackTable tbody tr td:first-child {
        border-left: 4px solid transparent;
    }
    
    #feedbackTable tbody tr:hover td:first-child {
        border-left-color: #3498db;
    }
</style>
@endpush

@push('scripts')
<script>
    // Search functionality
    document.getElementById('searchFeedback').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('#feedbackTable tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });

    // Row click to view details
    document.querySelectorAll('#feedbackTable tbody tr').forEach(row => {
        row.addEventListener('click', function(e) {
            // Don't trigger if clicking on buttons or links
            if (!e.target.closest('a') && !e.target.closest('button')) {
                const viewLink = this.querySelector('a[title="View"]');
                if (viewLink) {
                    viewLink.click();
                }
            }
        });
    });

    // Export buttons
    document.getElementById('exportPdf').addEventListener('click', function() {
        alert('PDF export functionality would be implemented here');
        // In actual implementation, this would make an AJAX call to export endpoint
    });

    document.getElementById('exportExcel').addEventListener('click', function() {
        alert('Excel export functionality would be implemented here');
        // In actual implementation, this would make an AJAX call to export endpoint
    });
</script>
@endpush
@endsection