@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="post-detail-page">
    <div class="container">
        <div class="post-detail">
            <!-- Breadcrumb -->
            <div class="breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <span>/</span>
                <span>{{ Str::limit($post->title, 50) }}</span>
            </div>

            <!-- Post Header -->
            <div class="post-detail-header">
                <div class="post-tags">
                    @foreach($post->tags as $tag)
                        <span class="tag-badge" style="background-color: {{ $tag->color }}20; color: {{ $tag->color }}">
                            {{ $tag->name }}
                        </span>
                    @endforeach
                </div>
                <h1>{{ $post->title }}</h1>
                <div class="post-detail-meta">
                    <div class="author-info">
                        @if($post->user->profile_photo)
                        <img src="{{ asset('storage/' . $post->user->profile_photo) }}" alt="{{ $post->user->name }}" class="author-avatar-large" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                        @else
                        <div class="author-avatar-large">{{ substr($post->user->name, 0, 1) }}</div>
                        @endif
                        <div>
                            <div class="author-name">{{ $post->user->name }}</div>
                            <div class="post-date">{{ $post->created_at->format('M d, Y') }} • {{ $post->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    <div class="post-stats-large">
                        <span>💬 {{ $post->comments->count() }} replies</span>
                        <span>❤️ <span id="likes-count">{{ $post->likes()->count() }}</span> likes</span>
                    </div>
                </div>
                
                @auth
                    <div class="post-actions-bar">
                        <button id="like-btn" class="action-btn {{ $post->likedBy(auth()->user()) ? 'liked' : '' }}" data-post-id="{{ $post->id }}">
                            <i class="bi bi-heart-fill"></i> 
                            <span id="like-text">{{ $post->likedBy(auth()->user()) ? 'Liked' : 'Like' }}</span>
                        </button>
                        
                        @if($post->isOwnedBy(auth()->user()))
                            <a href="{{ route('posts.edit', $post) }}" class="action-btn edit-btn">
                                <i class="bi bi-pencil"></i> Edit Post
                            </a>
                            <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn delete-btn">
                                    <i class="bi bi-trash"></i> Delete Post
                                </button>
                            </form>
                        @endif
                    </div>
                @endauth
            </div>

            <!-- Post Content -->
            <div class="post-detail-content">
                @if($post->image)
                    <div class="post-content-image">
                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
                    </div>
                @endif
                @if($post->video)
                    <div class="post-content-video" style="margin-bottom: 1.5rem;">
                        <video controls style="width: 100%; max-height: 600px; border-radius: 8px;">
                            <source src="{{ asset('storage/' . $post->video) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                @endif
                <div class="post-text">
                    {!! nl2br(e($post->content)) !!}
                </div>
            </div>

            <!-- Comments Section -->
            <div class="comments-section">
                <h3>Replies ({{ $post->comments->count() }})</h3>

                @auth
                    <div class="comment-form">
                        <form action="{{ route('comments.store', $post->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <div class="form-group">
                                <textarea name="content" rows="4" placeholder="Share your thoughts..." required></textarea>
                            </div>
                            <button type="submit" class="btn-primary">Post Reply</button>
                        </form>
                    </div>
                @else
                    <div class="login-prompt">
                        <p>Please <a href="/login">log in</a> to reply to this post.</p>
                    </div>
                @endauth

                <div class="comments-list">
                    @forelse($post->comments as $comment)
                        <div class="comment-item" id="comment-{{ $comment->id }}">
                            @if($comment->user->profile_photo)
                            <img src="{{ asset('storage/' . $comment->user->profile_photo) }}" alt="{{ $comment->user->name }}" class="comment-author-avatar" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                            @else
                            <div class="comment-author-avatar">{{ substr($comment->user->name, 0, 1) }}</div>
                            @endif
                            <div class="comment-content">
                                <div class="comment-header">
                                    <span class="comment-author">{{ $comment->user->name }}</span>
                                    <span class="comment-date">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="comment-text" id="comment-text-{{ $comment->id }}">{{ $comment->content }}</p>
                                
                                <!-- Edit form (hidden by default) -->
                                <form action="{{ route('comments.update', $comment) }}" method="POST" class="comment-edit-form" id="edit-form-{{ $comment->id }}" style="display: none;">
                                    @csrf
                                    @method('PUT')
                                    <textarea name="content" rows="3" required>{{ $comment->content }}</textarea>
                                    <div class="edit-actions">
                                        <button type="submit" class="btn-sm btn-primary">Save</button>
                                        <button type="button" class="btn-sm btn-outline" onclick="cancelEdit({{ $comment->id }})">Cancel</button>
                                    </div>
                                </form>
                                
                                @auth
                                    <div class="comment-actions">
                                        @if($comment->isOwnedBy(auth()->user()))
                                            <button class="comment-action-btn" onclick="editComment({{ $comment->id }})">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                        @endif
                                        
                                        @if($comment->isOwnedBy(auth()->user()) || $post->isOwnedBy(auth()->user()))
                                            <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this comment?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="comment-action-btn delete">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @endauth
                            </div>
                        </div>
                    @empty
                        <p class="no-comments">No replies yet. Be the first to comment!</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.post-actions-bar {
    display: flex;
    gap: 0.75rem;
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 2px solid rgba(91, 163, 208, 0.1);
    flex-wrap: wrap;
}

.action-btn {
    padding: 0.6rem 1.5rem;
    border-radius: 25px;
    border: 2px solid #5BA3D0;
    background: white;
    color: #5BA3D0;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.95rem;
}

.action-btn:hover {
    background: #5BA3D0;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(91, 163, 208, 0.3);
}

.action-btn.liked {
    background: #FF6B9D;
    border-color: #FF6B9D;
    color: white;
}

.action-btn.liked:hover {
    background: #ff4582;
    border-color: #ff4582;
}

.action-btn.edit-btn {
    border-color: #9B7EDE;
    color: #9B7EDE;
}

.action-btn.edit-btn:hover {
    background: #9B7EDE;
    color: white;
}

.action-btn.delete-btn {
    border-color: #dc3545;
    color: #dc3545;
}

.action-btn.delete-btn:hover {
    background: #dc3545;
    color: white;
}

.comment-actions {
    margin-top: 0.5rem;
    display: flex;
    gap: 1rem;
}

.comment-action-btn {
    background: none;
    border: none;
    color: #5BA3D0;
    font-size: 0.9rem;
    cursor: pointer;
    padding: 0.25rem 0.5rem;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
}

.comment-action-btn:hover {
    color: #9B7EDE;
}

.comment-action-btn.delete {
    color: #dc3545;
}

.comment-action-btn.delete:hover {
    color: #bd2130;
}

.comment-edit-form {
    margin-top: 0.75rem;
}

.comment-edit-form textarea {
    width: 100%;
    padding: 0.75rem;
    border: 2px solid #5BA3D0;
    border-radius: 8px;
    font-family: inherit;
    resize: vertical;
}

.edit-actions {
    display: flex;
    gap: 0.5rem;
    margin-top: 0.5rem;
}

.btn-sm {
    padding: 0.4rem 1rem;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    border: none;
    transition: all 0.3s ease;
}

.btn-sm.btn-primary {
    background: linear-gradient(135deg, #5BA3D0, #9B7EDE);
    color: white;
}

.btn-sm.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 3px 10px rgba(91, 163, 208, 0.3);
}

.btn-sm.btn-outline {
    background: white;
    color: #666;
    border: 2px solid #ddd;
}

.btn-sm.btn-outline:hover {
    background: #f5f5f5;
}
</style>
@endpush

@push('scripts')
<script>
// Like button functionality
document.getElementById('like-btn')?.addEventListener('click', function() {
    const postId = this.dataset.postId;
    const btn = this;
    const likesCount = document.getElementById('likes-count');
    const likeText = document.getElementById('like-text');
    
    fetch(`/posts/${postId}/like`, {
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
            btn.classList.add('liked');
            likeText.textContent = 'Liked';
        } else {
            btn.classList.remove('liked');
            likeText.textContent = 'Like';
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
</script>
@endpush
@endsection
