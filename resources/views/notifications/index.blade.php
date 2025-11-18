@extends('layouts.app')

@section('title', 'Thông báo - AnimeTalk')

@section('content')
<div class="container" style="max-width: 900px; margin-top: 30px;">
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center" style="padding: 1.5rem;">
            <h4 class="mb-0">
                <i class="bi bi-bell"></i>
                Thông báo
            </h4>
            @if($notifications->where('is_read', false)->count() > 0)
                <form method="POST" action="{{ route('notifications.read-all') }}">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-check-all"></i>
                        Đánh dấu tất cả là đã đọc
                    </button>
                </form>
            @endif
        </div>

        <div class="card-body p-0">
            @forelse($notifications as $notification)
                <div class="notification-item {{ !$notification->is_read ? 'unread' : '' }}" 
                     style="padding: 1rem 1.5rem; border-bottom: 1px solid #e9ecef; display: flex; gap: 1rem; align-items: start; {{ !$notification->is_read ? 'background-color: #f0f7ff;' : '' }}">
                    
                    <div style="flex-shrink: 0;">
                        @if($notification->event && $notification->event->cover_image)
                            <img src="{{ asset('storage/' . $notification->event->cover_image) }}" 
                                 alt="Event" 
                                 style="width: 50px; height: 50px; border-radius: 8px; object-fit: cover;">
                        @else
                            <div style="width: 50px; height: 50px; border-radius: 8px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-calendar-event" style="font-size: 24px; color: white;"></i>
                            </div>
                        @endif
                    </div>

                    <div style="flex: 1; min-width: 0;">
                        <div style="display: flex; justify-content: between; align-items: start; gap: 1rem;">
                            <div style="flex: 1;">
                                <p class="mb-1" style="font-weight: {{ !$notification->is_read ? '600' : '400' }}; color: #1a202c;">
                                    {{ $notification->message }}
                                </p>
                                @if($notification->event)
                                    <a href="{{ route('events.show', $notification->event) }}" 
                                       class="text-decoration-none"
                                       style="color: #5b21b6; font-size: 0.9rem;">
                                        <i class="bi bi-calendar-event"></i>
                                        {{ $notification->event->title }}
                                    </a>
                                @endif
                                <p class="mb-0 text-muted" style="font-size: 0.85rem; margin-top: 0.25rem;">
                                    <i class="bi bi-clock"></i>
                                    {{ $notification->created_at->diffForHumans() }}
                                </p>
                            </div>

                            @if(!$notification->is_read)
                                <button onclick="markAsRead({{ $notification->id }})" 
                                        class="btn btn-sm btn-link p-0"
                                        style="color: #5b21b6;"
                                        title="Đánh dấu đã đọc">
                                    <i class="bi bi-check2"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5" style="color: #64748b;">
                    <i class="bi bi-bell-slash" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 1rem;"></i>
                    <p class="mb-0">Bạn chưa có thông báo nào</p>
                </div>
            @endforelse
        </div>

        @if($notifications->hasPages())
            <div class="card-footer bg-white border-top">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
</div>

<script>
function markAsRead(notificationId) {
    fetch(`/notifications/${notificationId}/read`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}
</script>

<style>
.notification-item:hover {
    background-color: #f9fafb !important;
}

.notification-item:last-child {
    border-bottom: none !important;
}
</style>
@endsection
