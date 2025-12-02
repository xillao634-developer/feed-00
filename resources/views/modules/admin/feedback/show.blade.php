@extends('layouts.admin')

@section('title', 'Feedback Details')
@section('admin-content')
<div class="row">
    <div class="col-lg-8">
        <!-- Feedback Details Card -->
        <div class="card shadow mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-comment-dots me-2"></i>Feedback Details
                </h5>
                <div class="btn-group">
                    <a href="{{ route('admin.feedback.edit', $feedback) }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <a href="{{ route('admin.feedback.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Back
                    </a>
                </div>
            </div>
            <div class="card-body">
                <!-- Reference & Status -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <strong>Reference Code:</strong>
                        <span class="badge bg-light text-dark font-monospace">#{{ $feedback->reference_code }}</span>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <strong>Status:</strong>
                        <span class="badge @include('components.status-badge', ['status' => $feedback->status]) fs-6">
                            {{ ucfirst(str_replace('_', ' ', $feedback->status)) }}
                        </span>
                    </div>
                </div>

                <!-- Feedback Content -->
                <div class="mb-4">
                    <h4 class="text-primary">{{ $feedback->title }}</h4>
                    <div class="bg-light p-3 rounded mt-3">
                        <p class="mb-0">{{ $feedback->description }}</p>
                    </div>
                </div>

                <!-- Meta Information -->
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td><strong>Category:</strong></td>
                                <td>
                                    <span class="badge bg-secondary">
                                        {{ $feedback->category->name ?? 'Uncategorized' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Priority:</strong></td>
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
                            </tr>
                            <tr>
                                <td><strong>Submitted:</strong></td>
                                <td>{{ $feedback->created_at->format('F j, Y \a\t g:i A') }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td><strong>Submitted By:</strong></td>
                                <td>
                                    @if($feedback->is_anonymous)
                                        <span class="text-muted">
                                            <i class="fas fa-user-secret me-1"></i>Anonymous User
                                        </span>
                                    @else
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-2">
                                                <span class="text-white fw-bold">
                                                    {{ substr($feedback->user->name, 0, 1) }}
                                                </span>
                                            </div>
                                            <div>
                                                <div>{{ $feedback->user->name }}</div>
                                                <small class="text-muted">{{ $feedback->user->email }}</small>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Last Updated:</strong></td>
                                <td>{{ $feedback->updated_at->format('F j, Y \a\t g:i A') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Assigned To:</strong></td>
                                <td>
                                    @if($feedback->assignedTo)
                                        <span class="badge bg-info">{{ $feedback->assignedTo->name }}</span>
                                    @else
                                        <span class="text-muted">Not assigned</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Attachments -->
                @if($feedback->attachments && count($feedback->attachments) > 0)
                    <div class="mt-4">
                        <h6 class="border-bottom pb-2">
                            <i class="fas fa-paperclip me-2"></i>Attachments
                        </h6>
                        <div class="d-flex flex-wrap gap-2 mt-2">
                            @foreach($feedback->attachments as $attachment)
                                <div class="attachment-item border rounded p-2">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-file me-2 text-muted"></i>
                                        <div>
                                            <small class="d-block">{{ $attachment->file_name }}</small>
                                            <small class="text-muted">{{ $attachment->file_size }}</small>
                                        </div>
                                        <a href="{{ Storage::url($attachment->file_path) }}" 
                                           target="_blank" class="btn btn-sm btn-outline-primary ms-2">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Comments Section -->
        <div class="card shadow">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0">
                    <i class="fas fa-comments me-2"></i>Internal Comments
                    <span class="badge bg-primary rounded-pill">{{ $feedback->comments->count() }}</span>
                </h6>
            </div>
            <div class="card-body">
                <!-- Comment Form -->
                <form action="{{ route('admin.feedback.comment', $feedback) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="comment" class="form-label">Add Internal Comment</label>
                        <textarea class="form-control" id="comment" name="comment" rows="3" 
                                  placeholder="Add an internal comment..." required></textarea>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_private" id="is_private">
                            <label class="form-check-label" for="is_private">
                                Private comment (visible only to admins)
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-1"></i> Post Comment
                        </button>
                    </div>
                </form>

                <!-- Comments List -->
                <div class="mt-4">
                    @forelse($feedback->comments->sortByDesc('created_at') as $comment)
                        <div class="comment-item border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-2">
                                        <span class="text-white fw-bold small">
                                            {{ substr($comment->user->name, 0, 1) }}
                                        </span>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $comment->user->name }}</div>
                                        <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                                @if($comment->is_private)
                                    <span class="badge bg-warning">
                                        <i class="fas fa-lock me-1"></i>Private
                                    </span>
                                @endif
                            </div>
                            <p class="mb-0">{{ $comment->content }}</p>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-comments fa-2x mb-3"></i>
                            <p>No comments yet. Be the first to add a comment.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Actions Card -->
        <div class="card shadow mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0">
                    <i class="fas fa-cogs me-2"></i>Quick Actions
                </h6>
            </div>
            <div class="card-body">
                <!-- Status Update -->
                <form action="{{ route('admin.feedback.update-status', $feedback) }}" method="POST" class="mb-3">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <label for="status" class="form-label">Update Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="pending" {{ $feedback->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" {{ $feedback->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="resolved" {{ $feedback->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                            <option value="closed" {{ $feedback->status == 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-sync me-1"></i> Update Status
                    </button>
                </form>

                <!-- Assignment -->
                <form action="{{ route('admin.feedback.assign', $feedback) }}" method="POST" class="mb-3">
                    @csrf
                    <div class="mb-3">
                        <label for="assigned_to" class="form-label">Assign To</label>
                        <select class="form-select" id="assigned_to" name="assigned_to">
                            <option value="">Not Assigned</option>
                            @foreach($departmentHeads as $user)
                                <option value="{{ $user->id }}" 
                                    {{ $feedback->assigned_to == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->department->name ?? 'No Department' }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-outline-primary w-100">
                        <i class="fas fa-user-check me-1"></i> Assign
                    </button>
                </form>

                <!-- Priority Update -->
                <form action="{{ route('admin.feedback.update-priority', $feedback) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <label for="priority" class="form-label">Update Priority</label>
                        <select class="form-select" id="priority" name="priority" required>
                            <option value="low" {{ $feedback->priority == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ $feedback->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ $feedback->priority == 'high' ? 'selected' : '' }}>High</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-outline-warning w-100">
                        <i class="fas fa-exclamation-circle me-1"></i> Update Priority
                    </button>
                </form>

                <!-- Quick Links -->
                <hr>
                <div class="d-grid gap-2">
                    <a href="mailto:{{ $feedback->user->email ?? '#' }}" 
                       class="btn btn-outline-info btn-sm" 
                       {{ $feedback->is_anonymous ? 'disabled' : '' }}>
                        <i class="fas fa-envelope me-1"></i> Email User
                    </a>
                    <button type="button" class="btn btn-outline-success btn-sm" onclick="generateResponse()">
                        <i class="fas fa-reply me-1"></i> Generate Response
                    </button>
                </div>
            </div>
        </div>

        <!-- Activity Log -->
        <div class="card shadow">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0">
                    <i class="fas fa-history me-2"></i>Activity Log
                </h6>
            </div>
            <div class="card-body">
                <div class="activity-timeline">
                    @forelse($feedback->activities->sortByDesc('created_at')->take(5) as $activity)
                        <div class="activity-item mb-3">
                            <div class="d-flex">
                                <div class="activity-icon me-3">
                                    <i class="fas fa-circle text-primary small"></i>
                                </div>
                                <div class="activity-content flex-grow-1">
                                    <p class="mb-1 small">{{ $activity->description }}</p>
                                    <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-3">
                            <i class="fas fa-info-circle me-1"></i>
                            No activity recorded yet.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function generateResponse() {
        const status = document.getElementById('status').value;
        const title = "{{ $feedback->title }}";
        
        let response = `Regarding your feedback "${title}", `;
        
        switch(status) {
            case 'pending':
                response += "we have received your feedback and it is currently under review.";
                break;
            case 'in_progress':
                response += "our team is currently working on addressing your concerns.";
                break;
            case 'resolved':
                response += "we're pleased to inform you that your feedback has been resolved.";
                break;
            case 'closed':
                response += "this feedback has been closed. Thank you for your input.";
                break;
        }
        
        // Copy to clipboard
        navigator.clipboard.writeText(response).then(() => {
            alert('Response template copied to clipboard!');
        });
    }
</script>
@endpush
@endsection