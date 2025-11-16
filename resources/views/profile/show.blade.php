@extends('layouts.app')

@section('title', $user->name . ' - AnimeTalk')

@section('content')
<div style="background: #f0f2f5; min-height: 100vh; padding-bottom: 2rem;">
    <!-- Cover Photo -->
    <div style="height: 300px; position: relative; background-size: cover; background-position: center; @if($user->cover_photo) background-image: url('{{ asset('storage/' . $user->cover_photo) }}'); @else background: linear-gradient(135deg, #5BA3D0, #9B7EDE, #FFB6C1); @endif">
        <div style="position: absolute; bottom: -60px; left: 50%; transform: translateX(-50%); text-align: center;">
            @if($user->profile_photo)
                <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="{{ $user->name }}" 
                     style="width: 168px; height: 168px; border-radius: 50%; border: 5px solid white; object-fit: cover; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
            @else
                <div style="width: 168px; height: 168px; border-radius: 50%; border: 5px solid white; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; display: inline-flex; align-items: center; justify-content: center; font-size: 4rem; font-weight: 600; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            @endif
        </div>
    </div>

    <!-- Profile Info -->
    <div style="max-width: 940px; margin: 0 auto; padding: 0 1rem;">
        <div style="margin-top: 80px; text-align: center; margin-bottom: 2rem;">
            <h1 style="font-size: 2rem; margin-bottom: 0.5rem; color: #1c1c1c;">{{ $user->name }}</h1>
            @if($user->bio)
                <p style="color: #666; font-size: 1rem; max-width: 600px; margin: 0 auto;">{{ $user->bio }}</p>
            @endif
            
            @if(Auth::user()->uid === $user->uid)
                <div style="margin-top: 1rem; display: flex; gap: 0.75rem; justify-content: center;">
                    <a href="{{ route('profile.edit') }}" style="background: #e4e6eb; padding: 0.6rem 1.5rem; border-radius: 8px; text-decoration: none; color: #1c1c1c; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem;">
                        <i class="bi bi-pencil"></i> Chỉnh sửa trang cá nhân
                    </a>
                </div>
            @endif
        </div>

        <!-- Navigation Tabs -->
        <div style="background: white; border-radius: 8px; box-shadow: 0 1px 2px rgba(0,0,0,0.1); margin-bottom: 1rem;">
            <div style="display: flex; gap: 0.5rem; padding: 0 1rem; border-bottom: 1px solid #e4e6eb;">
                <button style="background: none; border: none; padding: 1rem 1.5rem; color: #1877f2; font-weight: 600; border-bottom: 3px solid #1877f2; cursor: pointer;">
                    Bài viết
                </button>
            </div>
        </div>

        <!-- Posts Grid -->
        <div style="display: grid; grid-template-columns: 1fr; gap: 1rem;">
            @forelse($posts as $post)
            <article style="background: white; border-radius: 8px; box-shadow: 0 1px 2px rgba(0,0,0,0.1); padding: 1.5rem; transition: transform 0.2s;">
                <!-- Post Header -->
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
                    @if($user->profile_photo)
                        <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="{{ $user->name }}" 
                             style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                    @else
                        <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; display: flex; align-items: center; justify-content: center; font-weight: 600;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                    <div style="flex: 1;">
                        <div style="font-weight: 600; color: #1c1c1c;">{{ $user->name }}</div>
                        <div style="color: #666; font-size: 0.875rem;">{{ $post->created_at->diffForHumans() }}</div>
                    </div>
                </div>

                <!-- Post Content -->
                <a href="{{ route('posts.show', $post->slug) }}" style="text-decoration: none; color: inherit; display: block;">
                    <h3 style="font-size: 1.25rem; margin-bottom: 0.75rem; color: #1c1c1c;">{{ $post->title }}</h3>
                    <p style="color: #333; line-height: 1.6; margin-bottom: 1rem;">{{ Str::limit($post->content, 300) }}</p>
                    
                    @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" 
                             style="width: 100%; max-height: 400px; object-fit: cover; border-radius: 8px; margin-bottom: 1rem;">
                    @endif

                    @if($post->video)
                        <video controls style="width: 100%; max-height: 400px; border-radius: 8px; margin-bottom: 1rem;">
                            <source src="{{ asset('storage/' . $post->video) }}" type="video/mp4">
                        </video>
                    @endif
                </a>

                <!-- Tags -->
                @if($post->tags->count() > 0)
                <div style="display: flex; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 1rem;">
                    @foreach($post->tags as $tag)
                    <span style="background: {{ $tag->color }}15; color: {{ $tag->color }}; padding: 0.25rem 0.75rem; border-radius: 12px; font-size: 0.875rem;">
                        {{ $tag->name }}
                    </span>
                    @endforeach
                </div>
                @endif

                <!-- Post Stats -->
                <div style="display: flex; gap: 1.5rem; padding-top: 0.75rem; border-top: 1px solid #e4e6eb; color: #666; font-size: 0.9rem;">
                    <span><i class="bi bi-heart-fill" style="color: #FF6B6B;"></i> {{ $post->likes()->count() }} Likes</span>
                    <span><i class="bi bi-chat-fill" style="color: #5BA3D0;"></i> {{ $post->comments()->count() }} Comments</span>
                </div>
            </article>
            @empty
            <div style="background: white; border-radius: 8px; box-shadow: 0 1px 2px rgba(0,0,0,0.1); padding: 3rem; text-align: center;">
                <i class="bi bi-inbox" style="font-size: 3rem; color: #999; display: block; margin-bottom: 1rem;"></i>
                <p style="color: #666;">Chưa có bài viết nào</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($posts->hasPages())
        <div style="margin-top: 2rem;">
            {{ $posts->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
