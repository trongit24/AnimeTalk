@extends('layouts.app')

@section('title', 'Home - AnimeTalk')

@section('content')
<div class="reddit-layout">
    <!-- Left Sidebar -->
    <aside class="left-sidebar">
        <div class="sidebar-section">
            <h3 class="sidebar-title">MENU</h3>
            <ul class="sidebar-menu">
                <li class="active">
                    <a href="{{ route('home') }}">
                        <i class="bi bi-house-door-fill"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('search') }}">
                        <i class="bi bi-compass"></i>
                        <span>Explore</span>
                    </a>
                </li>
                @auth
                <li>
                    <a href="{{ route('posts.create') }}">
                        <i class="bi bi-plus-circle-fill"></i>
                        <span>Create Post</span>
                    </a>
                </li>
                @endauth
            </ul>
        </div>

        <div class="sidebar-section mt-4">
            <h3 class="sidebar-title">COMMUNITIES</h3>
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('communities.index') }}" class="sidebar-link">
                        <i class="bi bi-grid-3x3-gap"></i>
                        <span>Browse Communities</span>
                    </a>
                </li>
                @auth
                <li>
                    <a href="{{ route('communities.create') }}" class="sidebar-link">
                        <i class="bi bi-plus-circle"></i>
                        <span>Start a Community</span>
                    </a>
                </li>
                @endauth
            </ul>
        </div>

        <div class="sidebar-section mt-4">
            <h3 class="sidebar-title">ANIME GROUPS</h3>
            <ul class="group-list">
                <li><a href="#"><span class="group-dot cosplay"></span> Cosplay Events</a></li>
                <li><a href="#"><span class="group-dot manga"></span> Manga Readers</a></li>
                <li><a href="#"><span class="group-dot music"></span> Anime Music</a></li>
                <li><a href="#"><span class="group-dot art"></span> Fan Art Showcase</a></li>
            </ul>
        </div>
    </aside>

    <!-- Main Feed -->
    <main class="main-feed">
        <!-- Category Tabs -->
        <div class="category-tabs" style="background: white; border-radius: 8px; margin-bottom: 1rem; padding: 0.5rem; display: flex; gap: 0.5rem; border: 1px solid #e0e0e0; overflow-x: auto;">
            <a href="{{ route('home', ['category' => 'all']) }}" 
               class="category-tab {{ (!isset($category) || $category == 'all') ? 'active' : '' }}"
               style="flex: 0 0 auto; text-align: center; padding: 0.75rem 1rem; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 0.95rem; transition: all 0.2s; {{ (!isset($category) || $category == 'all') ? 'background: #1a73e8; color: white;' : 'color: #666; background: transparent;' }}">
                <i class="bi bi-grid-3x3"></i> All
            </a>
            <a href="{{ route('home', ['category' => 'anime']) }}" 
               class="category-tab {{ (isset($category) && $category == 'anime') ? 'active' : '' }}"
               style="flex: 0 0 auto; text-align: center; padding: 0.75rem 1rem; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 0.95rem; transition: all 0.2s; {{ (isset($category) && $category == 'anime') ? 'background: #1a73e8; color: white;' : 'color: #666; background: transparent;' }}">
                <i class="bi bi-play-circle"></i> Anime
            </a>
            <a href="{{ route('home', ['category' => 'manga']) }}" 
               class="category-tab {{ (isset($category) && $category == 'manga') ? 'active' : '' }}"
               style="flex: 0 0 auto; text-align: center; padding: 0.75rem 1rem; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 0.95rem; transition: all 0.2s; {{ (isset($category) && $category == 'manga') ? 'background: #1a73e8; color: white;' : 'color: #666; background: transparent;' }}">
                <i class="bi bi-book"></i> Manga
            </a>
            <a href="{{ route('home', ['category' => 'cosplay']) }}" 
               class="category-tab {{ (isset($category) && $category == 'cosplay') ? 'active' : '' }}"
               style="flex: 0 0 auto; text-align: center; padding: 0.75rem 1rem; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 0.95rem; transition: all 0.2s; {{ (isset($category) && $category == 'cosplay') ? 'background: #1a73e8; color: white;' : 'color: #666; background: transparent;' }}">
                <i class="bi bi-mask"></i> Cosplay
            </a>
            <a href="{{ route('home', ['category' => 'discussion']) }}" 
               class="category-tab {{ (isset($category) && $category == 'discussion') ? 'active' : '' }}"
               style="flex: 0 0 auto; text-align: center; padding: 0.75rem 1rem; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 0.95rem; transition: all 0.2s; {{ (isset($category) && $category == 'discussion') ? 'background: #1a73e8; color: white;' : 'color: #666; background: transparent;' }}">
                <i class="bi bi-chat-dots"></i> Discussion
            </a>
            <a href="{{ route('home', ['category' => 'fanart']) }}" 
               class="category-tab {{ (isset($category) && $category == 'fanart') ? 'active' : '' }}"
               style="flex: 0 0 auto; text-align: center; padding: 0.75rem 1rem; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 0.95rem; transition: all 0.2s; {{ (isset($category) && $category == 'fanart') ? 'background: #1a73e8; color: white;' : 'color: #666; background: transparent;' }}">
                <i class="bi bi-palette"></i> Fan Art
            </a>
            <a href="{{ route('home', ['category' => 'news']) }}" 
               class="category-tab {{ (isset($category) && $category == 'news') ? 'active' : '' }}"
               style="flex: 0 0 auto; text-align: center; padding: 0.75rem 1rem; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 0.95rem; transition: all 0.2s; {{ (isset($category) && $category == 'news') ? 'background: #1a73e8; color: white;' : 'color: #666; background: transparent;' }}">
                <i class="bi bi-newspaper"></i> News
            </a>
            <a href="{{ route('home', ['category' => 'review']) }}" 
               class="category-tab {{ (isset($category) && $category == 'review') ? 'active' : '' }}"
               style="flex: 0 0 auto; text-align: center; padding: 0.75rem 1rem; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 0.95rem; transition: all 0.2s; {{ (isset($category) && $category == 'review') ? 'background: #1a73e8; color: white;' : 'color: #666; background: transparent;' }}">
                <i class="bi bi-star"></i> Review
            </a>
        </div>

        <!-- Create Post Box -->
        @auth
        <div class="create-box">
            @if(auth()->user()->profile_photo)
                <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="{{ auth()->user()->name }}" class="user-avatar-circle" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
            @else
                <div class="user-avatar-circle">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            @endif
            <a href="{{ route('posts.create') }}" class="create-input">
                What's your favorite anime?
            </a>
            <div class="create-icons">
                <button class="icon-btn" onclick="window.location='{{ route('posts.create') }}'">
                    <i class="bi bi-image"></i>
                </button>
                <button class="icon-btn" onclick="window.location='{{ route('posts.create') }}'">
                    <i class="bi bi-link-45deg"></i>
                </button>
                <button class="icon-btn" onclick="window.location='{{ route('posts.create') }}'">
                    <i class="bi bi-emoji-smile"></i>
                </button>
            </div>
        </div>
        @endauth

        <!-- Posts Feed -->
        @forelse($posts as $post)
        <article class="feed-card">
            <div class="card-body">
                <div class="card-meta" style="display: flex; align-items: center; gap: 0.5rem;">
                    @if($post->user->profile_photo)
                    <img src="{{ asset('storage/' . $post->user->profile_photo) }}" alt="{{ $post->user->name }}" style="width: 24px; height: 24px; border-radius: 50%; object-fit: cover;">
                    @else
                    <div style="width: 24px; height: 24px; border-radius: 50%; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.7rem;">
                        {{ strtoupper(substr($post->user->name, 0, 1)) }}
                    </div>
                    @endif
                    <span class="meta-author">{{ $post->user->name }}</span>
                    <span class="meta-dot">•</span>
                    <time class="meta-time">{{ $post->created_at->diffForHumans() }}</time>
                </div>

                <a href="{{ route('posts.show', $post->slug) }}" class="card-content-link">
                    <h2 class="card-title">{{ $post->title }}</h2>
                    
                    @if($post->image)
                    <div class="card-image">
                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" loading="lazy">
                    </div>
                    @endif

                    @if($post->video)
                    <div class="card-video" style="margin-bottom: 1rem;">
                        <video controls style="width: 100%; max-height: 400px; border-radius: 8px;">
                            <source src="{{ asset('storage/' . $post->video) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                    @endif

                    <p class="card-text">{{ Str::limit($post->content, 250) }}</p>
                </a>

                @if($post->tags->count() > 0)
                <div class="card-tags">
                    @foreach($post->tags as $tag)
                    <span class="tag-pill" style="background: {{ $tag->color }}15; color: {{ $tag->color }}">
                        {{ $tag->name }}
                    </span>
                    @endforeach
                </div>
                @endif

                <div class="card-actions">
                    <button class="action-btn comment-modal-btn" data-post-id="{{ $post->id }}" data-post-title="{{ $post->title }}">
                        <i class="bi bi-chat"></i>
                        {{ $post->comments->count() }} Comments
                    </button>
                    @auth
                    <button class="action-btn post-like-btn {{ $post->likedBy(auth()->user()) ? 'liked' : '' }}" data-post-id="{{ $post->id }}">
                        <i class="bi {{ $post->likedBy(auth()->user()) ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                        <span class="like-count">{{ $post->likes()->count() }}</span> Likes
                    </button>
                    @else
                    <a href="{{ route('login') }}" class="action-btn">
                        <i class="bi bi-heart"></i>
                        {{ $post->likes()->count() }} Likes
                    </a>
                    @endauth
                    <button class="action-btn">
                        <i class="bi bi-share"></i>
                        Share
                    </button>
                    <button class="action-btn">
                        <i class="bi bi-bookmark"></i>
                        Save
                    </button>
                </div>
            </div>
        </article>
        @empty
        <div class="empty-feed">
            <i class="bi bi-inbox" style="font-size: 4rem; color: #ccc;"></i>
            <p>No posts available</p>
        </div>
        @endforelse

        <!-- Pagination -->
        <div class="feed-pagination">
            {{ $posts->links() }}
        </div>
    </main>

    <!-- Right Sidebar -->
    <aside class="right-sidebar">
        <!-- Top Posts -->
        <div class="widget">
            <h3 class="widget-title">Top Posts</h3>
            <ul class="event-list">
                @foreach($topPosts as $topPost)
                <li class="event-item" style="cursor: pointer;" onclick="window.location='{{ route('posts.show', $topPost->slug) }}'">
                    <div class="event-date" style="background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; min-width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 8px;">
                        <i class="bi bi-fire" style="font-size: 1.2rem;"></i>
                    </div>
                    <div class="event-details">
                        <div class="event-title">{{ Str::limit($topPost->title, 40) }}</div>
                        <div class="event-type" style="color: #FF6B6B; font-weight: 600;">
                            {{ number_format($topPost->interactions_count) }} tương tác
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
            <a href="{{ route('top.posts') }}" class="widget-link">View All →</a>
        </div>
    </aside>
</div>

@push('styles')
<style>
body {
    background: #DAE0E6;
    margin: 0;
    font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
}

.reddit-layout {
    display: grid;
    grid-template-columns: 250px 1fr 320px;
    gap: 20px;
    max-width: 1600px;
    margin: 0 auto;
    padding: 20px;
    min-height: 100vh;
}

/* LEFT SIDEBAR */
.left-sidebar {
    background: #4A5568;
    border-radius: 12px;
    padding: 1.25rem;
    height: fit-content;
    position: sticky;
    top: 90px;
    color: white;
}

.sidebar-title {
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 1px;
    color: #CBD5E0;
    margin-bottom: 0.75rem;
}

.sidebar-menu {
    list-style: none;
    padding: 0;
    margin: 0 0 1rem 0;
}

.sidebar-menu li {
    margin-bottom: 0.25rem;
}

.sidebar-menu a {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 0.875rem;
    color: #E2E8F0;
    text-decoration: none;
    border-radius: 8px;
    transition: all 0.2s;
    font-weight: 500;
    font-size: 0.95rem;
}

.sidebar-menu a:hover {
    background: rgba(255, 255, 255, 0.1);
}

.sidebar-menu li.active a {
    background: linear-gradient(135deg, #5BA3D0, #9B7EDE);
    color: white;
}

.sidebar-menu i {
    font-size: 1.4rem;
}

.forum-list,
.group-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.forum-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.625rem 0.5rem;
    color: #E2E8F0;
    text-decoration: none;
    border-radius: 6px;
    transition: all 0.2s;
    margin-bottom: 0.25rem;
}

.forum-item:hover {
    background: rgba(255, 255, 255, 0.08);
}

.forum-icon {
    font-size: 1.25rem;
}

.forum-info {
    flex: 1;
}

.forum-name {
    font-size: 0.9rem;
    font-weight: 500;
}

.forum-stats {
    font-size: 0.75rem;
    color: #A0AEC0;
}

.group-list li {
    margin-bottom: 0.5rem;
}

.group-list a {
    display: flex;
    align-items: center;
    gap: 0.625rem;
    color: #E2E8F0;
    text-decoration: none;
    font-size: 0.9rem;
    padding: 0.5rem 0.5rem;
    border-radius: 6px;
    transition: all 0.2s;
}

.group-list a:hover {
    background: rgba(255, 255, 255, 0.08);
}

.group-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    display: inline-block;
}

.group-dot.cosplay { background: #FF6B9D; }
.group-dot.manga { background: #FFB86C; }
.group-dot.music { background: #9B7EDE; }
.group-dot.art { background: #7FB069; }

/* MAIN FEED */
.main-feed {
    max-width: 750px;
}

.create-box {
    background: white;
    border: 1px solid #ccc;
    border-radius: 8px;
    padding: 0.75rem 1rem;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.user-avatar-circle {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: linear-gradient(135deg, #5BA3D0, #9B7EDE);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.create-input {
    flex: 1;
    padding: 0.75rem 1.25rem;
    background: #F6F7F8;
    border: 1px solid #EDEFF1;
    border-radius: 25px;
    color: #7C7C7C;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
    display: block;
    font-size: 0.95rem;
}

.create-input:hover {
    background: white;
    border-color: #5BA3D0;
}

.create-icons {
    display: flex;
    gap: 0.375rem;
}

.icon-btn {
    background: none;
    border: none;
    color: #878A8C;
    font-size: 1.5rem;
    cursor: pointer;
    padding: 0.375rem;
    border-radius: 6px;
    transition: all 0.2s;
}

.icon-btn:hover {
    background: #F6F7F8;
    color: #5BA3D0;
}

.feed-card {
    background: white;
    border: 1px solid #ccc;
    border-radius: 8px;
    margin-bottom: 1rem;
    padding: 0.875rem 1rem;
    transition: all 0.2s;
}

.feed-card:hover {
    border-color: #898989;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.card-body {
    width: 100%;
}

.card-meta {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.625rem;
    font-size: 0.8rem;
    flex-wrap: wrap;
}

.meta-forum {
    font-weight: 700;
    color: #1c1c1c;
    text-decoration: none;
    transition: all 0.2s;
}

.meta-forum:hover {
    text-decoration: underline;
}

.meta-dot {
    color: #ccc;
}

.meta-author {
    color: #7C7C7C;
}

.meta-time {
    color: #7C7C7C;
}

.card-content-link {
    text-decoration: none;
    color: inherit;
    display: block;
}

.card-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1c1c1c;
    margin: 0 0 0.625rem 0;
    line-height: 1.3;
}

.card-title:hover {
    color: #5BA3D0;
}

.card-image {
    width: 100%;
    max-height: 450px;
    overflow: hidden;
    border-radius: 6px;
    margin: 0.75rem 0;
}

.card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.card-text {
    color: #555;
    font-size: 0.95rem;
    line-height: 1.5;
    margin: 0.625rem 0;
}

.card-tags {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
    margin: 0.75rem 0;
}

.tag-pill {
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 500;
}

.card-actions {
    display: flex;
    gap: 0.5rem;
    margin-top: 0.75rem;
}

.action-btn {
    background: none;
    border: none;
    color: #878A8C;
    font-size: 0.875rem;
    font-weight: 600;
    padding: 0.5rem 0.75rem;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    gap: 0.375rem;
    text-decoration: none;
}

.action-btn:hover {
    background: #F6F7F8;
}

.post-like-btn.liked {
    color: #FF6B9D;
}

.post-like-btn.liked i {
    color: #FF6B9D;
}

/* RIGHT SIDEBAR */
.right-sidebar {
    height: fit-content;
    position: sticky;
    top: 90px;
}

.widget {
    background: white;
    border: 1px solid #ccc;
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 1rem;
}

.widget-title {
    font-size: 0.875rem;
    font-weight: 700;
    color: #1c1c1c;
    margin: 0 0 0.875rem 0;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.event-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.event-item {
    display: flex;
    gap: 0.75rem;
    padding: 0.75rem 0;
    border-bottom: 1px solid #F0F0F0;
}

.event-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.event-date {
    background: linear-gradient(135deg, #5BA3D0, #9B7EDE);
    color: white;
    width: 48px;
    height: 48px;
    border-radius: 8px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.date-day {
    font-size: 1.125rem;
    font-weight: 700;
    line-height: 1;
}

.date-month {
    font-size: 0.75rem;
    text-transform: uppercase;
}

.event-details {
    flex: 1;
}

.event-title {
    font-weight: 600;
    font-size: 0.9rem;
    color: #1c1c1c;
    margin-bottom: 0.25rem;
}

.event-type {
    font-size: 0.8rem;
    color: #7C7C7C;
}

.widget-link {
    display: block;
    text-align: center;
    padding: 0.75rem;
    background: #F6F7F8;
    border-radius: 6px;
    color: #5BA3D0;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.875rem;
    margin-top: 0.75rem;
    transition: all 0.2s;
}

.widget-link:hover {
    background: #5BA3D0;
    color: white;
}

.simple-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.simple-list li {
    padding: 0.625rem 0;
    border-bottom: 1px solid #F0F0F0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 0.75rem;
}

.simple-list li:last-child {
    border-bottom: none;
}

.event-badge {
    font-size: 0.8rem;
    font-weight: 600;
    color: #5BA3D0;
    background: rgba(91, 163, 208, 0.1);
    padding: 0.25rem 0.625rem;
    border-radius: 12px;
    white-space: nowrap;
}

.event-name {
    font-size: 0.875rem;
    color: #333;
    flex: 1;
}

.avatar-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 0.75rem;
}

.avatar-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.avatar-circle {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: linear-gradient(135deg, #5BA3D0, #9B7EDE);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.875rem;
    flex-shrink: 0;
}

.avatar-name {
    font-size: 0.8rem;
    color: #333;
    font-weight: 500;
}

.announcement-banner {
    width: 100%;
    height: 120px;
    overflow: hidden;
    border-radius: 6px;
    margin-bottom: 0.75rem;
}

/* Comment Modal Styles */
.comment-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    animation: fadeIn 0.2s;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.comment-modal-content {
    background: white;
    border-radius: 12px;
    width: 90%;
    max-width: 700px;
    max-height: 85vh;
    display: flex;
    flex-direction: column;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    animation: slideUp 0.3s;
}

@keyframes slideUp {
    from { 
        opacity: 0;
        transform: translateY(50px);
    }
    to { 
        opacity: 1;
        transform: translateY(0);
    }
}

.comment-modal-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #E5E5E5;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.comment-modal-header h3 {
    margin: 0;
    font-size: 1.25rem;
    color: #1c1c1c;
    font-weight: 600;
}

.close-modal {
    background: none;
    border: none;
    font-size: 2rem;
    color: #999;
    cursor: pointer;
    line-height: 1;
    padding: 0;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all 0.2s;
}

.close-modal:hover {
    background: #f5f5f5;
    color: #333;
}

.comment-modal-body {
    flex: 1;
    overflow-y: auto;
    padding: 1.5rem;
    max-height: 400px;
}

.comments-list {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

.loading, .no-comments {
    text-align: center;
    color: #999;
    padding: 2rem;
    font-size: 0.95rem;
}

.comment-item {
    display: flex;
    gap: 0.75rem;
}

.comment-avatar {
    flex-shrink: 0;
}

.comment-avatar img, .comment-avatar .avatar-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

.comment-avatar .avatar-circle {
    background: linear-gradient(135deg, #5BA3D0, #9B7EDE);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 1rem;
}

.comment-content {
    flex: 1;
}

.comment-header {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.5rem;
}

.comment-header strong {
    color: #1c1c1c;
    font-size: 0.95rem;
}

.comment-time {
    color: #999;
    font-size: 0.85rem;
}

.comment-body {
    color: #333;
    font-size: 0.95rem;
    line-height: 1.5;
}

.comment-image {
    max-width: 100%;
    border-radius: 8px;
    margin-top: 0.5rem;
    display: block;
}

.comment-actions-btns {
    margin-top: 0.5rem;
    display: flex;
    gap: 0.5rem;
}

.edit-comment-btn {
    background: transparent;
    border: none;
    color: #5BA3D0;
    font-size: 0.85rem;
    cursor: pointer;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.edit-comment-btn:hover {
    background: #e3f2fd;
}

.delete-comment-btn {
    background: transparent;
    border: none;
    color: #ff4444;
    font-size: 0.85rem;
    cursor: pointer;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.delete-comment-btn:hover {
    background: #fff0f0;
}

.comment-modal-footer {
    padding: 1.25rem 1.5rem;
    border-top: 1px solid #E5E5E5;
    background: #fafafa;
}

.comment-input-wrapper {
    margin-bottom: 0.75rem;
}

.comment-textarea {
    width: 100%;
    border: 1px solid #E5E5E5;
    border-radius: 8px;
    padding: 0.75rem;
    font-size: 0.95rem;
    font-family: inherit;
    resize: none;
    transition: border-color 0.2s;
}

.comment-textarea:focus {
    outline: none;
    border-color: #5BA3D0;
}

.image-preview {
    margin-top: 0.75rem;
    position: relative;
    display: inline-block;
}

.image-preview img {
    max-width: 200px;
    max-height: 150px;
    border-radius: 8px;
    display: block;
}

.remove-image {
    position: absolute;
    top: -8px;
    right: -8px;
    background: #ff4444;
    color: white;
    border: none;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 1.25rem;
    line-height: 1;
    display: flex;
    align-items: center;
    justify-content: center;
}

.comment-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.comment-tools {
    display: flex;
    gap: 0.5rem;
}

.tool-btn {
    background: white;
    border: 1px solid #E5E5E5;
    width: 36px;
    height: 36px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: #666;
    font-size: 1.1rem;
    transition: all 0.2s;
}

.tool-btn:hover {
    background: #f5f5f5;
    border-color: #5BA3D0;
    color: #5BA3D0;
}

.submit-comment-btn {
    background: linear-gradient(135deg, #5BA3D0, #9B7EDE);
    color: white;
    border: none;
    padding: 0.6rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: transform 0.2s;
}

.submit-comment-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(91, 163, 208, 0.3);
}

.emoji-picker, .gif-picker {
    margin-top: 0.75rem;
    background: white;
    border: 1px solid #E5E5E5;
    border-radius: 8px;
    padding: 1rem;
    max-height: 200px;
    overflow-y: auto;
}

.emoji-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(32px, 1fr));
    gap: 0.5rem;
    font-size: 1.5rem;
    user-select: none;
}

.emoji-grid span {
    cursor: pointer;
    padding: 0.25rem;
    border-radius: 4px;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    user-select: none;
}

.emoji-grid span:hover {
    transform: scale(1.3);
    background: #f0f2f5;
}

.gif-search {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #E5E5E5;
    border-radius: 6px;
    margin-bottom: 0.75rem;
}

.gif-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 0.5rem;
}

.gif-item {
    width: 100%;
    height: 100px;
    object-fit: cover;
    border-radius: 6px;
    cursor: pointer;
    transition: transform 0.2s;
}

.gif-item:hover {
    transform: scale(1.05);
}


.announcement-banner img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.announcement-text {
    font-size: 0.875rem;
    color: #555;
    line-height: 1.5;
    margin: 0;
}

/* RESPONSIVE */
@media (max-width: 1200px) {
    .reddit-layout {
        grid-template-columns: 220px 1fr 280px;
    }
}

@media (max-width: 992px) {
    .reddit-layout {
        grid-template-columns: 1fr;
    }
    
    .left-sidebar,
    .right-sidebar {
        display: none;
    }
    
    .main-feed {
        max-width: 100%;
    }
}
</style>
@endpush

@push('scripts')
<script>
console.log('Script loaded');

// Like button functionality on home page
const likeButtons = document.querySelectorAll('.post-like-btn');
console.log('Found like buttons:', likeButtons.length);

likeButtons.forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        console.log('Like button clicked');
        const postId = this.dataset.postId;
        const likeCountSpan = this.querySelector('.like-count');
        const icon = this.querySelector('i');
        
        fetch(`/posts/${postId}/like`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            likeCountSpan.textContent = data.likes_count;
            
            if (data.liked) {
                this.classList.add('liked');
                icon.classList.remove('bi-heart');
                icon.classList.add('bi-heart-fill');
            } else {
                this.classList.remove('liked');
                icon.classList.remove('bi-heart-fill');
                icon.classList.add('bi-heart');
            }
        })
        .catch(error => console.error('Error:', error));
    });
});

// Comment Modal
const commentButtons = document.querySelectorAll('.comment-modal-btn');
console.log('Found comment buttons:', commentButtons.length);

commentButtons.forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        console.log('Comment button clicked');
        const postId = this.dataset.postId;
        const postTitle = this.dataset.postTitle;
        openCommentModal(postId, postTitle);
    });
});

function openCommentModal(postId, postTitle) {
    // Create modal
    const modal = document.createElement('div');
    modal.className = 'comment-modal';
    modal.innerHTML = `
        <div class="comment-modal-content">
            <div class="comment-modal-header">
                <h3>${postTitle}</h3>
                <button class="close-modal">&times;</button>
            </div>
            <div class="comment-modal-body">
                <div class="comments-list" id="comments-list-${postId}">
                    <div class="loading">Đang tải bình luận...</div>
                </div>
            </div>
            <div class="comment-modal-footer">
                <form class="comment-form" data-post-id="${postId}">
                    <div class="comment-input-wrapper">
                        <textarea class="comment-textarea" placeholder="Viết bình luận..." rows="3"></textarea>
                        <input type="file" id="comment-image-${postId}" accept="image/*" style="display: none;">
                        <div class="image-preview" id="image-preview-${postId}" style="display: none;">
                            <img src="" alt="Preview">
                            <button type="button" class="remove-image">&times;</button>
                        </div>
                    </div>
                    <div class="comment-actions">
                        <div class="comment-tools">
                            <button type="button" class="tool-btn" onclick="document.getElementById('comment-image-${postId}').click()" title="Thêm ảnh">
                                <i class="bi bi-image"></i>
                            </button>
                            <button type="button" class="tool-btn gif-btn" title="Thêm GIF">
                                <i class="bi bi-file-play"></i>
                            </button>
                            <button type="button" class="tool-btn emoji-btn" title="Emoji">
                                <i class="bi bi-emoji-smile"></i>
                            </button>
                        </div>
                        <button type="submit" class="submit-comment-btn">Gửi</button>
                    </div>
                    <div class="emoji-picker" style="display: none;">
                        <div class="emoji-grid">
                            <span>😀</span><span>😃</span><span>😄</span><span>😁</span><span>😆</span><span>😅</span><span>😂</span><span>🤣</span><span>😊</span><span>😇</span><span>🙂</span><span>🙃</span><span>😉</span><span>😌</span><span>😍</span><span>🥰</span><span>😘</span><span>😗</span><span>😙</span><span>😚</span><span>😋</span><span>😛</span><span>😝</span><span>😜</span><span>🤪</span><span>🤨</span><span>🧐</span><span>🤓</span><span>😎</span><span>🤩</span><span>🥳</span><span>😏</span><span>😒</span><span>😞</span><span>😔</span><span>😟</span><span>😕</span><span>🙁</span><span>☹️</span><span>😣</span><span>😖</span><span>😫</span><span>😩</span><span>🥺</span><span>😢</span><span>😭</span><span>😤</span><span>😠</span><span>😡</span><span>🤬</span><span>🤯</span><span>😳</span><span>🥵</span><span>🥶</span><span>😱</span><span>😨</span><span>😰</span><span>😥</span><span>😓</span><span>🤗</span><span>🤔</span><span>🤭</span><span>🤫</span><span>🤥</span><span>😶</span><span>😐</span><span>😑</span><span>😬</span><span>🙄</span><span>😯</span><span>😦</span><span>😧</span><span>😮</span><span>😲</span><span>🥱</span><span>😴</span><span>🤤</span><span>😪</span><span>😵</span><span>🤐</span><span>🥴</span><span>🤢</span><span>🤮</span><span>🤧</span><span>😷</span><span>🤒</span><span>🤕</span><span>🤑</span><span>🤠</span><span>👍</span><span>👎</span><span>👊</span><span>✊</span><span>🤛</span><span>🤜</span><span>🤞</span><span>✌️</span><span>🤟</span><span>🤘</span><span>👌</span><span>🤌</span><span>🤏</span><span>👈</span><span>👉</span><span>👆</span><span>👇</span><span>☝️</span><span>✋</span><span>🤚</span><span>🖐</span><span>🖖</span><span>👋</span><span>🤙</span><span>💪</span><span>🙏</span><span>❤️</span><span>🧡</span><span>💛</span><span>💚</span><span>💙</span><span>💜</span><span>🖤</span><span>🤍</span><span>🤎</span><span>💔</span><span>❣️</span><span>💕</span><span>💞</span><span>💓</span><span>💗</span><span>💖</span><span>💘</span><span>💝</span><span>✨</span><span>💫</span><span>⭐</span><span>🌟</span><span>✅</span><span>❌</span><span>🔥</span><span>💯</span><span>👏</span><span>🎉</span><span>🎊</span>
                        </div>
                    </div>
                    <div class="gif-picker" style="display: none;">
                        <input type="text" class="gif-search" placeholder="Tìm GIF...">
                        <div class="gif-grid">
                            <img src="https://media.giphy.com/media/ICOgUNjpvO0PC/giphy.gif" class="gif-item" alt="GIF">
                            <img src="https://media.giphy.com/media/MDJ9IbxxvDUQM/giphy.gif" class="gif-item" alt="GIF">
                            <img src="https://media.giphy.com/media/11sBLVxNs7v6WA/giphy.gif" class="gif-item" alt="GIF">
                            <img src="https://media.giphy.com/media/ZBQhoZC0nqknSviPqT/giphy.gif" class="gif-item" alt="GIF">
                            <img src="https://media.giphy.com/media/vFKqnCdLPNOKc/giphy.gif" class="gif-item" alt="GIF">
                            <img src="https://media.giphy.com/media/12NUbkX6p4xOO4/giphy.gif" class="gif-item" alt="GIF">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    `;
    document.body.appendChild(modal);

    // Load comments
    loadComments(postId);

    // Close modal
    modal.querySelector('.close-modal').addEventListener('click', () => modal.remove());
    modal.addEventListener('click', (e) => {
        if (e.target === modal) modal.remove();
    });

    // Image preview
    const imageInput = document.getElementById(`comment-image-${postId}`);
    const imagePreview = document.getElementById(`image-preview-${postId}`);
    imageInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.querySelector('img').src = e.target.result;
                imagePreview.style.display = 'block';
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    imagePreview.querySelector('.remove-image').addEventListener('click', () => {
        imageInput.value = '';
        imagePreview.style.display = 'none';
    });

    // Emoji picker
    const emojiBtn = modal.querySelector('.emoji-btn');
    const emojiPicker = modal.querySelector('.emoji-picker');
    emojiBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        emojiPicker.style.display = emojiPicker.style.display === 'none' ? 'block' : 'none';
        modal.querySelector('.gif-picker').style.display = 'none';
    });

    // Add emoji click handlers for each span
    emojiPicker.querySelectorAll('span').forEach(emojiSpan => {
        emojiSpan.addEventListener('click', (e) => {
            e.stopPropagation();
            const textarea = modal.querySelector('.comment-textarea');
            const emoji = emojiSpan.textContent;
            const cursorPos = textarea.selectionStart || 0;
            const textBefore = textarea.value.substring(0, cursorPos);
            const textAfter = textarea.value.substring(cursorPos);
            
            textarea.value = textBefore + emoji + textAfter;
            
            // Set cursor position after emoji
            const newPos = cursorPos + emoji.length;
            textarea.focus();
            textarea.setSelectionRange(newPos, newPos);
            
            emojiPicker.style.display = 'none';
        });
    });

    // GIF picker
    const gifBtn = modal.querySelector('.gif-btn');
    const gifPicker = modal.querySelector('.gif-picker');
    gifBtn.addEventListener('click', () => {
        gifPicker.style.display = gifPicker.style.display === 'none' ? 'block' : 'none';
        emojiPicker.style.display = 'none';
    });

    gifPicker.querySelectorAll('.gif-item').forEach(gif => {
        gif.addEventListener('click', () => {
            const textarea = modal.querySelector('.comment-textarea');
            // Thay vì gán link vào textarea, ta gán vào một trường ẩn và hiển thị preview
            const imagePreview = document.getElementById(`image-preview-${postId}`);
            imagePreview.querySelector('img').src = gif.src;
            imagePreview.style.display = 'block';
            imagePreview.dataset.gifUrl = gif.src;
            gifPicker.style.display = 'none';
        });
    });

    // Submit comment
    modal.querySelector('.comment-form').addEventListener('submit', function(e) {
        e.preventDefault();
        submitComment(this, postId);
    });
}

function loadComments(postId) {
    fetch(`/posts/${postId}/comments`)
        .then(response => response.json())
        .then(data => {
            const commentsList = document.getElementById(`comments-list-${postId}`);
            if (data.comments.length === 0) {
                commentsList.innerHTML = '<div class="no-comments">Chưa có bình luận nào</div>';
            } else {
                commentsList.innerHTML = data.comments.map(comment => `
                    <div class="comment-item" data-comment-id="${comment.id}">
                        <div class="comment-avatar">
                            ${comment.user.profile_photo ? 
                                `<img src="/storage/${comment.user.profile_photo}" alt="${comment.user.name}">` :
                                `<div class="avatar-circle">${comment.user.name.charAt(0).toUpperCase()}</div>`
                            }
                        </div>
                        <div class="comment-content">
                            <div class="comment-header">
                                <strong>${comment.user.name}</strong>
                                <span class="comment-time">${comment.created_at}</span>
                            </div>
                            <div class="comment-body" data-comment-id="${comment.id}">
                                ${isImageUrl(comment.content) ? `<img src="${comment.content}" class="comment-image">` : comment.content}
                                ${comment.image ? `<img src="${comment.image}" class="comment-image">` : ''}
                            </div>
                            ${comment.can_delete ? `
                            <div class="comment-actions-btns">
                                <button class="edit-comment-btn" data-comment-id="${comment.id}" data-comment-content="${escapeHtml(comment.content)}">
                                    <i class="bi bi-pencil"></i> Sửa
                                </button>
                                <button class="delete-comment-btn" data-comment-id="${comment.id}">
                                    <i class="bi bi-trash"></i> Xóa
                                </button>
                            </div>
                            ` : ''}
                        </div>
                    </div>
                `).join('');
                
                // Add delete event listeners
                commentsList.querySelectorAll('.delete-comment-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        deleteComment(this.dataset.commentId, postId);
                    });
                });
                
                // Add edit event listeners
                commentsList.querySelectorAll('.edit-comment-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        editComment(this.dataset.commentId, this.dataset.commentContent, postId);
                    });
                });
            }
        });
}

// Helper function to check if string is image URL
function isImageUrl(str) {
    return str && (str.startsWith('http://') || str.startsWith('https://')) && 
           (str.includes('giphy.com') || str.match(/\.(gif|jpg|jpeg|png|webp)(\?.*)?$/i));
}

// Helper function to escape HTML
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function submitComment(form, postId) {
    const formData = new FormData();
    const textarea = form.querySelector('.comment-textarea');
    const imageInput = document.getElementById(`comment-image-${postId}`);
    const imagePreview = document.getElementById(`image-preview-${postId}`);
    
    // Nếu có GIF được chọn
    if (imagePreview.dataset.gifUrl) {
        formData.append('content', imagePreview.dataset.gifUrl);
    } else if (textarea.value.trim()) {
        formData.append('content', textarea.value);
    } else {
        // Nếu không có GIF và không có text, yêu cầu nhập nội dung
        alert('Vui lòng nhập nội dung bình luận!');
        return;
    }
    
    if (imageInput.files[0]) {
        formData.append('image', imageInput.files[0]);
    }

    fetch(`/posts/${postId}/comments`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            textarea.value = '';
            imageInput.value = '';
            const imagePreview = document.getElementById(`image-preview-${postId}`);
            imagePreview.style.display = 'none';
            if (imagePreview.dataset.gifUrl) {
                delete imagePreview.dataset.gifUrl;
            }
            loadComments(postId);
            
            // Update comment count in the button
            updateCommentCount(postId);
        }
    });
}

function updateCommentCount(postId) {
    // Update the comment count on the post card
    const commentBtn = document.querySelector(`.comment-modal-btn[data-post-id="${postId}"]`);
    if (commentBtn) {
        fetch(`/posts/${postId}/comments`)
            .then(response => response.json())
            .then(data => {
                const count = data.comments.length;
                commentBtn.innerHTML = `
                    <i class="bi bi-chat"></i>
                    ${count} Comments
                `;
            });
    }
}

function editComment(commentId, currentContent, postId) {
    const commentBody = document.querySelector(`.comment-body[data-comment-id="${commentId}"]`);
    if (!commentBody) return;
    
    // Tạo textarea để edit
    const isImage = isImageUrl(currentContent);
    const textarea = document.createElement('textarea');
    textarea.className = 'comment-textarea';
    textarea.value = currentContent;
    textarea.rows = 3;
    
    const saveBtn = document.createElement('button');
    saveBtn.className = 'submit-comment-btn';
    saveBtn.textContent = 'Lưu';
    saveBtn.style.marginTop = '0.5rem';
    saveBtn.style.marginRight = '0.5rem';
    
    const cancelBtn = document.createElement('button');
    cancelBtn.className = 'tool-btn';
    cancelBtn.textContent = 'Hủy';
    cancelBtn.style.marginTop = '0.5rem';
    
    const originalHTML = commentBody.innerHTML;
    commentBody.innerHTML = '';
    commentBody.appendChild(textarea);
    commentBody.appendChild(saveBtn);
    commentBody.appendChild(cancelBtn);
    
    cancelBtn.addEventListener('click', () => {
        commentBody.innerHTML = originalHTML;
    });
    
    saveBtn.addEventListener('click', () => {
        const newContent = textarea.value.trim();
        if (!newContent) {
            alert('Nội dung không được để trống!');
            return;
        }
        
        fetch(`/comments/${commentId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ content: newContent })
        })
        .then(response => {
            if (response.ok) {
                loadComments(postId);
            } else {
                alert('Có lỗi xảy ra khi cập nhật bình luận!');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra!');
        });
    });
}

function deleteComment(commentId, postId) {
    if (!confirm('Bạn có chắc muốn xóa bình luận này?')) {
        return;
    }
    
    fetch(`/comments/${commentId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => {
        if (response.ok) {
            loadComments(postId);
            updateCommentCount(postId);
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>

<style>
.category-tabs {
    display: flex;
    gap: 0.5rem;
}

.category-tab {
    cursor: pointer;
}

.category-tab:hover:not(.active) {
    background: #f5f5f5 !important;
}

.category-tab.active {
    background: #1a73e8 !important;
    color: white !important;
}
</style>
@endpush
@endsection
