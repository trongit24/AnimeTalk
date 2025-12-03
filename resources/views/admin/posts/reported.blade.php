@extends('admin.layout')

@section('title', 'Bài viết bị báo cáo')
@section('page-title', 'Bài viết bị báo cáo')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Tổng báo cáo</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $posts->total() }}</p>
                </div>
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <i class="fas fa-flag text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Đã ẩn tự động</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $posts->where('is_hidden', true)->count() }}</p>
                </div>
                <div class="p-3 bg-red-100 rounded-lg">
                    <i class="fas fa-eye-slash text-red-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Chờ xử lý</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $posts->where('is_hidden', false)->count() }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-clock text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form method="GET" action="{{ route('admin.posts.reported') }}" class="space-y-4">
            <div class="flex flex-wrap gap-4">
                <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                    <option value="">Tất cả trạng thái</option>
                    <option value="hidden" {{ request('status') === 'hidden' ? 'selected' : '' }}>Đã ẩn</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                </select>
                
                <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                    <i class="fas fa-filter mr-2"></i>Lọc
                </button>
                @if(request()->hasAny(['status']))
                    <a href="{{ route('admin.posts.reported') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        <i class="fas fa-times mr-2"></i>Xóa bộ lọc
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Reported Posts Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bài viết</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tác giả</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Số báo cáo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lý do báo cáo</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Hành động</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($posts as $post)
                        <tr class="hover:bg-gray-50 transition {{ $post->is_hidden ? 'bg-red-50' : '' }}">
                            <td class="px-6 py-4">
                                <div class="flex items-start gap-3">
                                    @if($post->image)
                                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-16 h-16 rounded-lg object-cover flex-shrink-0">
                                    @else
                                        <div class="w-16 h-16 rounded-lg bg-gradient-to-br from-purple-400 to-pink-400 flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-file-alt text-white text-xl"></i>
                                        </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium text-gray-800 line-clamp-2">{{ $post->title }}</p>
                                        <p class="text-sm text-gray-500 line-clamp-1 mt-1">{{ Str::limit(strip_tags($post->content), 80) }}</p>
                                        <a href="{{ route('posts.show', $post->slug) }}" target="_blank" class="text-xs text-blue-600 hover:underline mt-1 inline-block">
                                            <i class="fas fa-external-link-alt mr-1"></i>Xem bài viết
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <img src="{{ $post->user->profile_photo ? asset('storage/' . $post->user->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode($post->user->name) }}" 
                                         alt="{{ $post->user->name }}" 
                                         class="w-8 h-8 rounded-full">
                                    <span class="text-sm text-gray-700">{{ $post->user->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 {{ $post->reports_count >= 3 ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700' }} text-sm font-medium rounded-full">
                                    <i class="fas fa-flag mr-1"></i>{{ $post->reports_count }} báo cáo
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($post->is_hidden)
                                    <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-medium rounded-full">
                                        <i class="fas fa-eye-slash mr-1"></i>Đã ẩn
                                    </span>
                                    <p class="text-xs text-gray-500 mt-1">{{ $post->hidden_at->diffForHumans() }}</p>
                                @else
                                    <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">
                                        <i class="fas fa-eye mr-1"></i>Đang hiển thị
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="space-y-1 max-w-xs">
                                    @foreach($post->reports->take(3) as $report)
                                        <div class="text-xs text-gray-600 bg-gray-50 p-2 rounded">
                                            <span class="font-medium">{{ $report->user->name }}:</span>
                                            <span class="text-gray-500">{{ Str::limit($report->reason, 50) }}</span>
                                        </div>
                                    @endforeach
                                    @if($post->reports_count > 3)
                                        <p class="text-xs text-gray-500 italic">+{{ $post->reports_count - 3 }} báo cáo khác</p>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    @if($post->is_hidden)
                                        <form action="{{ route('admin.posts.unhide', $post) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    onclick="return confirm('Hiển thị lại bài viết này?')"
                                                    class="px-3 py-1.5 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition"
                                                    title="Hiển thị lại">
                                                <i class="fas fa-eye mr-1"></i>Hiển thị
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <a href="{{ route('admin.posts.detail', $post) }}" 
                                       class="px-3 py-1.5 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition"
                                       title="Chi tiết">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                    
                                    <form action="{{ route('admin.posts.deleteReported', $post) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('Xóa bài viết này? Hành động không thể hoàn tác!')"
                                                class="px-3 py-1.5 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition"
                                                title="Xóa bài viết">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-check-circle text-green-500 text-5xl mb-4"></i>
                                    <p class="text-gray-500 text-lg">Không có bài viết bị báo cáo nào!</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($posts->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
