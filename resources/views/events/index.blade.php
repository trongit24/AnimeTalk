@extends('layouts.app')

@section('title', 'Events - AnimeTalk')

@section('content')
<div style="background: #F0F2F5; min-height: calc(100vh - 60px); padding: 2rem 0;">
    <div style="max-width: 1200px; margin: 0 auto; padding: 0 1rem;">
        <!-- Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <div>
                <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.75rem;">
                    <i class="bi bi-calendar-event" style="color: #5BA3D0;"></i>
                    Events
                </h1>
                <p style="color: #666;">Discover and join community events</p>
            </div>
            @auth
            <a href="{{ route('events.create') }}" 
               style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; border-radius: 8px; text-decoration: none; font-weight: 600;">
                <i class="bi bi-plus-circle"></i>
                Create Event
            </a>
            @endauth
        </div>

        <!-- Filters -->
        <div style="background: white; border-radius: 12px; padding: 1rem; margin-bottom: 1.5rem; border: 1px solid #e0e0e0;">
            <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                <a href="{{ route('events.index') }}" 
                   style="padding: 0.5rem 1rem; background: {{ !request('filter') ? 'linear-gradient(135deg, #5BA3D0, #9B7EDE)' : '#f0f0f0' }}; color: {{ !request('filter') ? 'white' : '#333' }}; border-radius: 20px; text-decoration: none; font-weight: 600; font-size: 0.9rem;">
                    Upcoming
                </a>
                <a href="{{ route('events.index', ['filter' => 'past']) }}" 
                   style="padding: 0.5rem 1rem; background: {{ request('filter') === 'past' ? 'linear-gradient(135deg, #5BA3D0, #9B7EDE)' : '#f0f0f0' }}; color: {{ request('filter') === 'past' ? 'white' : '#333' }}; border-radius: 20px; text-decoration: none; font-weight: 600; font-size: 0.9rem;">
                    Past Events
                </a>
                @auth
                <a href="{{ route('events.index', ['filter' => 'joined']) }}" 
                   style="padding: 0.5rem 1rem; background: {{ request('filter') === 'joined' ? 'linear-gradient(135deg, #5BA3D0, #9B7EDE)' : '#f0f0f0' }}; color: {{ request('filter') === 'joined' ? 'white' : '#333' }}; border-radius: 20px; text-decoration: none; font-weight: 600; font-size: 0.9rem;">
                    My Events
                </a>
                <a href="{{ route('events.index', ['filter' => 'my-events']) }}" 
                   style="padding: 0.5rem 1rem; background: {{ request('filter') === 'my-events' ? 'linear-gradient(135deg, #5BA3D0, #9B7EDE)' : '#f0f0f0' }}; color: {{ request('filter') === 'my-events' ? 'white' : '#333' }}; border-radius: 20px; text-decoration: none; font-weight: 600; font-size: 0.9rem;">
                    Created by Me
                </a>
                @endauth
            </div>
        </div>

        <!-- Events Grid -->
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
            @forelse($events as $event)
            <a href="{{ route('events.show', $event->id) }}" style="text-decoration: none; color: inherit;">
                <div style="background: white; border-radius: 12px; overflow: hidden; border: 1px solid #e0e0e0; transition: all 0.3s; cursor: pointer;" class="event-card">
                    <!-- Cover Image -->
                    @if($event->cover_image)
                    <img src="{{ asset('storage/' . $event->cover_image) }}" alt="{{ $event->title }}" 
                         style="width: 100%; height: 180px; object-fit: cover;">
                    @else
                    <div style="width: 100%; height: 180px; background: linear-gradient(135deg, #5BA3D0, #9B7EDE);"></div>
                    @endif

                    <!-- Event Info -->
                    <div style="padding: 1.25rem;">
                        <!-- Date Badge -->
                        <div style="display: inline-block; background: rgba(91, 163, 208, 0.1); color: #5BA3D0; padding: 0.375rem 0.75rem; border-radius: 6px; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.75rem;">
                            <i class="bi bi-calendar3"></i>
                            {{ $event->start_time->format('M d, Y') }} • {{ $event->start_time->format('g:i A') }}
                        </div>

                        <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem; line-height: 1.3;">
                            {{ $event->title }}
                        </h3>

                        @if($event->location)
                        <p style="color: #666; font-size: 0.9rem; margin-bottom: 0.75rem; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="bi bi-geo-alt-fill" style="color: #FF6B6B;"></i>
                            {{ Str::limit($event->location, 40) }}
                        </p>
                        @endif

                        <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 0.75rem; border-top: 1px solid #f0f0f0;">
                            <div style="display: flex; align-items: center; gap: 0.5rem; color: #666; font-size: 0.9rem;">
                                <i class="bi bi-people-fill"></i>
                                <span>{{ $event->participants_count }} going</span>
                            </div>
                            @if($event->privacy !== 'public')
                            <span style="background: rgba(155, 126, 222, 0.1); color: #9B7EDE; padding: 0.25rem 0.625rem; border-radius: 12px; font-size: 0.8rem; font-weight: 600;">
                                <i class="bi bi-lock-fill"></i> {{ ucfirst($event->privacy) }}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </a>
            @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 4rem 2rem; color: #999;">
                <i class="bi bi-calendar-x" style="font-size: 4rem; display: block; margin-bottom: 1rem; color: #ddd;"></i>
                <p style="font-size: 1.1rem;">No events found</p>
                @auth
                <a href="{{ route('events.create') }}" 
                   style="display: inline-block; margin-top: 1rem; padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; border-radius: 8px; text-decoration: none; font-weight: 600;">
                    Create the First Event
                </a>
                @endauth
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($events->hasPages())
        <div style="margin-top: 2rem;">
            {{ $events->links() }}
        </div>
        @endif
    </div>
</div>

<style>
.event-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    border-color: #5BA3D0;
}
</style>
@endsection
