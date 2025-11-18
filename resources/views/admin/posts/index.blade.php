@extends('admin.layout')

@section('title', 'Quản lý bài viết')
@section('page-title', 'Quản lý bài viết')

@section('content')
<div class="space-y-6">
    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form method="GET" action="{{ route('admin.posts.index') }}" class="space-y-4">
            <div class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[250px]">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Tìm kiếm theo tiêu đề, nội dung..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>
                <select name="category" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                    <option value="">Tất cả danh mục</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex flex-wrap gap-4">
                <input type="date" 
                       name="date_from" 
                       value="{{ request('date_from') }}" 
                       class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                <input type="date" 
                       name="date_to" 
                       value="{{ request('date_to') }}" 
                       class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                
                <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                    <i class="fas fa-search mr-2"></i>Tìm kiếm
                </button>
                @if(request()->hasAny(['search', 'category', 'date_from', 'date_to']))
                    <a href="{{ route('admin.posts.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        <i class="fas fa-times mr-2"></i>Xóa bộ lọc
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Posts Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bài viết</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tác giả</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Danh mục</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thống kê</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày tạo</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Hành động</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($posts as $post)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-start gap-3">
                                    @if($post->image)
                                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-16 h-16 rounded-lg object-cover">
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium text-gray-800 line-clamp-2">{{ $post->title }}</p>
                                        <p class="text-sm text-gray-500 line-clamp-1 mt-1">{{ Str::limit(strip_tags($post->content), 100) }}</p>
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
                                @if($post->category)
                                    <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded-full">
                                        {{ $post->category }}
                                    </span>
                                @else
                                    <span class="text-gray-400 text-sm">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <div class="flex items-center gap-3">
                                    <span title="Bình luận"><i class="fas fa-comments text-blue-500"></i> {{ $post->comments_count }}</span>
                                    <span title="Lượt thích"><i class="fas fa-heart text-red-500"></i> {{ $post->likes_count }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $post->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.posts.show', $post) }}" class="text-blue-600 hover:text-blue-900" title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('posts.show', $post->slug) }}" target="_blank" class="text-green-600 hover:text-green-900" title="Xem trên trang">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" class="inline" 
                                          onsubmit="return confirm('Bạn có chắc muốn xóa bài viết này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-newspaper text-4xl mb-3 text-gray-300"></i>
                                <p>Không tìm thấy bài viết nào</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($posts->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
