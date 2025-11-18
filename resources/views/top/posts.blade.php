@extends('layouts.app')

@section('title', 'Top Posts - AnimeTalk')

@section('content')
<div class="top-posts-page" style="background: #DAE0E6; min-height: calc(100vh - 60px); padding: 2rem 0;">
    <div class="container" style="max-width: 1200px; margin: 0 auto;">
        <div style="margin-bottom: 2rem;">
            <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.75rem;">
                <i class="bi bi-fire" style="color: #FF6B6B;"></i>
                Top Posts
            </h1>
            <p style="color: #666;">Most liked posts in our community</p>
        </div>

        <div style="display: grid; gap: 1.5rem;">
            @forelse($topPosts as $index => $post)
            <article style="background: white; border-radius: 12px; padding: 1.5rem; border: 1px solid #e0e0e0; transition: all 0.3s;" class="top-post-card">
                <div style="display: flex; gap: 1.5rem;">
                    <!-- Rank -->
                    <div style="font-size: 2.5rem; font-weight: 700; color: {{ $index < 3 ? ['#FFD700', '#C0C0C0', '#CD7F32'][$index] : '#999' }}; min-width: 60px; text-align: center;">
                        #{{ $index + 1 }}
                    </div>

                    <!-- Content -->
                    <div style="flex: 1;">
                        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem;">
                            @if($post->user->profile_photo)
                            <img src="{{ asset('storage/' . $post->user->profile_photo) }}" alt="{{ $post->user->name }}" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover;">
                            @else
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.9rem;">
                                {{ strtoupper(substr($post->user->name, 0, 1)) }}
                            </div>
                            @endif
                            <span style="font-weight: 600;">{{ $post->user->name }}</span>
                            <span style="color: #999;">•</span>
                            <span style="color: #666; font-size: 0.9rem;">{{ $post->created_at->diffForHumans() }}</span>
                        </div>

                        <a href="{{ route('posts.show', $post->slug) }}" style="text-decoration: none; color: inherit;">
                            <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.75rem; color: #1c1c1c; transition: color 0.3s;">
                                {{ $post->title }}
                            </h2>
                        </a>

                        <p style="color: #555; margin-bottom: 1rem; line-height: 1.6;">
                            {{ Str::limit($post->content, 200) }}
                        </p>

                        @if($post->tags->count() > 0)
                        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap; margin-bottom: 1rem;">
                            @foreach($post->tags as $tag)
                            <span style="background: {{ $tag->color }}15; color: {{ $tag->color }}; padding: 0.25rem 0.75rem; border-radius: 12px; font-size: 0.85rem; font-weight: 600;">
                                {{ $tag->name }}
                            </span>
                            @endforeach
                        </div>
                        @endif

                        <div style="display: flex; gap: 1.5rem; color: #666; font-size: 0.9rem; align-items: center;">
                            <span style="display: flex; align-items: center; gap: 0.5rem; font-size: 1.1rem;">
                                <i class="bi bi-fire-fill" style="color: #FF6B6B;"></i>
                                <strong style="color: #FF6B6B; font-size: 1.2rem;">{{ number_format($post->interactions_count) }}</strong>
                                <span style="color: #FF6B6B; font-weight: 600;">tương tác</span>
                            </span>
                            <span style="display: flex; align-items: center; gap: 0.5rem; color: #999;">
                                <i class="bi bi-heart-fill"></i>
                                {{ number_format($post->likes_count) }}
                            </span>
                            <span style="display: flex; align-items: center; gap: 0.5rem; color: #999;">
                                <i class="bi bi-chat-fill"></i>
                                {{ number_format($post->comments_count) }}
                            </span>
                        </div>
                    </div>

                    <!-- Thumbnail -->
                    @if($post->video || $post->image)
                    <div style="flex-shrink: 0;">
                        @if($post->video)
                            <div style="width: 120px; height: 120px; border-radius: 8px; overflow: hidden; position: relative; background: #000;">
                                <video style="width: 100%; height: 100%; object-fit: cover;">
                                    <source src="{{ asset('storage/' . $post->video) }}" type="video/mp4">
                                </video>
                                <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: rgba(0,0,0,0.7); border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-play-fill" style="color: white; font-size: 1.5rem;"></i>
                                </div>
                            </div>
                        @elseif($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" 
                                 style="width: 120px; height: 120px; border-radius: 8px; object-fit: cover;">
                        @endif
                    </div>
                    @endif
                </div>
            </article>
            @empty
            <div style="text-align: center; padding: 3rem; color: #999;">
                <i class="bi bi-inbox" style="font-size: 3rem; display: block; margin-bottom: 1rem;"></i>
                <p>No posts yet</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div style="margin-top: 2rem;">
            {{ $topPosts->links() }}
        </div>
    </div>
</div>

<style>
.top-post-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    border-color: #5BA3D0;
}

.top-post-card h2:hover {
    color: #5BA3D0;
}
</style>
@endsection
