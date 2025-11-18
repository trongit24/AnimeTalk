@extends('admin.layout')

@section('title', 'Chi tiết sự kiện')
@section('page-title', 'Chi tiết sự kiện')

@section('content')
<div class="space-y-6">
    <!-- Back Button -->
    <a href="{{ route('admin.events.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800">
        <i class="fas fa-arrow-left"></i>
        <span>Quay lại danh sách</span>
    </a>

    <!-- Event Header -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        @if($event->cover_image)
            <div class="h-64 bg-cover bg-center" style="background-image: url('{{ asset('storage/' . $event->cover_image) }}')">
                <div class="h-full w-full bg-gradient-to-b from-transparent to-black/50 flex items-end p-8">
                    <div class="text-white">
                        <h1 class="text-4xl font-bold mb-2">{{ $event->title }}</h1>
                        <div class="flex items-center gap-4 text-sm">
                            <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full">
                                <i class="fas fa-globe"></i> {{ ucfirst($event->privacy) }}
                            </span>
                            @if($event->isPast())
                                <span class="px-3 py-1 bg-gray-500/80 backdrop-blur-sm rounded-full">
                                    <i class="fas fa-check-circle"></i> Đã qua
                                </span>
                            @elseif($event->isToday())
                                <span class="px-3 py-1 bg-green-500/80 backdrop-blur-sm rounded-full">
                                    <i class="fas fa-play-circle"></i> Hôm nay
                                </span>
                            @else
                                <span class="px-3 py-1 bg-yellow-500/80 backdrop-blur-sm rounded-full">
                                    <i class="fas fa-clock"></i> Sắp tới
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="h-64 bg-gradient-to-r from-purple-500 to-pink-500 flex items-center justify-center">
                <div class="text-center text-white">
                    <i class="fas fa-calendar-alt text-6xl mb-4"></i>
                    <h1 class="text-4xl font-bold">{{ $event->title }}</h1>
                </div>
            </div>
        @endif

        <div class="p-8">
            <!-- Event Info Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-6">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="bg-blue-500 text-white rounded-full p-3">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <div>
                            <p class="text-sm text-blue-600 font-medium">Ngày bắt đầu</p>
                            <p class="text-lg font-bold text-gray-800">{{ $event->start_time->format('d/m/Y') }}</p>
                            <p class="text-sm text-gray-600">{{ $event->start_time->format('H:i') }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-6">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="bg-purple-500 text-white rounded-full p-3">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <p class="text-sm text-purple-600 font-medium">Kết thúc</p>
                            <p class="text-lg font-bold text-gray-800">{{ $event->end_time->format('d/m/Y') }}</p>
                            <p class="text-sm text-gray-600">{{ $event->end_time->format('H:i') }}</p>
                        </div>
                    </div>
                </div>

                @if($event->location)
                    <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-lg p-6">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="bg-red-500 text-white rounded-full p-3">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <p class="text-sm text-red-600 font-medium">Địa điểm</p>
                                <p class="text-base font-bold text-gray-800">{{ $event->location }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Event Host -->
            <div class="mb-8 pb-8 border-b">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Người tạo sự kiện</h3>
                <div class="flex items-center gap-3">
                    <img src="{{ $event->owner->profile_photo ? asset('storage/' . $event->owner->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode($event->owner->name) }}" 
                         alt="{{ $event->owner->name }}" 
                         class="w-16 h-16 rounded-full border-2 border-purple-500">
                    <div>
                        <p class="font-bold text-gray-800">{{ $event->owner->name }}</p>
                        <p class="text-sm text-gray-600">{{ $event->owner->email }}</p>
                        <p class="text-xs text-gray-500">Tạo vào {{ $event->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Event Description -->
            @if($event->description)
                <div class="mb-8 pb-8 border-b">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Chi tiết sự kiện</h3>
                    <div class="prose max-w-none text-gray-700">
                        {!! nl2br(e($event->description)) !!}
                    </div>
                </div>
            @endif

            <!-- Participants Statistics -->
            <div class="mb-8 pb-8 border-b">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Thống kê người tham gia</h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="bg-green-50 rounded-lg p-4 text-center">
                        <p class="text-3xl font-bold text-green-600">
                            {{ $event->participants->where('pivot.status', 'going')->count() }}
                        </p>
                        <p class="text-sm text-gray-600 mt-1">Tham gia</p>
                    </div>
                    <div class="bg-yellow-50 rounded-lg p-4 text-center">
                        <p class="text-3xl font-bold text-yellow-600">
                            {{ $event->participants->where('pivot.status', 'interested')->count() }}
                        </p>
                        <p class="text-sm text-gray-600 mt-1">Quan tâm</p>
                    </div>
                    <div class="bg-blue-50 rounded-lg p-4 text-center">
                        <p class="text-3xl font-bold text-blue-600">
                            {{ $event->participants->where('pivot.status', 'invited')->count() }}
                        </p>
                        <p class="text-sm text-gray-600 mt-1">Được mời</p>
                    </div>
                    <div class="bg-red-50 rounded-lg p-4 text-center">
                        <p class="text-3xl font-bold text-red-600">
                            {{ $event->participants->where('pivot.status', 'declined')->count() }}
                        </p>
                        <p class="text-sm text-gray-600 mt-1">Từ chối</p>
                    </div>
                </div>
            </div>

            <!-- Participants List -->
            @if($event->participants->count() > 0)
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Danh sách người tham gia</h3>
                    
                    <!-- Going -->
                    @php
                        $going = $event->participants->where('pivot.status', 'going');
                    @endphp
                    @if($going->count() > 0)
                        <div class="mb-6">
                            <h4 class="font-medium text-green-600 mb-3">
                                <i class="fas fa-check-circle"></i> Tham gia ({{ $going->count() }})
                            </h4>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                @foreach($going as $participant)
                                    <div class="flex items-center gap-2 p-2 bg-gray-50 rounded-lg">
                                        <img src="{{ $participant->profile_photo ? asset('storage/' . $participant->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode($participant->name) }}" 
                                             alt="{{ $participant->name }}" 
                                             class="w-10 h-10 rounded-full">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-800 truncate">{{ $participant->name }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Interested -->
                    @php
                        $interested = $event->participants->where('pivot.status', 'interested');
                    @endphp
                    @if($interested->count() > 0)
                        <div class="mb-6">
                            <h4 class="font-medium text-yellow-600 mb-3">
                                <i class="fas fa-star"></i> Quan tâm ({{ $interested->count() }})
                            </h4>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                @foreach($interested as $participant)
                                    <div class="flex items-center gap-2 p-2 bg-gray-50 rounded-lg">
                                        <img src="{{ $participant->profile_photo ? asset('storage/' . $participant->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode($participant->name) }}" 
                                             alt="{{ $participant->name }}" 
                                             class="w-10 h-10 rounded-full">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-800 truncate">{{ $participant->name }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-users text-4xl mb-3 text-gray-300"></i>
                    <p>Chưa có người tham gia</p>
                </div>
            @endif

            <!-- Actions -->
            <div class="flex items-center gap-3 mt-8 pt-8 border-t">
                <a href="{{ route('events.show', $event) }}" target="_blank" class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                    <i class="fas fa-external-link-alt mr-2"></i>Xem trên trang
                </a>
                <form method="POST" action="{{ route('admin.events.destroy', $event) }}" 
                      onsubmit="return confirm('Bạn có chắc muốn xóa sự kiện này? Tất cả dữ liệu liên quan sẽ bị xóa.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-6 py-3 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                        <i class="fas fa-trash mr-2"></i>Xóa sự kiện
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
