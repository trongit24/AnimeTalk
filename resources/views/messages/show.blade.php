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
                    @foreach($allFriends as $friendItem)
                        <a href="{{ route('messages.show', $friendItem->uid) }}" 
                           class="d-flex align-items-center p-2 text-decoration-none text-dark rounded friend-item {{ $friendItem->uid == $friend->uid ? 'active' : '' }}"
                           data-name="{{ strtolower($friendItem->name) }}">
                            <div class="position-relative" style="flex-shrink: 0;">
                                @if($friendItem->profile_photo)
                                    <img src="{{ asset('storage/' . $friendItem->profile_photo) }}" 
                                         alt="{{ $friendItem->name }}" 
                                         style="width: 56px; height: 56px; border-radius: 50%; object-fit: cover;">
                                @else
                                    <div style="width: 56px; height: 56px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 20px;">
                                        {{ strtoupper(substr($friendItem->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div class="ms-3 flex-fill" style="min-width: 0;">
                                <div class="fw-semibold text-truncate">{{ $friendItem->name }}</div>
                                @php
                                    $lastMsg = $lastMessages[$friendItem->uid] ?? null;
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
                                $unread = $unreadCounts[$friendItem->uid] ?? 0;
                            @endphp
                            @if($unread > 0 && $friendItem->uid != $friend->uid)
                                <span class="badge rounded-pill" style="background: #0084ff; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 11px;">
                                    {{ $unread > 9 ? '9+' : $unread }}
                                </span>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Main chat area -->
        <div class="col-md-8 col-lg-9 d-flex flex-column" style="background: white;">
            <!-- Chat Header -->
            <div class="p-3 border-bottom d-flex align-items-center gap-3" style="box-shadow: 0 1px 2px rgba(0,0,0,0.1);">
                @if($friend->profile_photo)
                    <img src="{{ asset('storage/' . $friend->profile_photo) }}" 
                         alt="{{ $friend->name }}" 
                         style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                @else
                    <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                        {{ strtoupper(substr($friend->name, 0, 1)) }}
                    </div>
                @endif
                
                <div class="flex-fill">
                    <h6 class="mb-0 fw-semibold">{{ $friend->name }}</h6>
                    <small class="text-muted">Đang hoạt động</small>
                </div>
            </div>

            <!-- Messages Container -->
            <div id="messagesContainer" class="flex-fill overflow-auto p-3" style="background: white;">
            @forelse($messages as $message)
                @php
                    $isOwnMessage = $message->sender_id === auth()->user()->uid;
                @endphp
                <div class="mb-3 d-flex {{ $isOwnMessage ? 'justify-content-end' : 'justify-content-start' }}">
                    <div class="d-flex gap-2" style="max-width: 70%; {{ $isOwnMessage ? 'flex-direction: row-reverse;' : '' }}">
                        <!-- Avatar for received messages -->
                        @if(!$isOwnMessage)
                            @if($friend->profile_photo)
                                <img src="{{ asset('storage/' . $friend->profile_photo) }}" 
                                     alt="{{ $friend->name }}" 
                                     style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; flex-shrink: 0;">
                            @else
                                <div style="width: 32px; height: 32px; border-radius: 50%; background: #6c757d; color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 14px; flex-shrink: 0;">
                                    {{ strtoupper(substr($friend->name, 0, 1)) }}
                                </div>
                            @endif
                        @endif

                        <div>
                            <div class="rounded-pill px-3 py-2" style="background: {{ $isOwnMessage ? '#0084ff' : '#e4e6eb' }}; color: {{ $isOwnMessage ? 'white' : '#050505' }};">
                                <p class="mb-0" style="font-size: 15px;">{{ $message->message }}</p>
                            </div>
                            <small class="text-muted d-block {{ $isOwnMessage ? 'text-end' : '' }}" style="font-size: 11px; margin-top: 4px; padding: 0 12px;">
                                {{ $message->created_at->format('g:i A') }}
                            </small>
                        </div>
                    </div>
                </div>
            @empty
                <div class="d-flex align-items-center justify-content-center h-100">
                    <div class="text-center">
                        <i class="bi bi-chat-dots text-muted" style="font-size: 48px;"></i>
                        <h5 class="mt-3">No messages yet</h5>
                        <p class="text-muted">Send a message to start the conversation!</p>
                    </div>
                </div>
            @endforelse
            </div>

            <!-- Message Input -->
            <div class="p-3 border-top" style="background: #f0f2f5;">
                <form id="messageForm" class="d-flex gap-2">
                    @csrf
                    <input type="text" 
                           id="messageInput"
                           name="message" 
                           placeholder="Aa" 
                           class="form-control rounded-pill"
                           style="background: white; border: none;"
                           autocomplete="off"
                           required>
                    <button type="submit" 
                            class="btn rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 36px; height: 36px; background: #0084ff; border: none; color: white;">
                        <i class="bi bi-send-fill"></i>
                    </button>
                </form>
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
#messagesContainer {
    scroll-behavior: smooth;
}
</style>

<script>
// Search friends
const searchInput = document.getElementById('searchFriends');
if (searchInput) {
    searchInput.addEventListener('input', function(e) {
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
}
</script>

<script>
    const messagesContainer = document.getElementById('messagesContainer');
    const messageForm = document.getElementById('messageForm');
    const messageInput = document.getElementById('messageInput');
    const friendUid = '{{ $friend->uid }}';
    const currentUserId = '{{ auth()->user()->uid }}';
    let lastMessageId = {{ $messages->isNotEmpty() ? $messages->last()->id : 0 }};

    // Friend info for avatar
    const friendAvatar = {
        @if($friend->profile_photo)
        type: 'profile_photo',
        url: '{{ asset('storage/' . $friend->profile_photo) }}'
        @else
        type: 'initial',
        initial: '{{ strtoupper(substr($friend->name, 0, 1)) }}'
        @endif
    };
    const friendName = '{{ $friend->name }}';

    // Scroll to bottom on page load
    scrollToBottom();

    function scrollToBottom() {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    // Send message
    messageForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const message = messageInput.value.trim();
        if (!message) return;

        try {
            const response = await fetch('{{ route("messages.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify({
                    receiver_id: friendUid,
                    message: message
                })
            });

            const data = await response.json();

            if (data.success) {
                // Add message to UI
                appendMessage(data.message, true);
                messageInput.value = '';
                scrollToBottom();
                lastMessageId = data.message.id;
            } else {
                alert(data.message || 'Failed to send message');
            }
        } catch (error) {
            console.error('Error sending message:', error);
            alert('Failed to send message');
        }
    });

    // Append message to UI
    function appendMessage(message, isOwnMessage) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `mb-3 d-flex ${isOwnMessage ? 'justify-content-end' : 'justify-content-start'}`;
        
        const time = new Date(message.created_at);
        const timeString = time.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' });
        
        let avatarHtml = '';
        if (!isOwnMessage) {
            if (friendAvatar.type === 'profile_photo' || friendAvatar.type === 'avatar') {
                avatarHtml = `<img src="${friendAvatar.url}" alt="${friendName}" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; flex-shrink: 0;">`;
            } else {
                avatarHtml = `<div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 14px; flex-shrink: 0;">${friendAvatar.initial}</div>`;
            }
        }
        
        const bgColor = isOwnMessage ? '#0084ff' : '#e4e6eb';
        const textColor = isOwnMessage ? 'white' : '#050505';
        const alignText = isOwnMessage ? 'text-end' : '';
        
        messageDiv.innerHTML = `
            <div class="d-flex gap-2" style="max-width: 70%; ${isOwnMessage ? 'flex-direction: row-reverse;' : ''}">
                ${avatarHtml}
                <div>
                    <div class="rounded-pill px-3 py-2" style="background: ${bgColor}; color: ${textColor};">
                        <p class="mb-0" style="font-size: 15px;">${escapeHtml(message.message)}</p>
                    </div>
                    <small class="text-muted d-block ${alignText}" style="font-size: 11px; margin-top: 4px; padding: 0 12px;">
                        ${timeString}
                    </small>
                </div>
            </div>
        `;
        
        messagesContainer.appendChild(messageDiv);
    }

    // Escape HTML to prevent XSS
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Poll for new messages every 3 seconds
    setInterval(async () => {
        try {
            const response = await fetch(`{{ route('messages.getMessages', ['user' => $friend->uid]) }}?last_id=${lastMessageId}`);
            const data = await response.json();

            if (data.messages && data.messages.length > 0) {
                data.messages.forEach(message => {
                    appendMessage(message, message.sender_id === currentUserId);
                    lastMessageId = message.id;
                });
                scrollToBottom();
            }
        } catch (error) {
            console.error('Error fetching messages:', error);
        }
    }, 3000);

    // Mark messages as read
    if (lastMessageId > 0) {
        fetch(`{{ route('messages.show', $friend->uid) }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        });
    }
</script>
@endsection
