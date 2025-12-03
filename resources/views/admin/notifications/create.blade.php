@extends('admin.layout')

@section('title', 'Gửi Thông báo')
@section('page-title', 'Gửi Thông báo')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">
                <i class="fas fa-paper-plane mr-2 text-purple-600"></i>Gửi thông báo đến tất cả người dùng
            </h3>
        </div>

        <div class="p-6">
            <form action="{{ route('admin.notifications.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="type" class="block text-sm font-semibold text-gray-700 mb-2">Loại thông báo</label>
                    <select name="type" id="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('type') border-red-500 @enderror" required>
                        <option value="">-- Chọn loại --</option>
                        <option value="admin_announcement" {{ old('type') == 'admin_announcement' ? 'selected' : '' }}>
                            📢 Thông báo chung
                        </option>
                        <option value="system_maintenance" {{ old('type') == 'system_maintenance' ? 'selected' : '' }}>
                            ⚠️ Bảo trì hệ thống
                        </option>
                        <option value="new_event" {{ old('type') == 'new_event' ? 'selected' : '' }}>
                            🎉 Sự kiện mới
                        </option>
                        <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>
                            ℹ️ Khác
                        </option>
                    </select>
                    @error('type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Tiêu đề</label>
                    <input 
                        type="text" 
                        name="title" 
                        id="title" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('title') border-red-500 @enderror" 
                        value="{{ old('title') }}"
                        placeholder="VD: Hệ thống bảo trì vào 3h sáng..."
                        required
                    >
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">Nội dung</label>
                    <textarea 
                        name="message" 
                        id="message" 
                        rows="5" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('message') border-red-500 @enderror"
                        placeholder="Nhập nội dung chi tiết của thông báo..."
                        required
                    >{{ old('message') }}</textarea>
                    @error('message')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="action_url" class="block text-sm font-semibold text-gray-700 mb-2">Link hành động (tùy chọn)</label>
                    <input 
                        type="url" 
                        name="action_url" 
                        id="action_url" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('action_url') border-red-500 @enderror"
                        value="{{ old('action_url') }}"
                        placeholder="https://..."
                    >
                    <p class="mt-1 text-sm text-gray-500">Nếu có, người dùng sẽ được chuyển đến link này khi click vào thông báo</p>
                    @error('action_url')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                    <div class="flex">
                        <i class="fas fa-info-circle text-blue-500 mt-0.5 mr-3"></i>
                        <div>
                            <p class="text-sm text-blue-700">
                                <strong>Lưu ý:</strong> Thông báo này sẽ được gửi đến <strong>TẤT CẢ</strong> người dùng trong hệ thống.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="px-6 py-2 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-lg hover:shadow-lg transition">
                        <i class="fas fa-paper-plane mr-2"></i>Gửi thông báo
                    </button>
                    <a href="{{ route('admin.notifications.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        <i class="fas fa-times mr-2"></i>Hủy
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
