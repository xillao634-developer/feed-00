@props(['notification'])

<div class="notification-item p-3 border-bottom {{ $notification->unread() ? 'bg-light' : '' }}">
    <div class="d-flex justify-content-between align-items-start">
        <div class="flex-grow-1">
            <p class="mb-1">{{ $notification->data['message'] }}</p>
            <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
        </div>
        @if($notification->unread())
            <span class="badge bg-primary ms-2">New</span>
        @endif
    </div>
</div>