@extends('admin.layout')

@section('title', 'Chi tiết bài viết')
@section('page-title', 'Chi tiết bài viết')

@section('content')
<div class="space-y-6">
    <!-- Back Button -->
    <a href="{{ route('admin.posts.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800">
        <i class="fas fa-arrow-left"></i>
        <span>Quay lại danh sách</span>
    </a>

    <!-- Post Content -->
    <div class="bg-white rounded-xl shadow-sm p-8">
        <div class="flex items-start justify-between mb-6">
            <div class="flex-1">
                <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $post->title }}</h1>
                
                <div class="flex items-center gap-4 text-sm text-gray-600">
                    <div class="flex items-center gap-2">
                        <img src="{{ $post->user->profile_photo ? asset('storage/' . $post->user->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode($post->user->name) }}" 
                             alt="{{ $post->user->name }}" 
                             class="w-8 h-8 rounded-full">
                        <span>{{ $post->user->name }}</span>
                    </div>
                    <span>•</span>
                    <span>{{ $post->created_at->format('d/m/Y H:i') }}</span>
                    @if($post->category)
                        <span>•</span>
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded-full">
                            {{ $post->category }}
                        </span>
                    @endif
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('posts.show', $post->slug) }}" target="_blank" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                    <i class="fas fa-external-link-alt mr-2"></i>Xem trên trang
                </a>
                <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" 
                      onsubmit="return confirm('Bạn có chắc muốn xóa bài viết này?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                        <i class="fas fa-trash mr-2"></i>Xóa
                    </button>
                </form>
            </div>
        </div>

        @if($post->image)
            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full rounded-lg mb-6">
        @endif

        <div class="prose max-w-none">
            {!! nl2br(e($post->content)) !!}
        </div>

        @if($post->tags && $post->tags->count() > 0)
            <div class="flex flex-wrap gap-2 mt-6 pt-6 border-t">
                @foreach($post->tags as $tag)
                    <span class="px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-full">
                        #{{ $tag->name }}
                    </span>
                @endforeach
            </div>
        @endif

        <div class="flex items-center gap-6 mt-6 pt-6 border-t text-gray-600">
            <span><i class="fas fa-heart text-red-500 mr-2"></i>{{ $post->likes_count }} lượt thích</span>
            <span><i class="fas fa-comments text-blue-500 mr-2"></i>{{ $post->comments_count }} bình luận</span>
        </div>
    </div>

    <!-- Comments -->
    @if($post->comments && $post->comments->count() > 0)
        <div class="bg-white rounded-xl shadow-sm p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Bình luận ({{ $post->comments_count }})</h2>
            
            <div class="space-y-4">
                @foreach($post->comments as $comment)
                    <div class="border-l-2 border-gray-200 pl-4 py-2">
                        <div class="flex items-start gap-3">
                            <img src="{{ $comment->user->profile_photo ? asset('storage/' . $comment->user->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name) }}" 
                                 alt="{{ $comment->user->name }}" 
                                 class="w-10 h-10 rounded-full">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="font-medium text-gray-800">{{ $comment->user->name }}</span>
                                    <span class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                @php
                                    $content = $comment->content;
                                    $isImageUrl = preg_match('/^https?:\/\/.*(giphy\.com|\.gif|\.jpg|\.jpeg|\.png|\.webp)/i', $content);
                                @endphp
                                
                                @if($isImageUrl)
                                    <img src="{{ $content }}" alt="GIF" class="mt-2 max-w-sm rounded-lg">
                                @else
                                    <p class="text-gray-700">{{ $content }}</p>
                                @endif
                                
                                @if($comment->image)
                                    <img src="{{ asset('storage/' . $comment->image) }}" alt="Comment image" class="mt-2 max-w-sm rounded-lg">
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
