@extends('layouts.app')

@section('content')
<div class="container-fluid" style="padding: 0; height: calc(100vh - 80px);">
    <div class="row g-0 h-100">
        <!-- Sidebar - Danh sách bạn bè -->
        <div class="col-md-4 col-lg-3 border-end" style="background: white; overflow-y: auto;">
            <div class="p-3 border-bottom">
                <h4 class="mb-0 fw-bold">Đoạn chat</h4>
            </div>
            
            <div class="p-2">
                <!-- Search box -->
                <div class="mb-2">
                    <input type="text" id="searchFriends" class="form-control rounded-pill" placeholder="Tìm kiếm trên Messenger">
                </div>

                <!-- Friends list -->
                <div id="friendsList">
                    @foreach($friends as $friend)
                        <a href="{{ route('messages.show', $friend->uid) }}" 
                           class="d-flex align-items-center p-2 text-decoration-none text-dark rounded friend-item {{ request()->route('user') == $friend->uid ? 'active' : '' }}"
                           data-name="{{ strtolower($friend->name) }}">
                            <div class="position-relative" style="flex-shrink: 0;">
                                @if($friend->profile_photo)
                                    <img src="{{ asset('storage/' . $friend->profile_photo) }}" 
                                         alt="{{ $friend->name }}" 
                                         style="width: 56px; height: 56px; border-radius: 50%; object-fit: cover;">
                                @elseif($friend->avatar)
                                    <img src="{{ $friend->avatar }}" 
                                         alt="{{ $friend->name }}" 
                                         style="width: 56px; height: 56px; border-radius: 50%; object-fit: cover;">
                                @else
                                    <div style="width: 56px; height: 56px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 20px;">
                                        {{ strtoupper(substr($friend->name, 0, 1)) }}
                                    </div>
                                @endif
                                @if($friend->is_online ?? false)
                                    <span class="position-absolute bottom-0 end-0" style="width: 14px; height: 14px; background: #31a24c; border: 2px solid white; border-radius: 50%;"></span>
                                @endif
                            </div>
                            <div class="ms-3 flex-fill" style="min-width: 0;">
                                <div class="fw-semibold text-truncate">{{ $friend->name }}</div>
                                @php
                                    $lastMsg = $lastMessages[$friend->uid] ?? null;
                                @endphp
                                @if($lastMsg)
                                    <small class="text-muted text-truncate d-block">
                                        @if($lastMsg->sender_id === auth()->user()->uid)
                                            Bạn: 
                                        @endif
                                        {{ $lastMsg->message }}
                                    </small>
                                @else
                                    <small class="text-muted">Bắt đầu trò chuyện</small>
                                @endif
                            </div>
                            @php
                                $unread = $unreadCounts[$friend->uid] ?? 0;
                            @endphp
                            @if($unread > 0)
                                <span class="badge rounded-pill" style="background: #0084ff; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 11px;">
                                    {{ $unread > 9 ? '9+' : $unread }}
                                </span>
                            @endif
                        </a>
                    @endforeach

                    @if($friends->isEmpty())
                        <div class="text-center py-5">
                            <i class="bi bi-people text-muted" style="font-size: 48px;"></i>
                            <p class="text-muted mt-3">Chưa có bạn bè nào</p>
                            <a href="{{ route('friends.index') }}" class="btn btn-sm btn-primary">
                                Tìm bạn bè
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Main chat area -->
        <div class="col-md-8 col-lg-9 d-flex align-items-center justify-content-center" style="background: #f0f2f5;">
            <div class="text-center">
                <i class="bi bi-chat-dots" style="font-size: 100px; color: #0084ff;"></i>
                <h4 class="mt-4">Chọn một đoạn chat</h4>
                <p class="text-muted">Chọn từ các cuộc hội thoại hiện có hoặc bắt đầu cuộc hội thoại mới.</p>
            </div>
        </div>
    </div>
</div>

<style>
.friend-item {
    transition: background 0.2s;
}
.friend-item:hover {
    background: #f0f2f5 !important;
}
.friend-item.active {
    background: #e7f3ff !important;
}
#searchFriends {
    background: #f0f2f5;
    border: none;
}
</style>

<script>
// Search friends
document.getElementById('searchFriends').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const friends = document.querySelectorAll('.friend-item');
    
    friends.forEach(friend => {
        const name = friend.getAttribute('data-name');
        if (name.includes(searchTerm)) {
            friend.style.display = 'flex';
        } else {
            friend.style.display = 'none';
        }
    });
});
</script>
@endsection
