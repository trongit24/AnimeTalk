@extends('layouts.app')

@section('title', 'Home - AnimeTalk')

@section('content')
<div class="home-page">
    <div class="container">
        <!-- Hero Section -->
        <div class="hero-section">
            <div class="hero-content">
                <h1>DISCOVER ANIME<br>DISCUSSIONS</h1>
                <p>Join the community and explore endless anime conversations</p>
                <div class="hero-actions">
                    <a href="{{ route('community.index') }}" class="btn-primary-large">
                        Explore Community
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="hero-image">
                <div class="anime-card-featured">
                    <img src="https://placehold.co/400x500/A8C5E8/FFFFFF?text=Anime+Character" alt="Featured Anime">
                </div>
            </div>
        </div>

        <!-- Popular Tags -->
        <div class="section-header">
            <h2>Popular Tags</h2>
        </div>
        <div class="tags-grid">
            @foreach($popularTags as $tag)
                <a href="{{ route('home', ['tag' => $tag->slug]) }}" class="tag-card" style="--tag-color: {{ $tag->color }}">
                    <span class="tag-name">{{ $tag->name }}</span>
                    <span class="tag-count">{{ $tag->posts_count }} posts</span>
                </a>
            @endforeach
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <div class="filter-header">
                <h2>Latest Posts</h2>
                <div class="filter-tags">
                    <a href="{{ route('home') }}" class="filter-tag {{ !request('tag') ? 'active' : '' }}">All</a>
                    @foreach($tags as $tag)
                        <a href="{{ route('home', ['tag' => $tag->slug]) }}" 
                           class="filter-tag {{ request('tag') == $tag->slug ? 'active' : '' }}"
                           style="--tag-color: {{ $tag->color }}">
                            {{ $tag->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Posts Grid -->
        <div class="posts-grid">
            @forelse($posts as $post)
                <article class="post-card">
                    @if($post->image)
                        <div class="post-image">
                            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
                        </div>
                    @else
                        <div class="post-image-placeholder">
                            <img src="https://placehold.co/400x300/E8D8F8/8B7FD8?text={{ urlencode($post->title) }}" alt="{{ $post->title }}">
                        </div>
                    @endif
                    
                    <div class="post-content">
                        <div class="post-tags">
                            @foreach($post->tags->take(2) as $tag)
                                <span class="tag-badge" style="background-color: {{ $tag->color }}20; color: {{ $tag->color }}">
                                    {{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                        
                        <h3 class="post-title">
                            <a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
                        </h3>
                        
                        <p class="post-excerpt">{{ Str::limit(strip_tags($post->content), 120) }}</p>
                        
                        <div class="post-meta">
                            <div class="post-author">
                                <div class="author-avatar">{{ substr($post->user->name, 0, 1) }}</div>
                                <span>{{ $post->user->name }}</span>
                            </div>
                            <div class="post-stats">
                                <span>👁️ {{ $post->views }}</span>
                                <span>💬 {{ $post->comments->count() }}</span>
                                <span>❤️ {{ $post->likes }}</span>
                            </div>
                        </div>
                    </div>
                </article>
            @empty
                <div class="empty-state">
                    <p>No posts found. Be the first to create one!</p>
                    @auth
                        <a href="{{ route('posts.create') }}" class="btn-primary">Create Post</a>
                    @endauth
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($posts->hasPages())
            <div class="pagination">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
