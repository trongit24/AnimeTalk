@extends('layouts.app')

@section('title', 'Event Notifications - ' . $event->title)

@section('content')
<div style="min-height: 100vh; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 2rem 0;">
    <div class="container" style="max-width: 900px; margin: 0 auto;">
        <!-- Header -->
        <div style="background: white; border-radius: 16px; padding: 2rem; margin-bottom: 2rem; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                <a href="{{ route('events.show', $event->slug) }}" style="color: #5BA3D0; text-decoration: none;">
                    <i class="bi bi-arrow-left" style="font-size: 1.5rem;"></i>
                </a>
                <div>
                    <h1 style="margin: 0; color: #2c3e50; font-size: 1.75rem;">Thông báo Sự kiện</h1>
                    <p style="margin: 0.25rem 0 0 0; color: #666;">{{ $event->title }}</p>
                </div>
            </div>
        </div>

        <!-- Notifications List -->
        @if($notifications->count() > 0)
            <div style="background: white; border-radius: 16px; padding: 1.5rem; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
                @foreach($notifications as $notification)
                    <div style="padding: 1.25rem; border-bottom: 1px solid #f0f0f0; display: flex; align-items: start; gap: 1rem; {{ !$notification->is_read ? 'background: #f0f7ff;' : '' }} border-radius: 8px; margin-bottom: 0.5rem;">
                        <!-- Icon based on type -->
                        <div style="flex-shrink: 0;">
                            @if($notification->type === 'event_invitation')
                                <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-envelope" style="color: white; font-size: 1.25rem;"></i>
                                </div>
                            @elseif($notification->type === 'event_reminder')
                                <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #f093fb, #f5576c); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-bell" style="color: white; font-size: 1.25rem;"></i>
                                </div>
                            @elseif($notification->type === 'event_update')
                                <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #4facfe, #00f2fe); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-pencil" style="color: white; font-size: 1.25rem;"></i>
                                </div>
                            @else
                                <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #43e97b, #38f9d7); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-person-check" style="color: white; font-size: 1.25rem;"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Content -->
                        <div style="flex: 1;">
                            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.5rem;">
                                <div>
                                    <span style="font-size: 0.85rem; color: #999; display: block; margin-bottom: 0.25rem;">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </span>
                                    @if(!$notification->is_read)
                                        <span style="display: inline-block; padding: 0.25rem 0.5rem; background: #667eea; color: white; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">
                                            Mới
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <p style="margin: 0; color: #2c3e50; line-height: 1.5;">
                                {{ $notification->message }}
                            </p>

                            @if(!$notification->is_read)
                                <form action="{{ route('events.notifications.read', $notification->id) }}" method="POST" style="margin-top: 0.75rem;">
                                    @csrf
                                    <button type="submit" style="padding: 0.5rem 1rem; background: #5BA3D0; color: white; border: none; border-radius: 6px; font-size: 0.875rem; cursor: pointer; font-weight: 600;">
                                        <i class="bi bi-check"></i> Đánh dấu đã đọc
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach

                <!-- Pagination -->
                @if($notifications->hasPages())
                    <div style="margin-top: 2rem; display: flex; justify-content: center;">
                        {{ $notifications->links() }}
                    </div>
                @endif
            </div>
        @else
            <!-- Empty State -->
            <div style="background: white; border-radius: 16px; padding: 4rem 2rem; text-align: center; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
                <i class="bi bi-bell-slash" style="font-size: 4rem; color: #ddd; display: block; margin-bottom: 1rem;"></i>
                <h3 style="color: #666; margin-bottom: 0.5rem;">Chưa có thông báo</h3>
                <p style="color: #999;">Bạn chưa có thông báo nào cho sự kiện này</p>
            </div>
        @endif
    </div>
</div>
@endsection
