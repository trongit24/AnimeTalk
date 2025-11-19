@extends('admin.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Tổng người dùng</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ number_format($stats['total_users']) }}</h3>
                    <p class="text-green-600 text-sm mt-1">+{{ $stats['new_users_today'] }} hôm nay</p>
                </div>
                <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-users text-blue-500 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Tổng bài viết</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ number_format($stats['total_posts']) }}</h3>
                    <p class="text-green-600 text-sm mt-1">+{{ $stats['new_posts_today'] }} hôm nay</p>
                </div>
                <div class="w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-newspaper text-purple-500 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-pink-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Tổng cộng đồng</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ number_format($stats['total_communities']) }}</h3>
                </div>
                <div class="w-14 h-14 bg-pink-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-users-rectangle text-pink-500 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Tổng bình luận</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ number_format($stats['total_comments']) }}</h3>
                    <p class="text-green-600 text-sm mt-1">+{{ $stats['new_comments_today'] }} hôm nay</p>
                </div>
                <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-comments text-green-500 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Top Posts -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-fire text-orange-500"></i>
                Top 5 Bài Viết Hot Nhất
            </h3>
            <div class="space-y-3">
                @forelse($topPosts as $post)
                    <a href="{{ route('admin.posts.show', $post) }}" class="block p-3 hover:bg-gray-50 rounded-lg transition">
                        <div class="flex items-start gap-3">
                            @if($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-16 h-16 rounded-lg object-cover flex-shrink-0">
                            @elseif($post->video)
                                <div class="w-16 h-16 rounded-lg bg-gray-800 flex items-center justify-center flex-shrink-0 relative overflow-hidden">
                                    <i class="fas fa-play text-white text-xl absolute z-10"></i>
                                    <video class="w-full h-full object-cover opacity-60">
                                        <source src="{{ asset('storage/' . $post->video) }}" type="video/mp4">
                                    </video>
                                </div>
                            @else
                                <div class="w-16 h-16 rounded-lg bg-gradient-to-br from-purple-400 to-pink-400 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-file-alt text-white text-xl"></i>
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <h4 class="font-medium text-gray-800 line-clamp-2">{{ $post->title }}</h4>
                                <div class="flex items-center gap-3 mt-1 text-sm text-gray-500">
                                    <span><i class="fas fa-user"></i> {{ $post->user->name }}</span>
                                    <span class="text-red-500"><i class="fas fa-heart"></i> {{ $post->likes_count }} tương tác</span>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <p class="text-gray-500 text-center py-8">Chưa có bài viết nào</p>
                @endforelse
            </div>
        </div>

        <!-- Top Communities -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-crown text-yellow-500"></i>
                Top 5 Cộng Đồng Lớn Nhất
            </h3>
            <div class="space-y-3">
                @forelse($topCommunities as $community)
                    <a href="{{ route('admin.communities.show', $community) }}" class="block p-3 hover:bg-gray-50 rounded-lg transition">
                        <div class="flex items-center gap-3">
                            @if($community->icon)
                                <img src="{{ asset('storage/' . $community->icon) }}" alt="{{ $community->name }}" class="w-12 h-12 rounded-lg object-cover">
                            @elseif($community->banner)
                                <img src="{{ asset('storage/' . $community->banner) }}" alt="{{ $community->name }}" class="w-12 h-12 rounded-lg object-cover">
                            @else
                                <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-pink-400 rounded-lg flex items-center justify-center text-white font-bold">
                                    {{ strtoupper(substr($community->name, 0, 2)) }}
                                </div>
                            @endif
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-800">{{ $community->name }}</h4>
                                <p class="text-sm text-gray-500"><i class="fas fa-users"></i> {{ $community->members_count }} thành viên</p>
                            </div>
                        </div>
                    </a>
                @empty
                    <p class="text-gray-500 text-center py-8">Chưa có cộng đồng nào</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Users -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-user-plus text-blue-500"></i>
                Người Dùng Mới Nhất
            </h3>
            <div class="space-y-3">
                @forelse($recentUsers as $user)
                    <a href="{{ route('admin.users.show', $user) }}" class="block p-3 hover:bg-gray-50 rounded-lg transition">
                        <div class="flex items-center gap-3">
                            <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}" 
                                 alt="{{ $user->name }}" 
                                 class="w-10 h-10 rounded-full">
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-800">{{ $user->name }}</h4>
                                <p class="text-sm text-gray-500">{{ $user->created_at->diffForHumans() }}</p>
                            </div>
                            @if($user->role === 'admin')
                                <span class="px-2 py-1 bg-purple-100 text-purple-700 text-xs rounded-full">Admin</span>
                            @endif
                        </div>
                    </a>
                @empty
                    <p class="text-gray-500 text-center py-8">Chưa có người dùng nào</p>
                @endforelse
            </div>
        </div>

        <!-- Recent Posts -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-clock text-green-500"></i>
                Bài Viết Mới Nhất
            </h3>
            <div class="space-y-3">
                @forelse($recentPosts as $post)
                    <a href="{{ route('admin.posts.show', $post) }}" class="block p-3 hover:bg-gray-50 rounded-lg transition">
                        <div class="flex items-start gap-3">
                            @if($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-12 h-12 rounded-lg object-cover flex-shrink-0">
                            @elseif($post->video)
                                <div class="w-12 h-12 rounded-lg bg-gray-800 flex items-center justify-center flex-shrink-0 relative overflow-hidden">
                                    <i class="fas fa-play text-white text-sm absolute z-10"></i>
                                    <video class="w-full h-full object-cover opacity-60">
                                        <source src="{{ asset('storage/' . $post->video) }}" type="video/mp4">
                                    </video>
                                </div>
                            @else
                                <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-purple-400 to-pink-400 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-file-alt text-white"></i>
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <h4 class="font-medium text-gray-800 line-clamp-2">{{ $post->title }}</h4>
                                <div class="flex items-center gap-3 mt-1 text-sm text-gray-500">
                                    <span><i class="fas fa-user"></i> {{ $post->user->name }}</span>
                                    <span>{{ $post->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <p class="text-gray-500 text-center py-8">Chưa có bài viết nào</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
