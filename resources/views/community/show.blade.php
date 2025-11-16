@extends('layouts.app')

@section('title', $forum->name . ' - Community')

@section('content')
<div class="forum-page">
    <div class="container">
        <!-- Forum Header -->
        <div class="forum-header">
            <div class="forum-icon-large">{{ $forum->icon ?? '💬' }}</div>
            <div class="forum-header-content">
                <h1>{{ $forum->name }}</h1>
                <p>{{ $forum->description }}</p>
                <div class="forum-tags">
                    @foreach($forum->tags as $tag)
                        <span class="tag-badge" style="background-color: {{ $tag->color }}20; color: {{ $tag->color }}">
                            {{ $tag->name }}
                        </span>
                    @endforeach
                </div>
            </div>
            @auth
                <div class="forum-actions">
                    <a href="{{ route('posts.create') }}" class="btn-primary">Create Post</a>
                </div>
            @endauth
        </div>

        <!-- Posts List -->
        <div class="posts-list">
            @forelse($posts as $post)
                <article class="post-item">
                    <div class="post-item-main">
                        @if($post->is_pinned)
                            <span class="pin-badge">📌 Pinned</span>
                        @endif
                        <h3 class="post-item-title">
                            <a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
                        </h3>
                        <div class="post-item-tags">
                            @foreach($post->tags->take(3) as $tag)
                                <span class="tag-badge" style="background-color: {{ $tag->color }}20; color: {{ $tag->color }}">
                                    {{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                        <div class="post-item-meta">
                            <span class="post-author">👤 {{ $post->user->name }}</span>
                            <span class="post-date">🕐 {{ $post->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    <div class="post-item-stats">
                        <div class="stat-item">
                            <span class="stat-value">{{ $post->views }}</span>
                            <span class="stat-label">Views</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value">{{ $post->comments->count() }}</span>
                            <span class="stat-label">Replies</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value">{{ $post->likes }}</span>
                            <span class="stat-label">Likes</span>
                        </div>
                    </div>
                </article>
            @empty
                <div class="empty-state">
                    <p>No posts in this forum yet. Be the first to post!</p>
                    @auth
                        <a href="{{ route('posts.create') }}" class="btn-primary">Create First Post</a>
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
