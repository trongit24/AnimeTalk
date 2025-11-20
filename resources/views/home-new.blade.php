@extends('layouts.app')

@section('title', 'Home - AnimeTalk')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')
<!-- Sidebar Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="reddit-layout">
    <!-- Left Sidebar -->
    <aside class="left-sidebar" id="leftSidebar">
        <div class="sidebar-section">
            <h3 class="sidebar-title">MENU</h3>
            <ul class="sidebar-menu">
                <li class="active">
                    <a href="{{ route('home') }}">
                        <i class="bi bi-house-door-fill"></i>
                        <span>Home</span>
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
            <h3 class="sidebar-title">EVENTS</h3>
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('events.index') }}" class="sidebar-link">
                        <i class="bi bi-calendar-event"></i>
                        <span>Browse Events</span>
                    </a>
                </li>
                @auth
                <li>
                    <a href="{{ route('events.create') }}" class="sidebar-link">
                        <i class="bi bi-calendar-plus"></i>
                        <span>Create Event</span>
                    </a>
                </li>
                @endauth
            </ul>
        </div>
    </aside>

    <!-- Main Feed -->
    <main class="main-feed">
        <!-- Category Tabs -->
        <div class="category-tabs">
            <a href="{{ route('home', ['category' => 'all']) }}" 
               class="category-tab {{ (!isset($category) || $category == 'all') ? 'active' : '' }}">
                <i class="bi bi-grid-3x3"></i> All
            </a>
            <a href="{{ route('home', ['category' => 'anime']) }}" 
               class="category-tab {{ (isset($category) && $category == 'anime') ? 'active' : '' }}">
                <i class="bi bi-play-circle"></i> Anime
            </a>
            <a href="{{ route('home', ['category' => 'manga']) }}" 
               class="category-tab {{ (isset($category) && $category == 'manga') ? 'active' : '' }}">
                <i class="bi bi-book"></i> Manga
            </a>
            <a href="{{ route('home', ['category' => 'cosplay']) }}" 
               class="category-tab {{ (isset($category) && $category == 'cosplay') ? 'active' : '' }}">
                <i class="bi bi-mask"></i> Cosplay
            </a>
            <a href="{{ route('home', ['category' => 'discussion']) }}" 
               class="category-tab {{ (isset($category) && $category == 'discussion') ? 'active' : '' }}">
                <i class="bi bi-chat-dots"></i> Discussion
            </a>
        </div>

        <!-- Create Post Box -->
        @auth
        <div class="create-box">
            @if(auth()->user()->profile_photo)
                <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="{{ auth()->user()->name }}" class="user-avatar-circle">
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
        <article class="feed-card" style="background: white !important; margin-bottom: 1rem !important; padding: 1rem !important; border-radius: 8px !important; box-shadow: 0 2px 8px rgba(0,0,0,0.1) !important;">
            <div class="card-body" style="padding: 0 !important;">
                <div class="card-meta" style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                    @if($post->user->profile_photo)
                    <img src="{{ asset('storage/' . $post->user->profile_photo) }}" alt="{{ $post->user->name }}" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                    @else
                    <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1rem;">
                        {{ strtoupper(substr($post->user->name, 0, 1)) }}
                    </div>
                    @endif
                    <span class="meta-author" style="font-weight: 600; color: #1c1c1c !important; font-size: 0.95rem;">{{ $post->user->name }}</span>
                    <span class="meta-dot" style="color: #999;">•</span>
                    <time class="meta-time" style="color: #666 !important; font-size: 0.9rem;">{{ $post->created_at->diffForHumans() }}</time>
                </div>

                <a href="{{ route('posts.show', $post->slug) }}" style="text-decoration: none; color: inherit; display: block;">
                    @if($post->background)
                        @php
                            $gradients = [
                                'gradient-1' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                                'gradient-2' => 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
                                'gradient-3' => 'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)',
                                'gradient-4' => 'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)',
                                'gradient-5' => 'linear-gradient(135deg, #fa709a 0%, #fee140 100%)',
                                'gradient-6' => 'linear-gradient(135deg, #30cfd0 0%, #330867 100%)',
                                'gradient-7' => 'linear-gradient(135deg, #a8edea 0%, #fed6e3 100%)',
                                'gradient-8' => 'linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%)'
                            ];
                            $bgGradient = $gradients[$post->background] ?? 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
                        @endphp
                        <div style="background: {{ $bgGradient }}; min-height: 300px; border-radius: 12px; display: flex; align-items: center; justify-content: center; padding: 2rem; margin-bottom: 1rem;">
                            <p style="color: white !important; font-size: 24px !important; font-weight: 600 !important; text-align: center !important; line-height: 1.4 !important; max-width: 500px !important; word-wrap: break-word !important; text-shadow: 0 2px 4px rgba(0,0,0,0.3) !important; margin: 0 !important;">
                                {!! nl2br(e($post->content)) !!}
                            </p>
                        </div>
                    @else
                        <p class="card-text" style="color: #1c1c1c !important; font-size: 1rem !important; line-height: 1.6 !important; margin-bottom: 1rem !important;">{{ $post->content }}</p>
                    @endif
                    
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

                <!-- Post Stats -->
                <div style="padding: 12px 0; border-bottom: 1px solid #e4e6eb; display: flex; justify-content: space-between; align-items: center; font-size: 14px; color: #65676b;">
                    <div>
                        @if($post->likes()->count() > 0)
                        <span><i class="bi bi-heart-fill" style="color: #FF6B9D;"></i> {{ $post->likes()->count() }}</span>
                        @endif
                    </div>
                    <div>
                        @if($post->comments->count() > 0)
                        <span>{{ $post->comments->count() }} bình luận</span>
                        @endif
                    </div>
                </div>

                <div class="card-actions">
                    @auth
                    <button class="action-btn post-like-btn {{ $post->likedBy(auth()->user()) ? 'liked' : '' }}" data-post-id="{{ $post->id }}">
                        <i class="bi {{ $post->likedBy(auth()->user()) ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                        <span>Thích</span>
                    </button>
                    @else
                    <a href="{{ route('login') }}" class="action-btn">
                        <i class="bi bi-heart"></i>
                        <span>Thích</span>
                    </a>
                    @endauth
                    
                    <button class="action-btn comment-modal-btn" data-post-id="{{ $post->id }}" data-post-title="{{ $post->title }}">
                        <i class="bi bi-chat"></i>
                        <span>Bình luận</span>
                    </button>
                    
                    <button class="action-btn">
                        <i class="bi bi-share"></i>
                        <span>Chia sẻ</span>
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
        <div class="widget" style="background: white !important; border-radius: 16px; padding: 1.5rem; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1); border: 1px solid rgba(255, 255, 255, 0.6); opacity: 1 !important; visibility: visible !important;" data-aos="fade-left" data-aos-duration="800">
            <h3 class="widget-title" style="color: #1c1c1c !important;">🔥 Top Posts</h3>
            <ul class="event-list">
                @foreach($topPosts as $topPost)
                <li class="event-item" style="cursor: pointer;" onclick="window.location='{{ route('posts.show', $topPost->slug) }}'">
                    @if($topPost->background)
                        @php
                            $gradients = [
                                'gradient-1' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                                'gradient-2' => 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
                                'gradient-3' => 'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)',
                                'gradient-4' => 'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)',
                                'gradient-5' => 'linear-gradient(135deg, #fa709a 0%, #fee140 100%)',
                                'gradient-6' => 'linear-gradient(135deg, #30cfd0 0%, #330867 100%)',
                                'gradient-7' => 'linear-gradient(135deg, #a8edea 0%, #fed6e3 100%)',
                                'gradient-8' => 'linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%)'
                            ];
                            $bgGradient = $gradients[$topPost->background] ?? 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
                        @endphp
                        <div style="background: {{ $bgGradient }}; width: 50px; height: 50px; border-radius: 8px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; color: white; font-size: 18px; font-weight: 700; padding: 4px; text-align: center; line-height: 1.2; overflow: hidden;">
                            <span style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; font-size: 10px;">
                                {{ Str::limit($topPost->content, 20) }}
                            </span>
                        </div>
                    @elseif($topPost->video)
                        <div style="width: 50px; height: 50px; border-radius: 8px; overflow: hidden; flex-shrink: 0; position: relative; background: #000;">
                            <video style="width: 100%; height: 100%; object-fit: cover;">
                                <source src="{{ asset('storage/' . $topPost->video) }}" type="video/mp4">
                            </video>
                            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: rgba(0,0,0,0.6); border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-play-fill" style="color: white; font-size: 0.8rem;"></i>
                            </div>
                        </div>
                    @elseif($topPost->image)
                        <img src="{{ asset('storage/' . $topPost->image) }}" alt="{{ $topPost->title }}" 
                             style="width: 50px; height: 50px; border-radius: 8px; object-fit: cover; flex-shrink: 0;">
                    @else
                        <div style="background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; min-width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; border-radius: 8px; font-weight: 700; font-size: 16px;">
                            {{ strtoupper(substr($topPost->user->name ?? 'A', 0, 1)) }}
                        </div>
                    @endif
                    <div class="event-details">
                        <div class="event-title">{{ Str::limit($topPost->content, 40) }}</div>
                        <div class="event-type" style="color: #FF6B6B; font-weight: 600;">
                            {{ number_format($topPost->interactions_count) }} tương tác
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>

        <!-- Top Communities -->
        <div class="widget" style="background: white !important; border-radius: 16px; padding: 1.5rem; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1); border: 1px solid rgba(255, 255, 255, 0.6); opacity: 1 !important; visibility: visible !important;" data-aos="fade-left" data-aos-duration="800" data-aos-delay="100">
            <h3 class="widget-title" style="color: #1c1c1c !important;">🌟 Top Communities</h3>
            <ul class="event-list">
                @foreach($topCommunities as $index => $community)
                <li class="event-item" style="cursor: pointer;" onclick="window.location='{{ route('communities.show', $community->slug) }}'">
                    @if($community->icon)
                        <img src="{{ asset('storage/' . $community->icon) }}" alt="{{ $community->name }}" 
                             style="width: 50px; height: 50px; border-radius: 8px; object-fit: cover; flex-shrink: 0; border: 2px solid {{ $index == 0 ? '#FFD700' : ($index == 1 ? '#C0C0C0' : ($index == 2 ? '#CD7F32' : '#e0e0e0')) }};">
                    @else
                        <div class="event-date" style="background: linear-gradient(135deg, {{ $index == 0 ? '#FFD700, #FFA500' : ($index == 1 ? '#C0C0C0, #A8A8A8' : ($index == 2 ? '#CD7F32, #A0522D' : '#5BA3D0, #9B7EDE')) }}); color: white; min-width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; border-radius: 8px; font-weight: 700; font-size: 1.25rem;">
                            {{ strtoupper(substr($community->name, 0, 1)) }}
                        </div>
                    @endif
                    <div class="event-details">
                        <div class="event-title">
                            <span style="background: {{ $index == 0 ? 'linear-gradient(135deg, #FFD700, #FFA500)' : ($index == 1 ? 'linear-gradient(135deg, #C0C0C0, #A8A8A8)' : ($index == 2 ? 'linear-gradient(135deg, #CD7F32, #A0522D)' : 'linear-gradient(135deg, #5BA3D0, #9B7EDE)')) }}; color: white; padding: 0.125rem 0.375rem; border-radius: 4px; font-size: 0.7rem; font-weight: 700; margin-right: 0.375rem;">#{{ $index + 1 }}</span>
                            {{ Str::limit($community->name, 25) }}
                        </div>
                        <div class="event-type" style="color: #667eea; font-weight: 600;">
                            <i class="bi bi-people-fill"></i> {{ number_format($community->members_count) }} members
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
            <a href="{{ route('communities.index') }}" class="widget-link">View All Communities →</a>
        </div>
    </aside>
</div>

@push('styles')
<style>
/* Shinkai-style Home Page */
body {
    background: transparent !important;
    margin: 0;
    font-family: 'Inter', 'Noto Sans JP', sans-serif;
}

.reddit-layout {
    display: grid;
    grid-template-columns: 280px 1fr 340px;
    gap: 24px;
    max-width: 1600px;
    margin: 0 auto;
    padding: 24px;
    min-height: 100vh;
}

/* LEFT SIDEBAR - Glassmorphism */
.left-sidebar {
    background: rgba(255, 255, 255, 0.25);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 20px;
    padding: 1.5rem;
    height: fit-content;
    position: sticky;
    top: 100px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.left-sidebar:hover {
    background: rgba(255, 255, 255, 0.35);
    box-shadow: 0 12px 48px rgba(0, 0, 0, 0.15);
    transform: translateY(-3px);
}

.sidebar-title {
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 1.5px;
    background: linear-gradient(135deg, #4A90E2, #9B59B6);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 1rem;
}

.sidebar-menu {
    list-style: none;
    padding: 0;
    margin: 0 0 1rem 0;
}

.sidebar-menu li {
    margin-bottom: 0.5rem;
}

.sidebar-menu a {
    display: flex;
    align-items: center;
    gap: 0.875rem;
    padding: 0.875rem 1rem;
    color: #2C3E50;
    text-decoration: none;
    border-radius: 12px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    font-weight: 500;
    font-size: 0.95rem;
    position: relative;
    overflow: hidden;
}

.sidebar-menu a::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: left 0.5s;
}

.sidebar-menu a:hover::before {
    left: 100%;
}

.sidebar-menu a:hover {
    background: rgba(74, 144, 226, 0.15);
    transform: translateX(5px);
    box-shadow: 0 4px 12px rgba(74, 144, 226, 0.2);
}

.sidebar-menu li.active a {
    background: linear-gradient(135deg, #4A90E2, #9B59B6);
    color: white;
    box-shadow: 0 4px 15px rgba(74, 144, 226, 0.4);
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
    background: rgba(255, 255, 255, 0.3);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.4);
    border-radius: 20px;
    margin-bottom: 1.5rem;
    padding: 1.25rem 1.5rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.feed-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.6s;
}

.feed-card:hover::before {
    left: 100%;
}

.feed-card:hover {
    background: rgba(255, 255, 255, 0.4);
    box-shadow: 0 12px 48px rgba(0, 0, 0, 0.15);
    transform: translateY(-5px);
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
    background: rgba(255, 255, 255, 0.5);
    border: 1px solid rgba(255, 255, 255, 0.3);
    backdrop-filter: blur(10px);
    color: #2C3E50;
    font-size: 0.875rem;
    font-weight: 600;
    padding: 0.625rem 1rem;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
    position: relative;
    overflow: hidden;
}

.action-btn::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(74, 144, 226, 0.2);
    transform: translate(-50%, -50%);
    transition: width 0.4s, height 0.4s;
}

.action-btn:hover::before {
    width: 200px;
    height: 200px;
}

.action-btn:hover {
    background: rgba(255, 255, 255, 0.7);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(74, 144, 226, 0.2);
}

.post-like-btn.liked {
    background: linear-gradient(135deg, #FF6B9D, #FF9A56);
    color: white;
    box-shadow: 0 4px 15px rgba(255, 107, 157, 0.4);
}

.post-like-btn.liked i {
    color: #FF6B9D;
}

/* RIGHT SIDEBAR */
.right-sidebar {
    height: fit-content;
    position: sticky;
    top: 100px;
}

.widget {
    background: rgba(255, 255, 255, 0.25);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 20px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.widget:hover {
    background: rgba(255, 255, 255, 0.35);
    box-shadow: 0 12px 48px rgba(0, 0, 0, 0.15);
    transform: translateY(-3px);
}

.widget-title {
    font-size: 0.875rem;
    font-weight: 700;
    background: linear-gradient(135deg, #4A90E2, #9B59B6);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin: 0 0 1rem 0;
    text-transform: uppercase;
    letter-spacing: 1px;
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
console.log('🚀 Home page script loaded');

// Giphy API Configuration
const GIPHY_API_KEY = '2UNLRUTAqLhcKD4ZX3mZZpn5Tw1eVryk';
const GIPHY_LIMIT = 20;
let gifSearchTimeout;

// Load trending anime GIFs for home page
async function loadHomeGIFs() {
    const gifGrid = document.getElementById('home-gif-grid');
    const gifLoading = document.getElementById('home-gif-loading');
    
    if (!gifGrid || !gifLoading) return;
    
    try {
        gifLoading.style.display = 'block';
        gifGrid.innerHTML = '';
        
        const url = `https://api.giphy.com/v1/gifs/search?api_key=${GIPHY_API_KEY}&q=anime&limit=${GIPHY_LIMIT}&rating=g`;
        const response = await fetch(url);
        
        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
        
        const data = await response.json();
        gifLoading.style.display = 'none';
        
        if (data.data && data.data.length > 0) {
            data.data.forEach(gif => {
                const img = document.createElement('img');
                img.src = gif.images.fixed_height.url;
                img.className = 'gif-item';
                img.alt = gif.title || 'GIF';
                img.style.cursor = 'pointer';
                img.addEventListener('click', function() {
                    selectHomeGIF(gif.images.original.url);
                });
                gifGrid.appendChild(img);
            });
        }
    } catch (error) {
        console.error('Error loading GIFs:', error);
        gifLoading.style.display = 'none';
        gifGrid.innerHTML = '<p style="text-align:center;color:#65676b;padding:20px;">Không thể tải GIF</p>';
    }
}

// Search GIFs for home page
async function searchHomeGIFs(query) {
    if (!query.trim()) {
        loadHomeGIFs();
        return;
    }
    
    const gifGrid = document.getElementById('home-gif-grid');
    const gifLoading = document.getElementById('home-gif-loading');
    
    try {
        gifLoading.style.display = 'block';
        gifGrid.innerHTML = '';
        
        const url = `https://api.giphy.com/v1/gifs/search?api_key=${GIPHY_API_KEY}&q=${encodeURIComponent(query)}&limit=${GIPHY_LIMIT}&rating=g`;
        const response = await fetch(url);
        const data = await response.json();
        
        gifLoading.style.display = 'none';
        
        if (data.data && data.data.length > 0) {
            data.data.forEach(gif => {
                const img = document.createElement('img');
                img.src = gif.images.fixed_height.url;
                img.className = 'gif-item';
                img.alt = gif.title || 'GIF';
                img.style.cursor = 'pointer';
                img.addEventListener('click', function() {
                    selectHomeGIF(gif.images.original.url);
                });
                gifGrid.appendChild(img);
            });
        } else {
            gifGrid.innerHTML = '<p style="text-align:center;color:#65676b;padding:20px;">Không tìm thấy GIF</p>';
        }
    } catch (error) {
        console.error('Error searching GIFs:', error);
        gifLoading.style.display = 'none';
    }
}

// Select GIF for home page
function selectHomeGIF(gifUrl) {
    // Get the active modal
    const activeModal = document.querySelector('.comment-modal[style*="display: flex"]');
    if (!activeModal) return;
    
    const postId = activeModal.id.replace('comment-modal-', '');
    const imagePreview = document.getElementById(`image-preview-${postId}`);
    
    if (imagePreview) {
        imagePreview.querySelector('img').src = gifUrl;
        imagePreview.style.display = 'block';
        imagePreview.dataset.gifUrl = gifUrl;
    }
    
    // Hide GIF picker
    const gifPicker = activeModal.querySelector('.gif-picker');
    if (gifPicker) gifPicker.style.display = 'none';
}

// Like button functionality on home page
const likeButtons = document.querySelectorAll('.post-like-btn');
console.log('Found like buttons:', likeButtons.length);

likeButtons.forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        console.log('Like button clicked');
        const postId = this.dataset.postId;
        const icon = this.querySelector('i');
        const card = this.closest('article');
        
        fetch(`/posts/${postId}/like`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            // Update like count display
            const likeCountDiv = card.querySelector('.card-actions').previousElementSibling;
            const likeCountSpan = likeCountDiv.querySelector('.bi-heart-fill')?.parentElement;
            
            if (data.likes_count > 0) {
                if (likeCountSpan) {
                    likeCountSpan.innerHTML = `<i class="bi bi-heart-fill" style="color: #FF6B9D;"></i> ${data.likes_count}`;
                } else {
                    const firstDiv = likeCountDiv.querySelector('div');
                    firstDiv.innerHTML = `<span><i class="bi bi-heart-fill" style="color: #FF6B9D;"></i> ${data.likes_count}</span>`;
                }
            } else {
                if (likeCountSpan) {
                    likeCountSpan.innerHTML = '';
                }
            }
            
            // Update button state
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
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to like post. Please try again.');
        });
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
                    <div class="gif-picker" id="home-gif-picker" style="display: none;">
                        <input type="text" class="gif-search" id="home-gif-search" placeholder="Tìm kiếm GIF anime..." autocomplete="off">
                        <div class="gif-loading" id="home-gif-loading" style="display: none; text-align: center; padding: 20px; color: #65676b;">
                            <i class="bi bi-arrow-repeat" style="font-size: 24px; animation: spin 1s linear infinite;"></i>
                            <p style="margin-top: 8px; font-size: 13px;">Đang tìm kiếm...</p>
                        </div>
                        <div class="gif-grid" id="home-gif-grid">
                            <!-- Trending anime GIFs will load here via Giphy API -->
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
        const isVisible = gifPicker.style.display === 'block';
        gifPicker.style.display = isVisible ? 'none' : 'block';
        emojiPicker.style.display = 'none';
        
        // Load GIFs when opening
        if (!isVisible) {
            loadHomeGIFs();
        }
    });
    
    // GIF search input
    const gifSearchInput = modal.querySelector('#home-gif-search');
    if (gifSearchInput) {
        gifSearchInput.addEventListener('input', function() {
            clearTimeout(gifSearchTimeout);
            gifSearchTimeout = setTimeout(() => {
                searchHomeGIFs(this.value);
            }, 500);
        });
    }

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
