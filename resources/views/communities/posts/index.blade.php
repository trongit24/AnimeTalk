@if($posts->count() > 0)
    @foreach($posts as $post)
    <div style="background: white; border-radius: 12px; padding: 1.5rem; border: 1px solid #e0e0e0; margin-bottom: 1rem;">
        <!-- Post Header -->
        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
            @if($post->user->profile_photo)
            <img src="{{ asset('storage/' . $post->user->profile_photo) }}" alt="{{ $post->user->name }}" 
                 style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
            @else
            <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700;">
                {{ strtoupper(substr($post->user->name, 0, 1)) }}
            </div>
            @endif
            <div style="flex: 1;">
                <div style="font-weight: 600; color: #333;">{{ $post->user->name }}</div>
                <div style="font-size: 0.85rem; color: #999;">{{ $post->created_at->diffForHumans() }}</div>
            </div>
            @auth
            @if($post->user_id === auth()->user()->uid || $community->canManagePosts(auth()->user()))
            <div class="dropdown">
                <button class="btn btn-sm" type="button" data-bs-toggle="dropdown" style="background: none; border: none; color: #999;">
                    <i class="bi bi-three-dots-vertical"></i>
                </button>
                <ul class="dropdown-menu">
                    @if($post->user_id === auth()->user()->uid || $community->canManagePosts(auth()->user()))
                    <li>
                        <form action="{{ route('communities.posts.destroy', [$community->slug, $post]) }}" method="POST" style="margin: 0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Bạn chắc chắn muốn xóa bài viết này?')">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                    </li>
                    @endif
                </ul>
            </div>
            @endif
            @endauth
        </div>

        <!-- Post Content -->
        <div style="color: #333; line-height: 1.6; margin-bottom: 1rem;">
            {{ $post->content }}
        </div>

        <!-- Post Image -->
        @if($post->image)
        <div style="margin-bottom: 1rem;">
            <img src="{{ asset('storage/' . $post->image) }}" alt="Post image" 
                 style="width: 100%; max-height: 500px; object-fit: contain; border-radius: 8px; border: 1px solid #e0e0e0;">
        </div>
        @endif

        <!-- Post Video -->
        @if($post->video)
        <div style="margin-bottom: 1rem;">
            <video controls style="width: 100%; max-height: 500px; border-radius: 8px; border: 1px solid #e0e0e0;">
                <source src="{{ asset('storage/' . $post->video) }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
        @endif

        <!-- Post Footer -->
        <div style="display: flex; align-items: center; gap: 1.5rem; padding-top: 1rem; border-top: 1px solid #f0f0f0; color: #666; font-size: 0.9rem;">
            <span><i class="bi bi-heart"></i> 0 likes</span>
            <span><i class="bi bi-chat"></i> 0 comments</span>
        </div>
    </div>
    @endforeach

    <!-- Pagination -->
    @if($posts->hasPages())
    <div style="margin-top: 1.5rem;">
        {{ $posts->links() }}
    </div>
    @endif
@else
<div style="background: white; border-radius: 12px; padding: 3rem; text-align: center; border: 1px solid #e0e0e0;">
    <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
    <p style="margin-top: 1rem; color: #666;">No posts yet. Be the first to post!</p>
</div>
@endif
