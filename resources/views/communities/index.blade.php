@extends('layouts.app')

@section('title', 'Communities - AnimeTalk')

@section('content')
<div class="communities-page">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 2rem;">
        <!-- Header -->
        <div class="page-header" style="margin-bottom: 2rem;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 0.5rem;">Communities</h1>
                    <p style="color: #666;">Discover and join anime communities</p>
                </div>
                @auth
                <a href="{{ route('communities.create') }}" class="btn-create-community">
                    <i class="bi bi-plus-circle"></i> Start a Community
                </a>
                @endauth
            </div>
        </div>

        <!-- Search & Filter -->
        <div class="search-filter-bar" style="background: white; padding: 1.5rem; border-radius: 12px; margin-bottom: 2rem; border: 1px solid #e0e0e0;">
            <form action="{{ route('communities.index') }}" method="GET">
                <div style="display: grid; grid-template-columns: 1fr auto auto; gap: 1rem;">
                    <input type="text" name="search" placeholder="Search communities..." value="{{ request('search') }}" 
                           style="padding: 0.75rem 1rem; border: 1px solid #e0e0e0; border-radius: 8px;">
                    
                    <select name="category" style="padding: 0.75rem 1rem; border: 1px solid #e0e0e0; border-radius: 8px;">
                        <option value="all">All Categories</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                    
                    <button type="submit" style="padding: 0.75rem 2rem; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                        Search
                    </button>
                </div>
            </form>
        </div>

        <!-- Communities Grid -->
        <div class="communities-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 1.5rem;">
            @forelse($communities as $community)
            <a href="{{ route('communities.show', $community->slug) }}" style="text-decoration: none; color: inherit;">
                <div class="community-card" style="background: white; border: 1px solid #e0e0e0; border-radius: 12px; overflow: hidden; transition: all 0.3s; cursor: pointer;">
                    <!-- Banner -->
                    @if($community->banner)
                    <div style="width: 100%; height: 120px; overflow: hidden;">
                        <img src="{{ asset('storage/' . $community->banner) }}" alt="{{ $community->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    @else
                    <div style="width: 100%; height: 120px; background: linear-gradient(135deg, #5BA3D0, #9B7EDE);"></div>
                    @endif

                    <div style="padding: 1.25rem;">
                        <!-- Icon & Name -->
                        <div style="display: flex; align-items: flex-start; gap: 1rem; margin-bottom: 1rem;">
                            @if($community->icon)
                            <img src="{{ asset('storage/' . $community->icon) }}" alt="{{ $community->name }}" 
                                 style="width: 60px; height: 60px; border-radius: 12px; border: 3px solid white; margin-top: -50px; background: white; object-fit: cover;">
                            @else
                            <div style="width: 60px; height: 60px; border-radius: 12px; border: 3px solid white; margin-top: -50px; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.5rem;">
                                {{ strtoupper(substr($community->name, 0, 1)) }}
                            </div>
                            @endif
                            
                            <div style="flex: 1;">
                                <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0.25rem;">
                                    {{ $community->name }}
                                </h3>
                                <p style="font-size: 0.875rem; color: #666; margin-bottom: 0;">{{ $community->members_count }} members</p>
                            </div>
                        </div>

                        <!-- Description -->
                        <p style="color: #555; font-size: 0.9rem; line-height: 1.5; margin-bottom: 1rem;">
                            {{ Str::limit($community->description, 100) }}
                        </p>

                        <!-- Category Badge -->
                        <div style="margin-bottom: 1rem;">
                            <span style="background: rgba(91, 163, 208, 0.1); color: #5BA3D0; padding: 0.25rem 0.75rem; border-radius: 12px; font-size: 0.85rem; font-weight: 600;">
                                {{ $community->category }}
                            </span>
                        </div>

                        <!-- Action Button -->
                        @auth
                            @if($community->isMember(auth()->user()))
                            <div style="display: block; text-align: center; padding: 0.625rem; background: #f0f0f0; color: #333; border-radius: 8px; font-weight: 600; font-size: 0.9rem;">
                                <i class="bi bi-check-circle"></i> Joined
                            </div>
                            @else
                            <div onclick="event.preventDefault(); event.stopPropagation(); this.querySelector('form').submit();" style="display: block;">
                                <form action="{{ route('communities.join', $community) }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <button type="submit" style="width: 100%; padding: 0.625rem; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 0.9rem;">
                                        <i class="bi bi-plus-circle"></i> Join
                                    </button>
                                </form>
                            </div>
                            @endif
                        @else
                        <div style="display: block; text-align: center; padding: 0.625rem; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; border-radius: 8px; font-weight: 600; font-size: 0.9rem;">
                            <i class="bi bi-plus-circle"></i> Join
                        </div>
                        @endauth
                    </div>
                </div>
            </a>
            @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 3rem; color: #999;">
                <i class="bi bi-people" style="font-size: 3rem; display: block; margin-bottom: 1rem;"></i>
                <p>No communities found</p>
                @auth
                <a href="{{ route('communities.create') }}" style="color: #5BA3D0; text-decoration: underline;">Create the first one!</a>
                @endauth
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div style="margin-top: 2rem;">
            {{ $communities->links() }}
        </div>
    </div>
</div>

<style>
.btn-create-community {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: linear-gradient(135deg, #5BA3D0, #9B7EDE);
    color: white;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s;
}

.btn-create-community:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(91, 163, 208, 0.3);
}

.community-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    border-color: #5BA3D0;
}
</style>
@endsection
