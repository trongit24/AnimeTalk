@extends('layouts.app')

@section('title', 'Community - AnimeTalk')

@section('content')
<div class="community-page">
    <div class="container">
        <!-- Header -->
        <div class="page-header">
            <h1>Community Forums</h1>
            <p>Explore sub-forums based on your favorite anime topics</p>
        </div>

        <!-- Tag Filter -->
        <div class="filter-section">
            <div class="filter-tags">
                <a href="{{ route('community.index') }}" class="filter-tag {{ !request('tag') ? 'active' : '' }}">All Forums</a>
                @foreach($tags as $tag)
                    <a href="{{ route('community.index', ['tag' => $tag->slug]) }}" 
                       class="filter-tag {{ request('tag') == $tag->slug ? 'active' : '' }}"
                       style="--tag-color: {{ $tag->color }}">
                        {{ $tag->name }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Forums Grid -->
        <div class="forums-grid">
            @forelse($forums as $forum)
                <a href="{{ route('community.show', $forum->slug) }}" class="forum-card">
                    <div class="forum-icon">{{ $forum->icon ?? '💬' }}</div>
                    <div class="forum-info">
                        <h3>{{ $forum->name }}</h3>
                        <p>{{ $forum->description }}</p>
                        <div class="forum-tags">
                            @foreach($forum->tags as $tag)
                                <span class="tag-badge" style="background-color: {{ $tag->color }}20; color: {{ $tag->color }}">
                                    {{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    <div class="forum-stats">
                        <div class="stat">
                            <span class="stat-value">{{ $forum->posts_count }}</span>
                            <span class="stat-label">Posts</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="empty-state">
                    <p>No forums found.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
