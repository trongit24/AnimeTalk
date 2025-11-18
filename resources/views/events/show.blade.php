@extends('layouts.app')

@section('title', $event->title . ' - AnimeTalk')

@section('content')
<div style="background: #F0F2F5; min-height: calc(100vh - 60px);">
    <!-- Cover Image -->
    <div style="width: 100%; height: 400px; background: {{ $event->cover_image ? 'url(' . asset('storage/' . $event->cover_image) . ')' : 'linear-gradient(135deg, #5BA3D0, #9B7EDE)' }}; background-size: cover; background-position: center; position: relative;">
        @if(!$event->cover_image)
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; color: white;">
            <i class="bi bi-calendar-event" style="font-size: 5rem; opacity: 0.3;"></i>
        </div>
        @endif
    </div>

    <div style="max-width: 1200px; margin: -100px auto 0; padding: 0 1rem; position: relative;">
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
            <!-- Main Content -->
            <div>
                <!-- Event Header Card -->
                <div style="background: white; border-radius: 12px; padding: 2rem; border: 1px solid #e0e0e0; margin-bottom: 1.5rem;">
                    <h1 style="font-size: 2.25rem; font-weight: 700; margin-bottom: 1rem;">{{ $event->title }}</h1>
                    
                    <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; margin-bottom: 1.5rem;">
                        <div style="display: flex; align-items: center; gap: 0.75rem; color: #666;">
                            <div style="width: 40px; height: 40px; background: rgba(91, 163, 208, 0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-calendar3" style="font-size: 1.25rem; color: #5BA3D0;"></i>
                            </div>
                            <div>
                                <div style="font-size: 0.85rem; color: #999; text-transform: uppercase; font-weight: 600;">Date</div>
                                <div style="font-weight: 600;">{{ $event->start_time->format('F j, Y') }}</div>
                            </div>
                        </div>

                        <div style="display: flex; align-items: center; gap: 0.75rem; color: #666;">
                            <div style="width: 40px; height: 40px; background: rgba(155, 126, 222, 0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-clock" style="font-size: 1.25rem; color: #9B7EDE;"></i>
                            </div>
                            <div>
                                <div style="font-size: 0.85rem; color: #999; text-transform: uppercase; font-weight: 600;">Time</div>
                                <div style="font-weight: 600;">{{ $event->start_time->format('g:i A') }}
                                @if($event->end_time)
                                    - {{ $event->end_time->format('g:i A') }}
                                @endif
                                </div>
                            </div>
                        </div>

                        @if($event->location)
                        <div style="display: flex; align-items: center; gap: 0.75rem; color: #666;">
                            <div style="width: 40px; height: 40px; background: rgba(255, 107, 107, 0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-geo-alt-fill" style="font-size: 1.25rem; color: #FF6B6B;"></i>
                            </div>
                            <div>
                                <div style="font-size: 0.85rem; color: #999; text-transform: uppercase; font-weight: 600;">Location</div>
                                <div style="font-weight: 600;">{{ $event->location }}</div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Host Info -->
                    <div style="display: flex; align-items: center; gap: 1rem; padding: 1rem; background: #f9f9f9; border-radius: 8px; margin-bottom: 1.5rem;">
                        @if($event->owner->profile_photo)
                        <img src="{{ asset('storage/' . $event->owner->profile_photo) }}" alt="{{ $event->owner->name }}" 
                             style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                        @else
                        <div style="width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.25rem;">
                            {{ strtoupper(substr($event->owner->name, 0, 1)) }}
                        </div>
                        @endif
                        <div style="flex: 1;">
                            <div style="font-size: 0.85rem; color: #999;">Hosted by</div>
                            <a href="{{ route('profile.show', $event->owner->uid) }}" style="font-weight: 600; font-size: 1.05rem; color: #333; text-decoration: none;">
                                {{ $event->owner->name }}
                            </a>
                        </div>
                        @auth
                        @if($event->isOwner(auth()->user()))
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('events.edit', $event->id) }}" 
                               style="padding: 0.5rem 1rem; background: #5BA3D0; color: white; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 0.9rem;">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Delete this event?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="padding: 0.5rem 1rem; background: #FF6B6B; color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 0.9rem;">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                        @endif
                        @endauth
                    </div>

                    <!-- Action Buttons -->
                    @auth
                    @if(!$event->isOwner(auth()->user()))
                    <div style="display: flex; gap: 1rem;">
                        <form action="{{ route('events.respond', $event->id) }}" method="POST" style="flex: 1;">
                            @csrf
                            <input type="hidden" name="status" value="going">
                            <button type="submit" 
                                    style="width: 100%; padding: 0.875rem; background: {{ $event->getParticipantStatus(auth()->user()) === 'going' ? '#28a745' : 'linear-gradient(135deg, #5BA3D0, #9B7EDE)' }}; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 1rem;">
                                <i class="bi bi-check-circle-fill"></i> 
                                {{ $event->getParticipantStatus(auth()->user()) === 'going' ? 'Going' : 'Join Event' }}
                            </button>
                        </form>
                        <form action="{{ route('events.respond', $event->id) }}" method="POST" style="flex: 1;">
                            @csrf
                            <input type="hidden" name="status" value="interested">
                            <button type="submit" 
                                    style="width: 100%; padding: 0.875rem; background: {{ $event->getParticipantStatus(auth()->user()) === 'interested' ? '#ffc107' : '#f0f0f0' }}; color: {{ $event->getParticipantStatus(auth()->user()) === 'interested' ? 'white' : '#333' }}; border: 1px solid #e0e0e0; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 1rem;">
                                <i class="bi bi-star"></i> 
                                {{ $event->getParticipantStatus(auth()->user()) === 'interested' ? 'Interested' : 'Interested' }}
                            </button>
                        </form>
                    </div>
                    @endif
                    @else
                    <a href="{{ route('login') }}" 
                       style="display: block; text-align: center; padding: 0.875rem; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 1rem;">
                        Login to Join Event
                    </a>
                    @endauth
                </div>

                <!-- Description -->
                @if($event->description)
                <div style="background: white; border-radius: 12px; padding: 2rem; border: 1px solid #e0e0e0; margin-bottom: 1.5rem;">
                    <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem;">About This Event</h2>
                    <p style="color: #555; line-height: 1.8; white-space: pre-wrap;">{{ $event->description }}</p>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div>
                <!-- Stats Card -->
                <div style="background: white; border-radius: 12px; padding: 1.5rem; border: 1px solid #e0e0e0; margin-bottom: 1.5rem; position: sticky; top: 80px;">
                    <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1rem;">Event Stats</h3>
                    
                    <div style="padding: 1rem; background: rgba(91, 163, 208, 0.1); border-radius: 8px; margin-bottom: 1rem; text-align: center;">
                        <div style="font-size: 2rem; font-weight: 700; color: #5BA3D0;">{{ $event->participants_count }}</div>
                        <div style="color: #666; font-size: 0.9rem;">People Going</div>
                    </div>

                    @if($interestedUsers->count() > 0)
                    <div style="padding: 1rem; background: rgba(255, 193, 7, 0.1); border-radius: 8px; margin-bottom: 1rem; text-align: center;">
                        <div style="font-size: 1.5rem; font-weight: 700; color: #ffc107;">{{ $interestedUsers->count() }}</div>
                        <div style="color: #666; font-size: 0.9rem;">Interested</div>
                    </div>
                    @endif

                    <!-- Privacy Badge -->
                    <div style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 0.75rem; background: #f9f9f9; border-radius: 8px; margin-top: 1rem;">
                        <i class="bi bi-{{ $event->privacy === 'public' ? 'globe' : 'lock' }}"></i>
                        <span style="font-weight: 600; text-transform: capitalize;">{{ $event->privacy }} Event</span>
                    </div>
                </div>

                <!-- Participants -->
                <div style="background: white; border-radius: 12px; padding: 1.5rem; border: 1px solid #e0e0e0;">
                    <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1rem;">
                        Going ({{ $goingUsers->count() }})
                    </h3>
                    <div style="max-height: 400px; overflow-y: auto;">
                        @forelse($goingUsers->take(10) as $user)
                        <div style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 0; border-bottom: 1px solid #f0f0f0;">
                            @if($user->profile_photo)
                            <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="{{ $user->name }}" 
                                 style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                            @else
                            <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            @endif
                            <div style="flex: 1; min-width: 0;">
                                <a href="{{ route('profile.show', $user->uid) }}" style="font-weight: 600; font-size: 0.9rem; color: #333; text-decoration: none; display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $user->name }}
                                </a>
                            </div>
                        </div>
                        @empty
                        <p style="color: #999; text-align: center; padding: 1rem;">No participants yet</p>
                        @endforelse

                        @if($goingUsers->count() > 10)
                        <div style="text-align: center; padding-top: 1rem;">
                            <span style="color: #5BA3D0; font-weight: 600;">+{{ $goingUsers->count() - 10 }} more</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="height: 3rem;"></div>
</div>
@endsection
