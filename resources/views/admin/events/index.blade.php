@extends('admin.layout')

@section('title', 'Quản lý sự kiện')
@section('page-title', 'Quản lý sự kiện')

@section('content')
<div class="space-y-6">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Tổng sự kiện</p>
                    <p class="text-3xl font-bold mt-2">{{ $totalEvents }}</p>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <i class="fas fa-calendar-alt text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Sắp diễn ra</p>
                    <p class="text-3xl font-bold mt-2">{{ $upcomingEvents }}</p>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <i class="fas fa-clock text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-gray-500 to-gray-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-100 text-sm font-medium">Đã qua</p>
                    <p class="text-3xl font-bold mt-2">{{ $pastEvents }}</p>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <i class="fas fa-history text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form method="GET" action="{{ route('admin.events.index') }}" class="space-y-4">
            <div class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[250px]">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Tìm kiếm theo tên sự kiện..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>
                
                <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                    <i class="fas fa-search mr-2"></i>Tìm kiếm
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.events.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        <i class="fas fa-times mr-2"></i>Xóa bộ lọc
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Bulk Actions Form -->
    <form id="bulk-action-form" method="POST" action="{{ route('admin.events.destroyMultiple') }}" 
          onsubmit="return confirm('Bạn có chắc muốn xóa các sự kiện đã chọn?')">
        @csrf
        @method('DELETE')

        <!-- Events Table -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <input type="checkbox" id="select-all" class="w-5 h-5 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                    <label for="select-all" class="text-sm text-gray-700">Chọn tất cả</label>
                </div>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition disabled:opacity-50" 
                        id="bulk-delete-btn" disabled>
                    <i class="fas fa-trash mr-2"></i>Xóa đã chọn
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left">
                                <span class="sr-only">Chọn</span>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sự kiện</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Người tạo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thời gian</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Địa điểm</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Người tham gia</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($events as $event)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <input type="checkbox" name="event_ids[]" value="{{ $event->id }}" 
                                           class="event-checkbox w-5 h-5 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-start gap-3">
                                        @if($event->cover_image)
                                            <img src="{{ asset('storage/' . $event->cover_image) }}" alt="{{ $event->title }}" class="w-16 h-16 rounded-lg object-cover">
                                        @else
                                            <div class="w-16 h-16 bg-purple-100 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-calendar-alt text-purple-500 text-xl"></i>
                                            </div>
                                        @endif
                                        <div class="flex-1 min-w-0">
                                            <p class="font-medium text-gray-800 line-clamp-2">{{ $event->title }}</p>
                                            @if($event->description)
                                                <p class="text-sm text-gray-500 line-clamp-1 mt-1">{{ Str::limit($event->description, 80) }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <img src="{{ $event->owner->profile_photo ? asset('storage/' . $event->owner->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode($event->owner->name) }}" 
                                             alt="{{ $event->owner->name }}" 
                                             class="w-8 h-8 rounded-full">
                                        <span class="text-sm text-gray-700">{{ $event->owner->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <div>
                                        <i class="fas fa-calendar-day text-purple-500"></i>
                                        {{ $event->start_time->format('d/m/Y') }}
                                    </div>
                                    <div class="text-gray-500 mt-1">
                                        <i class="fas fa-clock"></i>
                                        {{ $event->start_time->format('H:i') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    @if($event->location)
                                        <i class="fas fa-map-marker-alt text-red-500"></i>
                                        {{ Str::limit($event->location, 30) }}
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full font-medium">
                                        <i class="fas fa-users"></i> {{ $event->participants_count }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($event->isPast())
                                        <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs font-medium rounded-full">
                                            <i class="fas fa-check-circle"></i> Đã qua
                                        </span>
                                    @elseif($event->isToday())
                                        <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">
                                            <i class="fas fa-play-circle"></i> Hôm nay
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-medium rounded-full">
                                            <i class="fas fa-clock"></i> Sắp tới
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.events.show', $event) }}" class="text-blue-600 hover:text-blue-900" title="Xem chi tiết">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('events.show', $event) }}" target="_blank" class="text-green-600 hover:text-green-900" title="Xem trên trang">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                        <button type="button" onclick="deleteEvent({{ $event->id }})" class="text-red-600 hover:text-red-900" title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                    <i class="fas fa-calendar-alt text-4xl mb-3 text-gray-300"></i>
                                    <p>Không tìm thấy sự kiện nào</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($events->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $events->links() }}
                </div>
            @endif
        </div>
    </form>
</div>

<!-- Delete Form (Hidden) -->
<form id="delete-event-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
    // Select all functionality
    document.getElementById('select-all').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.event-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkDeleteButton();
    });

    // Update bulk delete button state
    document.querySelectorAll('.event-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkDeleteButton);
    });

    function updateBulkDeleteButton() {
        const checkedBoxes = document.querySelectorAll('.event-checkbox:checked');
        const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
        bulkDeleteBtn.disabled = checkedBoxes.length === 0;
    }

    // Delete single event
    function deleteEvent(eventId) {
        if (confirm('Bạn có chắc muốn xóa sự kiện này?')) {
            const form = document.getElementById('delete-event-form');
            form.action = `/admin/events/${eventId}`;
            form.submit();
        }
    }
</script>
@endsection
