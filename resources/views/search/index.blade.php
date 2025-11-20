@extends('layouts.app')

@section('title', 'Search - AnimeTalk')

@push('styles')
<style>
.search-page,
.search-page *,
.post-card,
.post-card *,
.search-section,
.search-section * {
    opacity: 1 !important;
    visibility: visible !important;
}
.post-card {
    background: white !important;
}
</style>
@endpush

@section('content')
<div class="search-page" style="opacity: 1 !important; visibility: visible !important;">
    <div class="container">
        <!-- Search Header -->
        <div class="search-header">
            <h1>Search Results</h1>
            @if($query)
                <p>Showing results for: <strong>"{{ $query }}"</strong></p>
            @endif
        </div>

        <!-- Search Form -->
        <div class="search-form-advanced">
            <form action="{{ route('search') }}" method="GET">
                <div class="search-inputs">
                    <input type="text" name="q" placeholder="Search posts and forums..." value="{{ $query }}">
                    <select name="type">
                        <option value="all" {{ $type == 'all' ? 'selected' : '' }}>All</option>
                        <option value="posts" {{ $type == 'posts' ? 'selected' : '' }}>Posts</option>
                        <option value="forums" {{ $type == 'forums' ? 'selected' : '' }}>Forums</option>
                    </select>
                    <button type="submit" class="btn-primary">Search</button>
                </div>
                
                <div class="search-tags">
                    <label>Filter by tag:</label>
                    <div class="tags-filter">
                        <a href="{{ route('search', array_filter(['q' => $query, 'type' => $type])) }}" 
                           class="filter-tag {{ !$tag ? 'active' : '' }}">All</a>
                        @foreach($tags as $t)
                            <a href="{{ route('search', array_filter(['q' => $query, 'type' => $type, 'tag' => $t->slug])) }}" 
                               class="filter-tag {{ $tag == $t->slug ? 'active' : '' }}"
                               style="--tag-color: {{ $t->color }}">
                                {{ $t->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </form>
        </div>

        <!-- Results -->
        @if($type === 'posts' || $type === 'all')
            @if($posts->count() > 0)
                <div class="search-section">
                    <h2>Posts ({{ $posts->total() }})</h2>
                    <div class="posts-grid">
                        @foreach($posts as $post)
                            <article class="post-card">
                                @if($post->image)
                                    <div class="post-image">
                                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
                                    </div>
                                @else
                                    <div class="post-image-placeholder">
                                        <img src="https://placehold.co/400x300/E8D8F8/8B7FD8?text=Post" alt="{{ $post->title }}">
                                    </div>
                                @endif
                                
                                <div class="post-content">
                                    <div class="post-tags">
                                        @foreach($post->tags->take(2) as $postTag)
                                            <span class="tag-badge" style="background-color: {{ $postTag->color }}20; color: {{ $postTag->color }}">
                                                {{ $postTag->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                    
                                    <h3 class="post-title">
                                        <a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
                                    </h3>
                                    
                                    <div class="post-meta">
                                        <div class="post-author">
                                            <div class="author-avatar">{{ substr($post->user->name, 0, 1) }}</div>
                                            <span>{{ $post->user->name }}</span>
                                        </div>
                                        <div class="post-stats">
                                            <span>👁️ {{ $post->views }}</span>
                                            <span>💬 {{ $post->comments->count() }}</span>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                    
                    @if($posts->hasPages())
                        <div class="pagination">
                            {{ $posts->appends(request()->except('page'))->links() }}
                        </div>
                    @endif
                </div>
            @endif
        @endif

        @if($type === 'forums' || $type === 'all')
            @if($forums->count() > 0)
                <div class="search-section">
                    <h2>Forums ({{ $forums->count() }})</h2>
                    <div class="forums-grid">
                        @foreach($forums as $forum)
                            <a href="{{ route('community.show', $forum->slug) }}" class="forum-card">
                                <div class="forum-icon">{{ $forum->icon ?? '💬' }}</div>
                                <div class="forum-info">
                                    <h3>{{ $forum->name }}</h3>
                                    <p>{{ $forum->description }}</p>
                                    <div class="forum-tags">
                                        @foreach($forum->tags as $forumTag)
                                            <span class="tag-badge" style="background-color: {{ $forumTag->color }}20; color: {{ $forumTag->color }}">
                                                {{ $forumTag->name }}
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
                        @endforeach
                    </div>
                </div>
            @endif
        @endif

        @if(($type === 'posts' && $posts->count() === 0) || ($type === 'forums' && $forums->count() === 0) || ($type === 'all' && $posts->count() === 0 && $forums->count() === 0))
            <div class="empty-state">
                <p>No results found. Try different keywords or tags.</p>
            </div>
        @endif
    </div>
</div>
@endsection
