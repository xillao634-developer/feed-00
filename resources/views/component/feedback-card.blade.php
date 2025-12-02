@props(['feedback'])

<div class="card shadow-sm mb-3">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start mb-2">
            <h6 class="card-title mb-0">
                <a href="#" class="text-decoration-none">{{ $feedback->title }}</a>
            </h6>
            <span class="badge @include('components.status-badge', ['status' => $feedback->status])">
                {{ ucfirst($feedback->status) }}
            </span>
        </div>
        
        <p class="card-text text-muted small mb-2">{{ Str::limit($feedback->description, 150) }}</p>
        
        <div class="d-flex justify-content-between align-items-center">
            <small class="text-muted">
                <i class="fas fa-tag me-1"></i>{{ $feedback->category->name ?? 'Uncategorized' }}
            </small>
            <small class="text-muted">
                <i class="fas fa-clock me-1"></i>{{ $feedback->created_at->diffForHumans() }}
            </small>
        </div>
        
        @if($feedback->is_anonymous)
            <small class="text-muted"><i class="fas fa-user-secret me-1"></i>Anonymous</small>
        @else
            <small class="text-muted"><i class="fas fa-user me-1"></i>{{ $feedback->user->name }}</small>
        @endif
    </div>
</div>