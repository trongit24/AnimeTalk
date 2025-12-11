@extends('layouts.app')

@section('title', $post->title)

@push('styles')
<style>
.fb-post-detail-page,
.fb-post-detail-page * {
    opacity: 1 !important;
    visibility: visible !important;
}
.fb-post-container {
    background: rgba(255, 255, 255, 0.3);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
}
.fb-info-section {
    background: transparent !important;
}
</style>
@endpush

@section('content')
<!-- Mobile Back Button -->
<button class="mobile-back-btn" onclick="window.history.back()">
    <i class="bi bi-arrow-left"></i>
    <span>Back</span>
</button>

<!-- Hidden Post Warning -->
@if($post->is_hidden)
<div class="container my-3">
    <div class="alert alert-warning d-flex align-items-center" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-3" style="font-size: 1.5rem;"></i>
        <div class="flex-grow-1">
            <h5 class="alert-heading mb-1">Bài viết đã bị ẩn</h5>
            <p class="mb-0">{{ $post->hidden_reason ?? 'Bài viết này đã bị ẩn do vi phạm chính sách cộng đồng.' }}</p>
            @if($post->hidden_at)
            <small class="text-muted">Ẩn lúc: {{ $post->hidden_at->format('d/m/Y H:i') }}</small>
            @endif
        </div>
    </div>
</div>
@endif

<div class="fb-post-detail-page">
    <div class="fb-post-container">
        <!-- Left Side - Media -->
        <div class="fb-media-section">
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
                <div class="fb-background-post" style="background: {{ $bgGradient }};">
                    <div class="fb-background-content">
                        {!! nl2br(e($post->content)) !!}
                    </div>
                </div>
            @elseif($post->image)
                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="fb-main-image">
            @elseif($post->video)
                <video controls class="fb-main-video">
                    <source src="{{ asset('storage/' . $post->video) }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            @else
                <div class="fb-no-media">
                    <i class="bi bi-image" style="font-size: 4rem; color: #ccc;"></i>
                    <p>No media attached</p>
                </div>
            @endif
        </div>

        <!-- Right Side - Info & Comments -->
        <div class="fb-info-section">
            <!-- Post Header -->
            <div class="fb-post-header">
                <div class="fb-author-info">
                    @if($post->user->profile_photo)
                        <img src="{{ asset('storage/' . $post->user->profile_photo) }}" alt="{{ $post->user->name }}" class="fb-author-avatar">
                    @else
                        <div class="fb-author-avatar-circle">{{ substr($post->user->name, 0, 1) }}</div>
                    @endif
                    <div class="fb-author-details">
                        <div class="fb-author-name">{{ $post->user->name }}</div>
                        <div class="fb-post-time">{{ $post->created_at->diffForHumans() }}</div>
                    </div>
                </div>
                
                @auth
                @if($post->isOwnedBy(auth()->user()))
                <div class="fb-post-menu">
                    <div class="dropdown">
                        <button class="fb-menu-btn" onclick="toggleDropdown(event)">
                            <i class="bi bi-three-dots"></i>
                        </button>
                        <div class="dropdown-content">
                            <a href="{{ route('posts.edit', $post) }}">
                                <i class="bi bi-pencil"></i> Edit Post
                            </a>
                            <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Delete this post?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-post-btn">
                                    <i class="bi bi-trash"></i> Delete Post
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
                @endauth
            </div>

            <!-- Post Title & Content -->
            <div class="fb-post-content">
                @if($post->tags->count() > 0)
                <div class="fb-post-tags">
                    @foreach($post->tags as $tag)
                        <span class="fb-tag" style="background: {{ $tag->color }}20; color: {{ $tag->color }}">
                            {{ $tag->name }}
                        </span>
                    @endforeach
                </div>
                @endif
                
                @if(!$post->background)
                <div class="fb-post-text">
                    {!! nl2br(e($post->content)) !!}
                </div>
                @endif
            </div>

            <!-- Post Stats & Actions -->
            <div class="fb-post-stats">
                <div class="fb-stats-left">
                    <span class="fb-stat-item">
                        <i class="bi bi-heart-fill" style="color: #FF6B9D;"></i>
                        <span id="likes-count">{{ $post->likes()->count() }}</span>
                    </span>
                </div>
                <div class="fb-stats-right">
                    <span class="fb-stat-item">{{ $post->comments->count() }} bình luận</span>
                </div>
            </div>

            <div class="fb-post-actions">
                @auth
                <button id="like-btn" class="fb-action-btn fb-like-btn {{ $post->likedBy(auth()->user()) ? 'active' : '' }}" data-post-slug="{{ $post->slug }}">
                    <i class="bi {{ $post->likedBy(auth()->user()) ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                    <span>Thích</span>
                </button>
                @else
                <a href="{{ route('login') }}" class="fb-action-btn fb-like-btn">
                    <i class="bi bi-heart"></i>
                    <span>Thích</span>
                </a>
                @endauth
                
                <button class="fb-action-btn fb-comment-btn" onclick="focusCommentInput()">
                    <i class="bi bi-chat"></i>
                    <span>Bình luận</span>
                </button>
                
                @auth
                    @if($post->user_id !== Auth::user()->uid)
                    <button class="fb-action-btn fb-report-btn" onclick="openReportModal({{ $post->id }}, '{{ addslashes($post->title) }}')" title="Báo cáo vi phạm">
                        <i class="bi bi-flag"></i>
                        <span>Báo cáo</span>
                    </button>
                    @endif
                @endauth
            </div>

            <!-- Comments Section -->
            <div class="fb-comments-section">
                <div class="fb-comments-list" id="comments-list">
                    @forelse($post->comments as $comment)
                        <div class="fb-comment-item" id="comment-{{ $comment->id }}">
                            <div class="fb-comment-avatar">
                                @if($comment->user->profile_photo)
                                    <img src="{{ asset('storage/' . $comment->user->profile_photo) }}" alt="{{ $comment->user->name }}">
                                @else
                                    <div class="fb-avatar-circle">{{ substr($comment->user->name, 0, 1) }}</div>
                                @endif
                            </div>
                            <div class="fb-comment-content">
                                <div class="fb-comment-bubble">
                                    <div class="fb-comment-author">{{ $comment->user->name }}</div>
                                    <div class="fb-comment-text" id="comment-text-{{ $comment->id }}">
                                        @if($comment->image)
                                            @php
                                                // Check if image is external URL or local path
                                                $isExternalImage = str_starts_with($comment->image, 'http://') || str_starts_with($comment->image, 'https://');
                                                $imageUrl = $isExternalImage ? $comment->image : asset('storage/' . $comment->image);
                                            @endphp
                                            <img src="{{ $imageUrl }}" class="fb-comment-image" alt="Comment Image" style="max-width: 100%; border-radius: 8px; margin-top: 8px;">
                                        @endif
                                        
                                        @if(!$comment->image && $comment->content)
                                            @php
                                                $isImageUrl = preg_match('/^https?:\/\/.*(giphy\.com|\.gif|\.jpg|\.jpeg|\.png|\.webp)/i', $comment->content);
                                            @endphp
                                            
                                            @if($isImageUrl)
                                                <img src="{{ $comment->content }}" class="fb-comment-gif" alt="GIF">
                                            @else
                                                {{ $comment->content }}
                                            @endif
                                        @endif
                                        
                                        @if($comment->image && $comment->content)
                                            <p style="margin-top: 8px;">{{ $comment->content }}</p>
                                        @endif
                                    </div>
                                    
                                    <!-- Edit form (hidden by default) -->
                                    <form action="{{ route('comments.update', $comment) }}" method="POST" class="fb-comment-edit-form" id="edit-form-{{ $comment->id }}" style="display: none;">
                                        @csrf
                                        @method('PUT')
                                        <textarea name="content" rows="2" required>{{ $comment->content }}</textarea>
                                        <div class="fb-edit-actions">
                                            <button type="submit" class="fb-btn-save">Lưu</button>
                                            <button type="button" class="fb-btn-cancel" onclick="cancelEdit({{ $comment->id }})">Hủy</button>
                                        </div>
                                    </form>
                                </div>
                                
                                <div class="fb-comment-meta">
                                    <span class="fb-comment-time">{{ $comment->created_at->diffForHumans() }}</span>
                                    @auth
                                        @if($comment->isOwnedBy(auth()->user()))
                                            <button class="fb-comment-meta-btn" onclick="editComment({{ $comment->id }})">
                                                <i class="bi bi-pencil"></i> Sửa
                                            </button>
                                        @endif
                                        @if($comment->isOwnedBy(auth()->user()) || $post->isOwnedBy(auth()->user()))
                                            <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="d-inline" onsubmit="return confirm('Xóa bình luận này?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="fb-comment-meta-btn delete-comment-action">
                                                    <i class="bi bi-trash"></i> Xóa
                                                </button>
                                            </form>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="fb-no-comments">Chưa có bình luận nào. Hãy là người đầu tiên bình luận!</p>
                    @endforelse
                </div>

                <!-- Comment Form -->
                @auth
                <div class="fb-comment-form">
                    <div class="fb-comment-avatar">
                        @if(auth()->user()->profile_photo)
                            <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="{{ auth()->user()->name }}">
                        @else
                            <div class="fb-avatar-circle">{{ substr(auth()->user()->name, 0, 1) }}</div>
                        @endif
                    </div>
                    <div class="fb-comment-form-wrapper">
                        <form action="{{ route('comments.store', $post) }}" method="POST" enctype="multipart/form-data" id="comment-form" class="fb-comment-input-form">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <input type="file" id="comment-image-input" name="image" accept="image/*" style="display: none;">
                            
                            <div class="fb-comment-input-wrapper">
                                <textarea name="content" id="comment-input" placeholder="Viết bình luận..." rows="1" autocomplete="off"></textarea>
                                
                                <!-- Image/GIF Preview -->
                                <div class="fb-comment-preview" id="comment-preview" style="display: none;">
                                    <img src="" alt="Preview" id="preview-img">
                                    <button type="button" class="fb-remove-preview" onclick="removePreview()">&times;</button>
                                </div>
                            </div>
                            
                            <div class="fb-comment-actions">
                                <div class="fb-comment-tools">
                                    <button type="button" class="fb-tool-btn fb-image-btn" onclick="document.getElementById('comment-image-input').click()" title="Thêm ảnh">
                                        <i class="bi bi-image"></i>
                                    </button>
                                    <button type="button" class="fb-tool-btn fb-gif-btn" id="gif-btn" title="Thêm GIF">
                                        <i class="bi bi-file-play"></i>
                                    </button>
                                    <button type="button" class="fb-tool-btn fb-emoji-btn" id="emoji-btn" title="Emoji">
                                        <i class="bi bi-emoji-smile"></i>
                                    </button>
                                </div>
                                <button type="submit" class="fb-send-btn">
                                    <i class="bi bi-send-fill"></i>
                                </button>
                            </div>
                            
                            <!-- Emoji Picker -->
                            <div class="fb-emoji-picker" id="emoji-picker" style="display: none;">
                                <div class="emoji-grid">
                                    <span>😀</span><span>😃</span><span>😄</span><span>😁</span><span>😆</span><span>😅</span><span>😂</span><span>🤣</span><span>😊</span><span>😇</span><span>🙂</span><span>🙃</span><span>😉</span><span>😌</span><span>😍</span><span>🥰</span><span>😘</span><span>😗</span><span>😙</span><span>😚</span><span>😋</span><span>😛</span><span>😝</span><span>😜</span><span>🤪</span><span>🤨</span><span>🧐</span><span>🤓</span><span>😎</span><span>🤩</span><span>🥳</span><span>😏</span><span>😒</span><span>😞</span><span>😔</span><span>😟</span><span>😕</span><span>🙁</span><span>☹️</span><span>😣</span><span>😖</span><span>😫</span><span>😩</span><span>🥺</span><span>😢</span><span>😭</span><span>😤</span><span>😠</span><span>😡</span><span>🤬</span><span>🤯</span><span>😳</span><span>🥵</span><span>🥶</span><span>😱</span><span>😨</span><span>😰</span><span>😥</span><span>😓</span><span>🤗</span><span>🤔</span><span>🤭</span><span>🤫</span><span>🤥</span><span>😶</span><span>😐</span><span>😑</span><span>😬</span><span>🙄</span><span>😯</span><span>😦</span><span>😧</span><span>😮</span><span>😲</span><span>🥱</span><span>😴</span><span>🤤</span><span>😪</span><span>😵</span><span>🤐</span><span>🥴</span><span>🤢</span><span>🤮</span><span>🤧</span><span>😷</span><span>🤒</span><span>🤕</span><span>🤑</span><span>🤠</span><span>👍</span><span>👎</span><span>👊</span><span>✊</span><span>🤛</span><span>🤜</span><span>🤞</span><span>✌️</span><span>🤟</span><span>🤘</span><span>👌</span><span>🤌</span><span>🤏</span><span>👈</span><span>👉</span><span>👆</span><span>👇</span><span>☝️</span><span>✋</span><span>🤚</span><span>🖐</span><span>🖖</span><span>👋</span><span>🤙</span><span>💪</span><span>🙏</span><span>❤️</span><span>🧡</span><span>💛</span><span>💚</span><span>💙</span><span>💜</span><span>🖤</span><span>🤍</span><span>🤎</span><span>💔</span><span>❣️</span><span>💕</span><span>💞</span><span>💓</span><span>💗</span><span>💖</span><span>💘</span><span>💝</span><span>✨</span><span>💫</span><span>⭐</span><span>🌟</span><span>✅</span><span>❌</span><span>🔥</span><span>💯</span><span>👏</span><span>🎉</span><span>🎊</span>
                                </div>
                            </div>
                            
                            <!-- GIF Picker -->
                            <div class="fb-gif-picker" id="gif-picker" style="display: none;">
                                <input type="text" class="gif-search" id="gif-search-input" placeholder="Tìm kiếm GIF anime..." autocomplete="off">
                                <div class="gif-loading" id="gif-loading" style="display: none; text-align: center; padding: 20px; color: #65676b;">
                                    <i class="bi bi-arrow-repeat" style="font-size: 24px; animation: spin 1s linear infinite;"></i>
                                    <p style="margin-top: 8px; font-size: 13px;">Đang tìm kiếm...</p>
                                </div>
                                <div class="gif-grid" id="gif-grid">
                                    <!-- Trending anime GIFs will load here -->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                    </form>
                </div>
                @else
                <div class="fb-login-prompt">
                    <p><a href="{{ route('login') }}">Đăng nhập</a> để bình luận</p>
                </div>
                @endauth
            </div>
        </div>
    </div>
</div>
        </div>
    </div>
</div>

@push('styles')
<style>
/* Facebook-style Post Detail Layout */
.fb-post-detail-page {
    background: transparent;
    min-height: 100vh;
    padding: 20px 0;
}

.fb-post-container {
    max-width: 1400px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 500px;
    gap: 0;
    background: rgba(255, 255, 255, 0.3);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border-radius: 8px;
    overflow-x: hidden;
    overflow-y: visible;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

/* Left Side - Media */
.fb-media-section {
    background: transparent;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 600px;
    max-height: 90vh;
}

.fb-main-image,
.fb-main-video {
    max-width: 100%;
    max-height: 90vh;
    width: auto;
    height: auto;
    object-fit: contain;
}

.fb-background-post {
    width: 100%;
    height: 100%;
    min-height: 600px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 3rem;
}

.fb-background-content {
    color: white;
    font-size: 32px;
    font-weight: 600;
    text-align: center;
    line-height: 1.4;
    max-width: 600px;
    word-wrap: break-word;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.fb-no-media {
    text-align: center;
    color: #fff;
    padding: 4rem 2rem;
}

.fb-no-media p {
    margin-top: 1rem;
    color: #999;
}

/* Right Side - Info & Comments */
.fb-info-section {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    display: flex;
    flex-direction: column;
    max-height: 90vh;
    overflow: hidden;
}

/* Post Header */
.fb-post-header {
    padding: 16px;
    border-bottom: 1px solid #e4e6eb;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    position: relative;
    overflow: visible;
}

.fb-author-info {
    display: flex;
    gap: 12px;
    align-items: center;
    flex: 1;
}

.fb-author-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

.fb-author-avatar-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #5BA3D0, #9B7EDE);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 1.1rem;
}

.fb-author-details {
    flex: 1;
}

.fb-author-name {
    font-weight: 600;
    font-size: 15px;
    color: #050505;
}

.fb-post-time {
    font-size: 13px;
    color: #65676b;
}

.fb-post-menu {
    position: relative;
    z-index: 100;
}

.fb-post-menu .dropdown {
    position: relative;
    z-index: 100;
}

.fb-menu-btn {
    background: none;
    border: none;
    color: #65676b;
    font-size: 20px;
    cursor: pointer;
    padding: 8px;
    border-radius: 50%;
    transition: background 0.2s;
}

.fb-menu-btn:hover {
    background: #f0f2f5;
}

/* Dropdown */
.dropdown {
    position: relative;
    z-index: 1000;
}

.dropdown-content {
    display: none;
    position: absolute;
    right: 0;
    top: 100%;
    margin-top: 4px;
    background: white;
    min-width: 200px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.15);
    border-radius: 8px;
    z-index: 10000;
    padding: 8px 0;
}

.dropdown-content.show {
    display: block !important;
}

.dropdown-content a,
.dropdown-content button {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 16px;
    color: #050505;
    text-decoration: none;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
    cursor: pointer;
    font-size: 15px;
    transition: background 0.2s;
}

.dropdown-content a i,
.dropdown-content button i {
    font-size: 16px;
}

.dropdown-content a:hover,
.dropdown-content button:hover {
    background: #f0f2f5;
}

.dropdown-content .delete-post-btn {
    color: #f44336 !important;
}

.dropdown-content .delete-post-btn:hover {
    background: #ffebee !important;
    color: #d32f2f !important;
}

/* Post Content */
.fb-post-content {
    padding: 16px;
    border-bottom: 1px solid #e4e6eb;
    overflow-y: auto;
    max-height: 200px;
}

.fb-post-title {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 12px;
    color: #050505;
}

.fb-post-tags {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
    margin-bottom: 12px;
}

.fb-tag {
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 600;
}

.fb-post-text {
    font-size: 15px;
    line-height: 1.5;
    color: #050505;
    white-space: pre-wrap;
}

/* Post Stats */
.fb-post-stats {
    padding: 12px 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #e4e6eb;
    font-size: 15px;
    color: #65676b;
}

.fb-stat-item {
    display: flex;
    align-items: center;
    gap: 6px;
}

/* Post Actions */
.fb-post-actions {
    padding: 4px 16px;
    display: flex;
    border-bottom: 1px solid #e4e6eb;
}

.fb-action-btn {
    flex: 1;
    padding: 8px;
    background: none;
    border: none;
    color: #2c5f7a !important;
    font-weight: 600;
    font-size: 15px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    border-radius: 8px;
    transition: all 0.3s ease-out;
    text-decoration: none;
}

.fb-action-btn:hover {
    background: linear-gradient(135deg, rgba(160, 216, 239, 0.15), rgba(184, 230, 213, 0.1)) !important;
    color: #1a4d5f !important;
    transform: translateY(-1px);
}

.fb-action-btn.active {
    color: #FF6B9D !important;
    background: rgba(255, 107, 157, 0.1) !important;
}

.fb-action-btn.active i {
    color: #FF6B9D !important;
}

/* Button Variants - Màu Khác Nhau */
.fb-like-btn {
    color: #FF6B9D !important;
}

.fb-like-btn:hover {
    background: linear-gradient(135deg, rgba(255, 107, 157, 0.15), rgba(255, 182, 193, 0.1)) !important;
    color: #e5508d !important;
}

.fb-comment-btn {
    color: #2c5f7a !important;
}

.fb-comment-btn:hover {
    background: linear-gradient(135deg, rgba(160, 216, 239, 0.15), rgba(184, 230, 213, 0.1)) !important;
    color: #1a4d5f !important;
}

.fb-report-btn {
    color: #b34545 !important;
}

.fb-report-btn:hover {
    background: linear-gradient(135deg, rgba(255, 184, 184, 0.15), rgba(255, 153, 153, 0.1)) !important;
    color: #8f3535 !important;
}

.fb-like-btn:hover {
    background: linear-gradient(135deg, rgba(255, 107, 157, 0.15), rgba(255, 182, 193, 0.1)) !important;
    color: #e5508d !important;
}

.fb-comment-btn {
    color: #2c5f7a !important;
}

.fb-comment-btn:hover {
    background: linear-gradient(135deg, rgba(160, 216, 239, 0.15), rgba(184, 230, 213, 0.1)) !important;
    color: #1a4d5f !important;
}

.fb-report-btn {
    color: #b34545 !important;
}

.fb-report-btn:hover {
    background: linear-gradient(135deg, rgba(255, 184, 184, 0.15), rgba(255, 153, 153, 0.1)) !important;
    color: #8f3535 !important;
}

/* Comments Section */
.fb-comments-section {
    flex: 1;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    min-height: 0;
}

.fb-comments-list {
    flex: 1;
    overflow-y: auto;
    overflow-x: hidden;
    padding: 16px;
}

.fb-comment-item {
    display: flex;
    gap: 8px;
    margin-bottom: 16px;
}

.fb-comment-avatar img,
.fb-avatar-circle {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
}

.fb-avatar-circle {
    background: linear-gradient(135deg, #5BA3D0, #9B7EDE);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 14px;
}

.fb-comment-content {
    flex: 1;
}

.fb-comment-bubble {
    background: #f0f2f5;
    padding: 8px 12px;
    border-radius: 18px;
    display: inline-block;
    max-width: 100%;
}

.fb-comment-author {
    font-weight: 600;
    font-size: 13px;
    color: #050505;
    margin-bottom: 2px;
}

.fb-comment-text {
    font-size: 15px;
    color: #050505;
    word-wrap: break-word;
}

.fb-comment-gif {
    max-width: 250px;
    border-radius: 8px;
    margin-top: 4px;
    display: block;
}

.fb-comment-image {
    max-width: 150px;
    border-radius: 8px;
    margin-top: 8px;
    display: block;
}

.fb-comment-meta {
    padding: 0 12px;
    margin-top: 4px;
    display: flex;
    gap: 12px;
    font-size: 12px;
    color: #65676b;
}

.fb-comment-time {
    font-weight: 600;
}

.fb-comment-meta-btn {
    background: none;
    border: none;
    color: #5ba3d0 !important;
    font-weight: 600;
    font-size: 12px;
    cursor: pointer;
    padding: 0;
    border-radius: 0;
    transition: all 0.2s ease-out;
    display: inline-flex;
    align-items: center;
    gap: 3px;
}

.fb-comment-meta-btn i {
    font-size: 12px;
}

.fb-comment-meta-btn:hover {
    text-decoration: underline;
    color: #4a8bb8 !important;
}

.fb-comment-meta-btn.delete-comment-action {
    color: #f44336 !important;
}

.fb-comment-meta-btn.delete-comment-action:hover {
    color: #d32f2f !important;
}

/* Nút Xóa và Sửa giống nhau */

/* Comment Edit Form */
.fb-comment-edit-form {
    margin-top: 8px;
}

.fb-comment-edit-form textarea {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #ccc;
    border-radius: 18px;
    font-family: inherit;
    font-size: 15px;
    resize: none;
}

.fb-edit-actions {
    display: flex;
    gap: 8px;
    margin-top: 8px;
}

.fb-btn-save,
.fb-btn-cancel {
    padding: 6px 16px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    border: none;
    transition: all 0.3s ease-out;
}

.fb-btn-save {
    background: linear-gradient(135deg, #B8E6D5 0%, #A0D8C3 100%) !important;
    color: #2d5a4a !important;
}

.fb-btn-save:hover {
    background: linear-gradient(135deg, #A0D8C3 0%, #8BC7AC 100%) !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(184, 230, 213, 0.3);
}

.fb-btn-cancel {
    background: linear-gradient(135deg, #E4D7F5 0%, #D0C0E8 100%) !important;
    color: #6B4C9A !important;
}

.fb-btn-cancel:hover {
    background: linear-gradient(135deg, #D0C0E8 0%, #BCAAD9 100%) !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(228, 215, 245, 0.3);
}

.fb-btn-cancel:hover {
    background: #d8dadf;
}

.fb-no-comments {
    text-align: center;
    color: #65676b;
    padding: 32px 16px;
    font-size: 15px;
}

/* Comment Form */
.fb-comment-form {
    padding: 12px 16px;
    border-top: 1px solid #e4e6eb;
    display: flex;
    gap: 8px;
    align-items: flex-start;
    background: #fff;
}

.fb-comment-form-wrapper {
    flex: 1;
}

.fb-comment-input-form {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.fb-comment-input-wrapper {
    background: #f0f2f5;
    border-radius: 18px;
    padding: 8px 12px;
}

.fb-comment-input-form textarea {
    width: 100%;
    border: none;
    background: transparent;
    font-size: 15px;
    outline: none;
    resize: none;
    font-family: inherit;
    min-height: 20px;
    max-height: 100px;
}

.fb-comment-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 4px;
}

.fb-comment-tools {
    display: flex;
    gap: 4px;
}

.fb-tool-btn {
    background: none;
    border: none;
    font-size: 18px;
    cursor: pointer;
    padding: 6px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease-out;
}

.fb-tool-btn:hover {
    transform: scale(1.1);
}

/* Tool Button Variants - Màu Khác Nhau */
.fb-image-btn {
    color: white !important;
    background: linear-gradient(135deg, #E4D7F5 0%, #D0C0E8 100%) !important;
}

.fb-image-btn:hover {
    background: linear-gradient(135deg, #D0C0E8 0%, #BCAAD9 100%) !important;
    color: white !important;
}

.fb-gif-btn {
    color: white !important;
    background: linear-gradient(135deg, #FFE4B8 0%, #FFD099 100%) !important;
}

.fb-gif-btn:hover {
    background: linear-gradient(135deg, #FFD099 0%, #FFBD7B 100%) !important;
    color: white !important;
}

.fb-emoji-btn {
    color: #8B6914 !important;
    background: linear-gradient(135deg, #FFEB3B 0%, #FFD700 100%) !important;
}

.fb-emoji-btn:hover {
    background: linear-gradient(135deg, #FFD700 0%, #FFC107 100%) !important;
    color: #8B6914 !important;
}

.fb-comment-preview {
    margin-top: 8px;
    position: relative;
    display: inline-block;
}

.fb-comment-preview img {
    max-width: 200px;
    max-height: 150px;
    border-radius: 8px;
    display: block;
}

.fb-remove-preview {
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
    font-size: 18px;
    line-height: 1;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Emoji Picker */
.fb-emoji-picker,
.fb-gif-picker {
    margin-top: 8px;
    background: white;
    border: 1px solid #e4e6eb;
    border-radius: 8px;
    padding: 12px;
    max-height: 200px;
    overflow-y: auto;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.emoji-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(32px, 1fr));
    gap: 8px;
    font-size: 24px;
    user-select: none;
}

.emoji-grid span {
    cursor: pointer;
    text-align: center;
    padding: 4px;
    border-radius: 4px;
    transition: background 0.2s;
    user-select: none;
    display: flex;
    align-items: center;
    justify-content: center;
}

.emoji-grid span:hover {
    background: #f0f2f5;
    transform: scale(1.2);
}

.gif-search {
    width: 100%;
    padding: 8px;
    border: 1px solid #e4e6eb;
    border-radius: 6px;
    margin-bottom: 12px;
    font-size: 14px;
    outline: none;
}

.gif-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 8px;
    max-height: 300px;
    overflow-y: auto;
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
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.fb-send-btn {
    background: linear-gradient(135deg, #A0D8EF 0%, #87CEEB 100%) !important;
    border: none;
    color: white !important;
    font-size: 20px;
    cursor: pointer;
    padding: 8px 12px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease-out;
    box-shadow: 0 2px 8px rgba(160, 216, 239, 0.3);
}

.fb-send-btn:hover {
    background: linear-gradient(135deg, #87CEEB 0%, #6BB6D6 100%) !important;
    color: white !important;
    transform: translateY(-2px) scale(1.05);
    box-shadow: 0 4px 12px rgba(160, 216, 239, 0.5);
}

.fb-login-prompt {
    padding: 16px;
    text-align: center;
    border-top: 1px solid #e4e6eb;
}

.fb-login-prompt a {
    color: #1877f2;
    font-weight: 600;
    text-decoration: none;
}

.fb-login-prompt a:hover {
    text-decoration: underline;
}

/* Responsive */
@media (max-width: 992px) {
    .fb-post-container {
        grid-template-columns: 1fr;
    }
    
    .fb-media-section {
        max-height: 400px;
    }
    
    .fb-info-section {
        max-height: none;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 DOM loaded - Initializing post.show scripts...');

// Like button functionality
document.getElementById('like-btn')?.addEventListener('click', function() {
    const postSlug = this.dataset.postSlug;
    const btn = this;
    const likesCount = document.getElementById('likes-count');
    const icon = btn.querySelector('i');
    
    fetch(`/posts/${postSlug}/like`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        likesCount.textContent = data.likes_count;
        
        if (data.liked) {
            btn.classList.add('active');
            icon.classList.remove('bi-heart');
            icon.classList.add('bi-heart-fill');
        } else {
            btn.classList.remove('active');
            icon.classList.remove('bi-heart-fill');
            icon.classList.add('bi-heart');
        }
    })
    .catch(error => console.error('Error:', error));
});

// Edit comment functionality
function editComment(commentId) {
    document.getElementById('comment-text-' + commentId).style.display = 'none';
    document.getElementById('edit-form-' + commentId).style.display = 'block';
}

function cancelEdit(commentId) {
    document.getElementById('comment-text-' + commentId).style.display = 'block';
    document.getElementById('edit-form-' + commentId).style.display = 'none';
}

// Focus comment input
function focusCommentInput() {
    document.getElementById('comment-input')?.focus();
}

// Dropdown menu toggle
function toggleDropdown(event) {
    event.preventDefault();
    event.stopPropagation();
    console.log('Dropdown clicked');
    
    const dropdownContainer = event.target.closest('.dropdown');
    if (!dropdownContainer) {
        console.error('Dropdown container not found');
        return;
    }
    
    const dropdown = dropdownContainer.querySelector('.dropdown-content');
    if (!dropdown) {
        console.error('Dropdown content not found');
        return;
    }
    
    // Close all other dropdowns first
    document.querySelectorAll('.dropdown-content').forEach(d => {
        if (d !== dropdown) d.classList.remove('show');
    });
    
    // Toggle current dropdown
    dropdown.classList.toggle('show');
    console.log('Dropdown toggled, show class:', dropdown.classList.contains('show'));
}

// Close dropdown when clicking anywhere (inside or outside)
document.addEventListener('click', function(event) {
    // Don't close if clicking the toggle button
    if (event.target.closest('.fb-menu-btn')) {
        return;
    }
    
    // Close all dropdowns
    const dropdowns = document.querySelectorAll('.dropdown-content');
    dropdowns.forEach(dropdown => dropdown.classList.remove('show'));
});

// ===== Comment Form Functionality =====

// Auto-resize textarea
const commentTextarea = document.getElementById('comment-input');
if (commentTextarea) {
    commentTextarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = this.scrollHeight + 'px';
    });
}

// Image preview
const imageInput = document.getElementById('comment-image-input');
const commentPreview = document.getElementById('comment-preview');
const previewImg = document.getElementById('preview-img');

if (imageInput) {
    imageInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                commentPreview.style.display = 'block';
                // Clear GIF URL if exists
                if (commentPreview.dataset.gifUrl) {
                    delete commentPreview.dataset.gifUrl;
                }
            };
            reader.readAsDataURL(this.files[0]);
        }
    });
}

// Remove preview
function removePreview() {
    const imageInput = document.getElementById('comment-image-input');
    const commentPreview = document.getElementById('comment-preview');
    
    imageInput.value = '';
    commentPreview.style.display = 'none';
    if (commentPreview.dataset.gifUrl) {
        delete commentPreview.dataset.gifUrl;
    }
}

// Emoji picker toggle
console.log('🔍 Looking for elements...');
const emojiBtn = document.getElementById('emoji-btn');
const emojiPicker = document.getElementById('emoji-picker');
const gifBtn = document.getElementById('gif-btn');
const gifPicker = document.getElementById('gif-picker');

console.log('Found elements:', {
    emojiBtn: emojiBtn ? 'YES ✅' : 'NO ❌',
    emojiPicker: emojiPicker ? 'YES ✅' : 'NO ❌',
    gifBtn: gifBtn ? 'YES ✅' : 'NO ❌',
    gifPicker: gifPicker ? 'YES ✅' : 'NO ❌'
});

if (emojiBtn && emojiPicker) {
    console.log('✅ Setting up emoji picker...');
    emojiBtn.addEventListener('click', function(e) {
        console.log('😀 Emoji button clicked!');
        e.stopPropagation();
        emojiPicker.style.display = emojiPicker.style.display === 'none' ? 'block' : 'none';
        console.log('Emoji picker display:', emojiPicker.style.display);
        if (gifPicker) gifPicker.style.display = 'none';
    });

    // Add emoji to textarea
    emojiPicker.querySelectorAll('span').forEach(emojiSpan => {
        emojiSpan.addEventListener('click', function(e) {
            e.stopPropagation();
            const textarea = document.getElementById('comment-input');
            const emoji = this.textContent;
            const cursorPos = textarea.selectionStart || 0;
            const textBefore = textarea.value.substring(0, cursorPos);
            const textAfter = textarea.value.substring(cursorPos);
            
            textarea.value = textBefore + emoji + textAfter;
            
            // Set cursor position after emoji
            const newPos = cursorPos + emoji.length;
            textarea.focus();
            textarea.setSelectionRange(newPos, newPos);
            
            // Trigger input event to resize textarea
            textarea.dispatchEvent(new Event('input'));
            
            emojiPicker.style.display = 'none';
        });
    });
}

// Giphy API configuration
const GIPHY_API_KEY = '2UNLRUTAqLhcKD4ZX3mZZpn5Tw1eVryk';
const GIPHY_LIMIT = 20;
let gifSearchTimeout;

// Load trending anime GIFs
async function loadTrendingGIFs() {
    const gifGrid = document.getElementById('gif-grid');
    const gifLoading = document.getElementById('gif-loading');
    
    try {
        gifLoading.style.display = 'block';
        gifGrid.innerHTML = '';
        
        console.log('Fetching trending anime GIFs...');
        const url = `https://api.giphy.com/v1/gifs/search?api_key=${GIPHY_API_KEY}&q=anime&limit=${GIPHY_LIMIT}&rating=g`;
        console.log('URL:', url);
        
        const response = await fetch(url);
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers.get('content-type'));
        
        if (!response.ok) {
            const errorText = await response.text();
            console.error('Error response:', errorText);
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            const text = await response.text();
            console.error('Non-JSON response:', text.substring(0, 200));
            throw new Error('Response is not JSON');
        }
        
        const data = await response.json();
        console.log('GIFs loaded:', data.data ? data.data.length : 0);
        console.log('Full response:', data);
        
        gifLoading.style.display = 'none';
        
        if (data.data && data.data.length > 0) {
            data.data.forEach(gif => {
                const img = document.createElement('img');
                img.src = gif.images.fixed_height_small.url;
                img.className = 'gif-item';
                img.alt = gif.title;
                img.addEventListener('click', function() {
                    selectGIF(this.src);
                });
                gifGrid.appendChild(img);
            });
        } else {
            gifGrid.innerHTML = '<p style="text-align: center; color: #65676b; padding: 20px;">Không tìm thấy GIF</p>';
        }
    } catch (error) {
        console.error('Error loading GIFs:', error);
        gifLoading.style.display = 'none';
        gifGrid.innerHTML = `<p style="text-align: center; color: #e74c3c; padding: 10px; font-size: 12px;">Lỗi: ${error.message}<br><small>Kiểm tra Console để biết chi tiết</small></p>`;
    }
}

// Search GIFs
async function searchGIFs(query) {
    const gifGrid = document.getElementById('gif-grid');
    const gifLoading = document.getElementById('gif-loading');
    
    if (!query.trim()) {
        loadTrendingGIFs();
        return;
    }
    
    try {
        gifLoading.style.display = 'block';
        gifGrid.innerHTML = '';
        
        const response = await fetch(`https://api.giphy.com/v1/gifs/search?api_key=${GIPHY_API_KEY}&q=${encodeURIComponent(query)}&limit=${GIPHY_LIMIT}&rating=g`);
        const data = await response.json();
        
        gifLoading.style.display = 'none';
        
        if (data.data && data.data.length > 0) {
            data.data.forEach(gif => {
                const img = document.createElement('img');
                img.src = gif.images.fixed_height_small.url;
                img.className = 'gif-item';
                img.alt = gif.title;
                img.addEventListener('click', function() {
                    selectGIF(this.src);
                });
                gifGrid.appendChild(img);
            });
        } else {
            gifGrid.innerHTML = '<p style="text-align: center; color: #65676b; padding: 20px;">Không tìm thấy GIF</p>';
        }
    } catch (error) {
        console.error('Error searching GIFs:', error);
        gifLoading.style.display = 'none';
        gifGrid.innerHTML = '<p style="text-align: center; color: #e74c3c; padding: 20px;">Lỗi tìm kiếm. Vui lòng thử lại.</p>';
    }
}

// Select GIF
function selectGIF(gifUrl) {
    const commentPreview = document.getElementById('comment-preview');
    const previewImg = document.getElementById('preview-img');
    const imageInput = document.getElementById('comment-image-input');
    const gifPicker = document.getElementById('gif-picker');
    
    // Clear file input
    imageInput.value = '';
    
    // Show GIF preview
    previewImg.src = gifUrl;
    commentPreview.style.display = 'block';
    commentPreview.dataset.gifUrl = gifUrl;
    
    // Hide GIF picker
    gifPicker.style.display = 'none';
}

// GIF picker toggle
if (gifBtn && gifPicker) {
    console.log('✅ GIF picker initialized - NEW CODE LOADED');
    
    gifBtn.addEventListener('click', function() {
        console.log('🎬 GIF button clicked');
        const isVisible = gifPicker.style.display === 'block';
        gifPicker.style.display = isVisible ? 'none' : 'block';
        emojiPicker.style.display = 'none';
        
        // Load trending GIFs when opening
        if (!isVisible) {
            console.log('📡 Loading GIFs...');
            loadTrendingGIFs();
        }
    });
    
    // GIF search input
    const gifSearchInput = document.getElementById('gif-search-input');
    if (gifSearchInput) {
        gifSearchInput.addEventListener('input', function() {
            clearTimeout(gifSearchTimeout);
            gifSearchTimeout = setTimeout(() => {
                searchGIFs(this.value);
            }, 500); // Debounce 500ms
        });
    }
}

// Close pickers when clicking outside
document.addEventListener('click', function(e) {
    if (emojiPicker && !emojiBtn.contains(e.target) && !emojiPicker.contains(e.target)) {
        emojiPicker.style.display = 'none';
    }
    if (gifPicker && !gifBtn.contains(e.target) && !gifPicker.contains(e.target)) {
        gifPicker.style.display = 'none';
    }
});

// Handle form submission
const commentForm = document.getElementById('comment-form');
if (commentForm) {
    commentForm.addEventListener('submit', function(e) {
        e.preventDefault(); // Always prevent default
        
        const commentPreview = document.getElementById('comment-preview');
        const textarea = document.getElementById('comment-input');
        const imageInput = document.getElementById('comment-image-input');
        
        // Validate input
        if (!textarea.value.trim() && !imageInput.files[0] && !commentPreview.dataset.gifUrl) {
            alert('Vui lòng nhập nội dung bình luận hoặc chọn ảnh!');
            return;
        }
        
        const formData = new FormData(this);
        
        // If GIF is selected, send as image_url parameter
        if (commentPreview.dataset.gifUrl) {
            formData.set('image_url', commentPreview.dataset.gifUrl);
            formData.delete('image'); // Remove image file if exists
            // Keep content if user typed something
        }
        
        // Submit via AJAX
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Reload page to show new comment
                window.location.reload();
            } else {
                alert('Có lỗi xảy ra. Vui lòng thử lại!');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra. Vui lòng thử lại!');
        });
    });
}

// Report Modal Functions
function openReportModal(postId, postTitle) {
    document.getElementById('reportPostId').value = postId;
    document.getElementById('reportPostTitle').textContent = postTitle;
    document.getElementById('reportForm').reset();
    document.getElementById('otherReasonContainer').style.display = 'none';
    reportModal.show();
}

function submitReport() {
    const postId = document.getElementById('reportPostId').value;
    const reasonSelect = document.getElementById('reportReason');
    let reason = reasonSelect.value;
    
    if (!reason) {
        alert('Vui lòng chọn lý do báo cáo');
        return;
    }
    
    // Nếu chọn "Khác", lấy chi tiết
    if (reason === 'Khác') {
        const otherReason = document.getElementById('otherReason').value.trim();
        if (!otherReason) {
            alert('Vui lòng mô tả chi tiết lý do');
            return;
        }
        reason = 'Khác: ' + otherReason;
    }
    
    const submitBtn = event.target;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Đang gửi...';
    
    fetch(`/posts/${postId}/report`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ reason: reason })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            reportModal.hide();
            alert(data.message);
        } else {
            alert(data.message || 'Có lỗi xảy ra');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra khi gửi báo cáo');
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="bi bi-send me-1"></i>Gửi báo cáo';
    });
}

}); // End DOMContentLoaded

// Initialize report modal
let reportModal;
document.addEventListener('DOMContentLoaded', function() {
    reportModal = new bootstrap.Modal(document.getElementById('reportModal'));
    
    // Show/hide other reason textarea
    document.getElementById('reportReason').addEventListener('change', function() {
        const otherContainer = document.getElementById('otherReasonContainer');
        if (this.value === 'Khác') {
            otherContainer.style.display = 'block';
        } else {
            otherContainer.style.display = 'none';
        }
    });
});
</script>

<!-- Report Modal -->
<div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reportModalLabel">
                    <i class="bi bi-flag text-danger me-2"></i>Báo cáo vi phạm
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted mb-3">Bài viết: <strong id="reportPostTitle"></strong></p>
                <form id="reportForm">
                    <div class="mb-3">
                        <label for="reportReason" class="form-label">Lý do báo cáo <span class="text-danger">*</span></label>
                        <select class="form-select" id="reportReason" name="reason" required>
                            <option value="">-- Chọn lý do --</option>
                            <option value="Spam hoặc quảng cáo">Spam hoặc quảng cáo</option>
                            <option value="Nội dung không phù hợp">Nội dung không phù hợp</option>
                            <option value="Thông tin sai sự thật">Thông tin sai sự thật</option>
                            <option value="Ngôn từ hung hăng, thù ghét">Ngôn từ hung hăng, thù ghét</option>
                            <option value="Xâm phạm bản quyền">Xâm phạm bản quyền</option>
                            <option value="Khác">Khác</option>
                        </select>
                    </div>
                    <div class="mb-3" id="otherReasonContainer" style="display: none;">
                        <label for="otherReason" class="form-label">Mô tả chi tiết</label>
                        <textarea class="form-control" id="otherReason" rows="3" placeholder="Vui lòng mô tả chi tiết..."></textarea>
                    </div>
                    <input type="hidden" id="reportPostId" name="post_id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger" onclick="submitReport()">
                    <i class="bi bi-send me-1"></i>Gửi báo cáo
                </button>
            </div>
        </div>
    </div>
</div>

@endpush
@endsection
