@extends('layouts.admin')

@section('title', 'All Feedback')
@section('admin-content')
<div class="card shadow">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-comments me-2"></i>All Feedback
        </h5>
        
        <!-- Filters -->
        <div class="d-flex gap-2">
            <select class="form-select form-select-sm" id="statusFilter">
                <option value="">All Status</option>
                <option value="pending">Pending</option>
                <option value="in_progress">In Progress</option>
                <option value="resolved">Resolved</option>
            </select>
            
            <select class="form-select form-select-sm" id="categoryFilter">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            
            <input type="date" class="form-control form-control-sm" id="dateFilter" placeholder="Filter by date">
        </div>
    </div>
    
    <div class="card-body">
        <!-- Search Box -->
        <div class="row mb-4">
            <div class="col-md-6">
                <form action="{{ route('admin.feedback.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" 
                               placeholder="Search feedback..." value="{{ request('search') }}">
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                        @if(request('search'))
                            <a href="{{ route('admin.feedback.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
            <div class="col-md-6 text-md-end">
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-primary btn-sm dropdown-toggle" 
                            data-bs-toggle="dropdown">
                        <i class="fas fa-download me-1"></i> Export
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-file-pdf me-2"></i>PDF</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-file-excel me-2"></i>Excel</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Feedback Table -->
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead class="table-light">
                    <tr>
                        <th>
                            <input type="checkbox" id="selectAll">
                        </th>
                        <th>Reference</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Submitted By</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Submitted</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($feedbacks as $feedback)
                        <tr>
                            <td>
                                <input type="checkbox" class="feedback-checkbox" value="{{ $feedback->id }}">
                            </td>
                            <td>
                                <span class="badge bg-light text-dark font-monospace">#{{ $feedback->reference_code }}</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.feedback.show', $feedback) }}" 
                                   class="text-decoration-none fw-semibold">
                                    {{ Str::limit($feedback->title, 60) }}
                                </a>
                                @if($feedback->is_anonymous)
                                    <small class="text-muted d-block">
                                        <i class="fas fa-user-secret me-1"></i>Anonymous
                                    </small>
                                @endif
                            </td>
                            <td>
                                <span class="badge rounded-pill bg-secondary">
                                    {{ $feedback->category->name ?? 'Uncategorized' }}
                                </span>
                            </td>
                            <td>
                                @if($feedback->is_anonymous)
                                    <span class="text-muted">Anonymous</span>
                                @else
                                    {{ $feedback->user->name }}
                                @endif
                            </td>
                            <td>
                                <span class="badge @include('components.status-badge', ['status' => $feedback->status])">
                                    {{ ucfirst(str_replace('_', ' ', $feedback->status)) }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $priorityColors = [
                                        'low' => 'success',
                                        'medium' => 'warning',
                                        'high' => 'danger'
                                    ];
                                @endphp
                                <span class="badge bg-{{ $priorityColors[$feedback->priority] ?? 'secondary' }}">
                                    {{ ucfirst($feedback->priority) }}
                                </span>
                            </td>
                            <td>{{ $feedback->created_at->format('M j, Y') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.feedback.show', $feedback) }}" 
                                       class="btn btn-outline-primary" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.feedback.edit', $feedback) }}" 
                                       class="btn btn-outline-secondary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger" 
                                            title="Delete" data-bs-toggle="modal" 
                                            data-bs-target="#deleteModal{{ $feedback->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{ $feedback->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Confirm Delete</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete feedback 
                                                <strong>"{{ $feedback->title }}"</strong>? This action cannot be undone.
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <form action="{{ route('admin.feedback.destroy', $feedback) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <div class="py-4">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No feedback found</h5>
                                    <p class="text-muted">No feedback submissions match your criteria.</p>
                                    @if(request('search') || request('status') || request('category'))
                                        <a href="{{ route('admin.feedback.index') }}" class="btn btn-primary">
                                            Clear Filters
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($feedbacks->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Showing {{ $feedbacks->firstItem() }} to {{ $feedbacks->lastItem() }} of {{ $feedbacks->total() }} entries
                </div>
                <div>
                    {{ $feedbacks->links() }}
                </div>
            </div>
        @endif

        <!-- Bulk Actions -->
        <div class="mt-3 p-3 bg-light rounded d-none" id="bulkActions">
            <div class="d-flex justify-content-between align-items-center">
                <span class="fw-semibold" id="selectedCount">0 feedback selected</span>
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-primary btn-sm" id="bulkStatusBtn">
                        <i class="fas fa-tag me-1"></i> Change Status
                    </button>
                    <button type="button" class="btn btn-outline-danger btn-sm" id="bulkDeleteBtn">
                        <i class="fas fa-trash me-1"></i> Delete Selected
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Bulk selection
    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.feedback-checkbox');
        const bulkActions = document.getElementById('bulkActions');
        const selectedCount = document.getElementById('selectedCount');

        // Select all functionality
        selectAll.addEventListener('change', function() {
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkActions();
        });

        // Individual checkbox functionality
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateBulkActions);
        });

        function updateBulkActions() {
            const selected = document.querySelectorAll('.feedback-checkbox:checked');
            const count = selected.length;
            
            selectedCount.textContent = count + ' feedback selected';
            
            if (count > 0) {
                bulkActions.classList.remove('d-none');
                selectAll.checked = count === checkboxes.length;
            } else {
                bulkActions.classList.add('d-none');
            }
        }

        // Filter functionality
        const statusFilter = document.getElementById('statusFilter');
        const categoryFilter = document.getElementById('categoryFilter');
        const dateFilter = document.getElementById('dateFilter');

        [statusFilter, categoryFilter, dateFilter].forEach(filter => {
            filter?.addEventListener('change', function() {
                applyFilters();
            });
        });

        function applyFilters() {
            const params = new URLSearchParams();
            
            if (statusFilter.value) params.set('status', statusFilter.value);
            if (categoryFilter.value) params.set('category', categoryFilter.value);
            if (dateFilter.value) params.set('date', dateFilter.value);
            if (new URLSearchParams(window.location.search).get('search')) {
                params.set('search', new URLSearchParams(window.location.search).get('search'));
            }
            
            window.location.href = '{{ route('admin.feedback.index') }}?' + params.toString();
        }

        // Set current filter values from URL
        const urlParams = new URLSearchParams(window.location.search);
        if (statusFilter) statusFilter.value = urlParams.get('status') || '';
        if (categoryFilter) categoryFilter.value = urlParams.get('category') || '';
        if (dateFilter) dateFilter.value = urlParams.get('date') || '';
    });
</script>
@endpush
@endsection