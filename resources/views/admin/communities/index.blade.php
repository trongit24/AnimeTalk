@extends('admin.layout')

@section('title', 'Quản lý cộng đồng')
@section('page-title', 'Quản lý cộng đồng')

@section('content')
<div class="space-y-6">
    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form method="GET" action="{{ route('admin.communities.index') }}" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[250px]">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Tìm kiếm theo tên, mô tả..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>
            <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                <i class="fas fa-search mr-2"></i>Tìm kiếm
            </button>
            @if(request('search'))
                <a href="{{ route('admin.communities.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                    <i class="fas fa-times mr-2"></i>Xóa bộ lọc
                </a>
            @endif
        </form>
    </div>

    <!-- Communities Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($communities as $community)
            <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-lg transition">
                @if($community->banner)
                    <img src="{{ asset('storage/' . $community->banner) }}" alt="{{ $community->name }}" class="w-full h-48 object-cover">
                @elseif($community->icon)
                    <div class="w-full h-48 bg-gray-100 flex items-center justify-center">
                        <img src="{{ asset('storage/' . $community->icon) }}" alt="{{ $community->name }}" class="w-32 h-32 object-contain">
                    </div>
                @else
                    <div class="w-full h-48 bg-gradient-to-br from-purple-400 to-pink-400 flex items-center justify-center">
                        <span class="text-6xl text-white font-bold">{{ strtoupper(substr($community->name, 0, 2)) }}</span>
                    </div>
                @endif

                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $community->name }}</h3>
                    
                    @if($community->description)
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $community->description }}</p>
                    @endif

                    <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                        <span><i class="fas fa-users text-blue-500 mr-1"></i>{{ $community->members_count }} thành viên</span>
                        <span><i class="fas fa-newspaper text-purple-500 mr-1"></i>{{ $community->posts_count }} bài viết</span>
                    </div>

                    <div class="flex items-center gap-2 pt-4 border-t">
                        <a href="{{ route('admin.communities.show', $community) }}" class="flex-1 px-4 py-2 bg-blue-500 text-white text-center rounded-lg hover:bg-blue-600 transition">
                            <i class="fas fa-eye mr-2"></i>Xem
                        </a>
                        <a href="{{ route('communities.show', $community->slug) }}" target="_blank" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition" title="Xem trên trang">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.communities.destroy', $community) }}" class="inline" 
                              onsubmit="return confirm('Bạn có chắc muốn xóa cộng đồng này?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition" title="Xóa">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="bg-white rounded-xl shadow-sm p-12 text-center text-gray-500">
                    <i class="fas fa-users-rectangle text-6xl mb-4 text-gray-300"></i>
                    <p class="text-xl">Không tìm thấy cộng đồng nào</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($communities->hasPages())
        <div class="bg-white rounded-xl shadow-sm p-6">
            {{ $communities->links() }}
        </div>
    @endif
</div>
@endsection
