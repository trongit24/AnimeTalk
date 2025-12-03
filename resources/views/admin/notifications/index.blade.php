@extends('admin.layout')

@section('title', 'Quản lý Thông báo')
@section('page-title', 'Quản lý Thông báo')

@section('content')
<div class="mb-6">
    <div class="flex justify-between items-center">
        <p class="text-gray-600">Gửi thông báo cho tất cả người dùng trong hệ thống</p>
        <a href="{{ route('admin.notifications.create') }}" class="px-6 py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-lg hover:shadow-lg transition">
            <i class="fas fa-plus mr-2"></i>Gửi thông báo mới
        </a>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

    @if($notifications->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Loại</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tiêu đề</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nội dung</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Thời gian</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($notifications as $notification)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $notification->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $badges = [
                                    'admin_announcement' => ['bg-blue-100 text-blue-800', 'Thông báo'],
                                    'system_maintenance' => ['bg-yellow-100 text-yellow-800', 'Bảo trì'],
                                    'new_event' => ['bg-green-100 text-green-800', 'Sự kiện mới'],
                                    'other' => ['bg-gray-100 text-gray-800', 'Khác']
                                ];
                                $badge = $badges[$notification->type] ?? ['bg-gray-100 text-gray-800', 'Khác'];
                            @endphp
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badge[0] }}">
                                {{ $badge[1] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $notification->title }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ \Illuminate\Support\Str::limit($notification->message, 60) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $notification->created_at->diffForHumans() }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <form action="{{ route('admin.notifications.destroy', $notification->id) }}" method="POST" onsubmit="return confirm('Xác nhận xóa thông báo này?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 transition" title="Xóa">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-200">
            {{ $notifications->links() }}
        </div>
    @else
        <div class="text-center py-16">
            <i class="fas fa-bell-slash text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 text-lg">Chưa có thông báo nào</p>
        </div>
    @endif
</div>
@endsection
