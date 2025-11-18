@extends('layouts.app')

@section('title', $community->name . ' - AnimeTalk')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/communities.css') }}">
@endpush

@section('content')
<div class="community-detail-page">
    <!-- Banner Section -->
    <div class="community-banner">
        @if($community->banner)
        <img src="{{ asset('storage/' . $community->banner) }}" alt="{{ $community->name }}" style="width: 100%; height: 100%; object-fit: cover;">
        @else
        <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #5BA3D0, #9B7EDE);"></div>
        @endif
    </div>

    <!-- Community Header -->
    <div style="background: white; border-bottom: 1px solid #e0e0e0;">
        <div class="community-header-container">
            <div class="community-header-content">
                <!-- Community Icon -->
                @if($community->icon)
                <img src="{{ asset('storage/' . $community->icon) }}" alt="{{ $community->name }}" class="community-icon">
                @else
                <div class="community-icon-placeholder">
                    {{ strtoupper(substr($community->name, 0, 1)) }}
                </div>
                @endif

                <!-- Community Info -->
                <div style="flex: 1;">
                    <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 0.5rem;">{{ $community->name }}</h1>
                    <div style="display: flex; align-items: center; gap: 1rem; color: #666; font-size: 0.9rem; margin-bottom: 0.75rem;">
                        <span><i class="bi bi-people"></i> {{ $community->members_count }} members</span>
                        <span>•</span>
                        <span style="background: rgba(91, 163, 208, 0.1); color: #5BA3D0; padding: 0.25rem 0.75rem; border-radius: 12px; font-weight: 600;">
                            {{ $community->category }}
                        </span>
                        @if($community->is_private)
                        <span style="background: rgba(155, 126, 222, 0.1); color: #9B7EDE; padding: 0.25rem 0.75rem; border-radius: 12px; font-weight: 600;">
                            <i class="bi bi-lock"></i> Private
                        </span>
                        @endif
                    </div>
                    <p style="color: #555; line-height: 1.6;">{{ $community->description }}</p>
                </div>

                <!-- Action Button -->
                @auth
                    @if($community->isOwner(auth()->user()))
                    <div style="margin-top: 1rem; display: flex; gap: 0.75rem;">
                        <span style="display: inline-block; padding: 0.75rem 1.5rem; background: rgba(91, 163, 208, 0.1); color: #5BA3D0; border-radius: 8px; font-weight: 600;">
                            <i class="bi bi-star-fill"></i> Owner
                        </span>
                        <a href="{{ route('communities.edit', $community->slug) }}" 
                           style="display: inline-block; padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; border-radius: 8px; text-decoration: none; font-weight: 600;">
                            <i class="bi bi-pencil"></i> Edit Community
                        </a>
                    </div>
                    @elseif($community->isMember(auth()->user()))
                    <form action="{{ route('communities.leave', $community) }}" method="POST" style="margin-top: 1rem;">
                        @csrf
                        <button type="submit" onclick="return confirm('Are you sure you want to leave this community?')"
                                style="padding: 0.75rem 1.5rem; background: #f0f0f0; color: #333; border: 1px solid #e0e0e0; border-radius: 8px; font-weight: 600; cursor: pointer;">
                            <i class="bi bi-box-arrow-right"></i> Leave
                        </button>
                    </form>
                    @else
                    <form action="{{ route('communities.join', $community) }}" method="POST" style="margin-top: 1rem;">
                        @csrf
                        <button type="submit" 
                                style="padding: 0.75rem 2rem; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                            <i class="bi bi-plus-circle"></i> Join
                        </button>
                    </form>
                    @endif
                @else
                <a href="{{ route('login') }}" style="display: inline-block; margin-top: 1rem; padding: 0.75rem 2rem; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; border-radius: 8px; text-decoration: none; font-weight: 600;">
                    <i class="bi bi-plus-circle"></i> Join
                </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="community-main-content">
        <div class="community-content-grid">
            <!-- Posts Section -->
            <div>
                <div style="background: white; border-radius: 12px; padding: 1.5rem; border: 1px solid #e0e0e0; margin-bottom: 1.5rem;">
                    <h2 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1rem;">Posts</h2>
                    <p style="color: #999; text-align: center; padding: 2rem;">
                        Community posts feature coming soon!
                    </p>
                </div>
            </div>

            <!-- Sidebar -->
            <div>
                <!-- Recent Activities -->
                <div style="background: white; border-radius: 12px; padding: 1.5rem; border: 1px solid #e0e0e0; margin-bottom: 1.5rem;">
                    <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1rem;">
                        <i class="bi bi-activity"></i> Recent Activities
                    </h3>
                    <div style="max-height: 400px; overflow-y: auto;">
                        @forelse($activities as $activity)
                        <div style="display: flex; align-items: start; gap: 0.75rem; padding: 0.75rem 0; border-bottom: 1px solid #f0f0f0;">
                            @if($activity->user && $activity->user->profile_photo)
                            <img src="{{ asset('storage/' . $activity->user->profile_photo) }}" alt="{{ $activity->user->name }}" 
                                 style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; flex-shrink: 0;">
                            @elseif($activity->user)
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.85rem; flex-shrink: 0;">
                                {{ strtoupper(substr($activity->user->name, 0, 1)) }}
                            </div>
                            @else
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: #ccc; flex-shrink: 0;"></div>
                            @endif
                            
                            <div style="flex: 1; min-width: 0;">
                                <div style="font-size: 0.85rem; color: #333; line-height: 1.4;">
                                    @if($activity->type === 'joined')
                                        <strong>{{ $activity->user->name ?? 'User' }}</strong> <span style="color: #28a745;">joined</span> the community
                                    @elseif($activity->type === 'left')
                                        <strong>{{ $activity->user->name ?? 'User' }}</strong> <span style="color: #dc3545;">left</span> the community
                                    @elseif($activity->type === 'created')
                                        <strong>{{ $activity->user->name ?? 'User' }}</strong> <span style="color: #5BA3D0;">created</span> the community
                                    @elseif($activity->type === 'posted')
                                        <strong>{{ $activity->user->name ?? 'User' }}</strong> posted in the community
                                    @else
                                        {{ $activity->description }}
                                    @endif
                                </div>
                                <div style="font-size: 0.75rem; color: #999; margin-top: 0.25rem;">
                                    {{ $activity->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                        @empty
                        <p style="color: #999; text-align: center; padding: 1rem;">No activities yet</p>
                        @endforelse
                    </div>
                </div>

                <!-- About -->
                <div style="background: white; border-radius: 12px; padding: 1.5rem; border: 1px solid #e0e0e0; margin-bottom: 1.5rem;">
                    <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1rem;">About Community</h3>
                    <div style="color: #555; line-height: 1.6; margin-bottom: 1rem;">
                        {{ $community->description }}
                    </div>
                    <div style="padding-top: 1rem; border-top: 1px solid #e0e0e0;">
                        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                            <i class="bi bi-calendar3" style="color: #5BA3D0;"></i>
                            <span style="color: #666; font-size: 0.9rem;">Created {{ $community->created_at->diffForHumans() }}</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <i class="bi bi-people" style="color: #5BA3D0;"></i>
                            <span style="color: #666; font-size: 0.9rem;">{{ $community->members_count }} members</span>
                        </div>
                    </div>
                </div>

                <!-- Members -->
                <div style="background: white; border-radius: 12px; padding: 1.5rem; border: 1px solid #e0e0e0;">
                    <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1rem;">
                        Members ({{ $community->members()->count() }})
                    </h3>
                    <div style="max-height: 400px; overflow-y: auto;">
                        @forelse($community->members()->latest('community_members.created_at')->take(20)->get() as $member)
                        <div style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 0; border-bottom: 1px solid #f0f0f0;">
                            @if($member->profile_photo)
                            <img src="{{ asset('storage/' . $member->profile_photo) }}" alt="{{ $member->name }}" 
                                 style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                            @else
                            <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700;">
                                {{ strtoupper(substr($member->name, 0, 1)) }}
                            </div>
                            @endif
                            
                            <div style="flex: 1; min-width: 0;">
                                <div style="font-weight: 600; font-size: 0.9rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $member->name }}
                                </div>
                                <div style="font-size: 0.8rem; color: #666;">
                                    {{ ucfirst($member->pivot->role) }}
                                </div>
                            </div>

                            @if(auth()->check() && $community->isOwner(auth()->user()) && $member->uid !== auth()->user()->uid)
                            <form action="{{ route('communities.removeMember', [$community, $member->uid]) }}" method="POST" onsubmit="return confirm('Remove this member?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: #ff4444; cursor: pointer; padding: 0.25rem;">
                                    <i class="bi bi-x-circle"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                        @empty
                        <p style="color: #999; text-align: center; padding: 1rem;">No members yet</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
