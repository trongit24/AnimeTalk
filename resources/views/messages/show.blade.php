@extends('layouts.app')

@section('content')
<style>
    @media (max-width: 768px) {
        .messenger-sidebar {
            position: fixed;
            left: 0;
            top: 56px;
            width: 100%;
            height: calc(100vh - 56px);
            z-index: 1040;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }
        .messenger-sidebar.show {
            transform: translateX(0);
        }
        .messenger-chat {
            width: 100% !important;
        }
        .back-btn-mobile {
            display: inline-flex !important;
        }
    }
    @media (min-width: 769px) {
        .back-btn-mobile {
            display: none !important;
        }
    }
</style>

<div class="container-fluid" style="padding: 0; height: calc(100vh - 80px);">
    <div class="row g-0 h-100">
        <!-- Sidebar - Danh sách bạn bè -->
        <div class="col-md-4 col-lg-3 border-end messenger-sidebar" style="background: white; overflow-y: auto;">
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
                                        @if($lastMsg->message_type === 'image')
                                            <i class="bi bi-image"></i> Đã gửi một ảnh
                                        @elseif($lastMsg->message_type === 'gif')
                                            <i class="bi bi-file-play"></i> Đã gửi một GIF
                                        @else
                                            {{ $lastMsg->message }}
                                        @endif
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
        <div class="col-md-8 col-lg-9 d-flex flex-column messenger-chat" style="background: white;">
            <!-- Chat Header -->
            <div class="p-3 border-bottom d-flex align-items-center gap-3" style="box-shadow: 0 1px 2px rgba(0,0,0,0.1);">
                <!-- Back button for mobile -->
                <button onclick="toggleSidebar()" class="btn btn-link p-0 back-btn-mobile" style="display: none;">
                    <i class="bi bi-arrow-left" style="font-size: 24px; color: #050505;"></i>
                </button>
                
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
                            @if($message->message_type === 'image')
                                <div style="max-width: 300px;">
                                    <img src="{{ asset('storage/' . $message->image) }}" 
                                         alt="Image" 
                                         style="max-width: 100%; border-radius: 18px; cursor: pointer;"
                                         onclick="window.open(this.src, '_blank')">
                                    @if($message->message)
                                        <p class="mb-0 mt-2" style="font-size: 15px;">{{ $message->message }}</p>
                                    @endif
                                </div>
                            @elseif($message->message_type === 'gif')
                                <div style="max-width: 300px;">
                                    <img src="{{ $message->message }}" 
                                         alt="GIF" 
                                         style="max-width: 100%; border-radius: 18px; cursor: pointer;"
                                         onclick="window.open(this.src, '_blank')">
                                </div>
                            @else
                                <div class="rounded-pill px-3 py-2" style="background: {{ $isOwnMessage ? '#0084ff' : '#e4e6eb' }}; color: {{ $isOwnMessage ? 'white' : '#050505' }};">
                                    <p class="mb-0" style="font-size: 15px;">{{ $message->message }}</p>
                                </div>
                            @endif
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
                <!-- Preview ảnh sẽ upload -->
                <div id="imagePreview" class="mb-2" style="display: none;">
                    <div class="position-relative d-inline-block">
                        <img id="previewImage" src="" style="max-width: 200px; max-height: 200px; border-radius: 12px;">
                        <button type="button" onclick="removeImage()" class="btn btn-sm btn-danger rounded-circle position-absolute" style="top: 5px; right: 5px; width: 24px; height: 24px; padding: 0;">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                </div>

                <form id="messageForm" class="d-flex align-items-center gap-2">
                    @csrf
                    <input type="file" id="imageInput" name="image" accept="image/*,image/gif" style="display: none;" onchange="previewMessageImage(this)">
                    
                    <!-- Nút upload ảnh -->
                    <button type="button" onclick="document.getElementById('imageInput').click()" class="btn p-0" style="background: none; border: none; color: #0084ff; font-size: 24px;">
                        <i class="bi bi-image"></i>
                    </button>

                    <!-- GIF picker button -->
                    <div class="position-relative">
                        <button type="button" onclick="toggleGifPicker()" class="btn p-0" style="background: none; border: none; color: #0084ff; font-size: 24px;">
                            <i class="bi bi-file-play"></i>
                        </button>
                        <div id="gifPicker" class="position-absolute bg-white shadow rounded p-2" style="display: none; bottom: 45px; left: 0; width: 350px; height: 400px; z-index: 1000; border: 1px solid #ddd;">
                            <input type="text" id="gifSearch" class="form-control form-control-sm mb-2" placeholder="Tìm GIF..." style="font-size: 13px;">
                            <div id="gifGrid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; max-height: 340px; overflow-y: auto;">
                                <img src="https://media.giphy.com/media/ICOgUNjpvO0PC/giphy.gif" class="gif-item" style="width: 100%; border-radius: 8px; cursor: pointer;" alt="GIF">
                                <img src="https://media.giphy.com/media/MDJ9IbxxvDUQM/giphy.gif" class="gif-item" style="width: 100%; border-radius: 8px; cursor: pointer;" alt="GIF">
                                <img src="https://media.giphy.com/media/11sBLVxNs7v6WA/giphy.gif" class="gif-item" style="width: 100%; border-radius: 8px; cursor: pointer;" alt="GIF">
                                <img src="https://media.giphy.com/media/ZBQhoZC0nqknSviPqT/giphy.gif" class="gif-item" style="width: 100%; border-radius: 8px; cursor: pointer;" alt="GIF">
                                <img src="https://media.giphy.com/media/vFKqnCdLPNOKc/giphy.gif" class="gif-item" style="width: 100%; border-radius: 8px; cursor: pointer;" alt="GIF">
                                <img src="https://media.giphy.com/media/12NUbkX6p4xOO4/giphy.gif" class="gif-item" style="width: 100%; border-radius: 8px; cursor: pointer;" alt="GIF">
                            </div>
                        </div>
                    </div>

                    <!-- Emoji picker button -->
                    <div class="position-relative">
                        <button type="button" onclick="toggleEmojiPicker()" class="btn p-0" style="background: none; border: none; font-size: 24px;">
                            😊
                        </button>
                        <div id="emojiPicker" class="position-absolute bg-white shadow rounded p-2" style="display: none; bottom: 45px; left: 0; width: 280px; max-height: 200px; overflow-y: auto; z-index: 1000; border: 1px solid #ddd;">
                            <div class="d-flex flex-wrap gap-1">
                                <button type="button" onclick="insertEmoji('😀')" class="btn btn-sm" style="font-size: 24px; padding: 4px;">😀</button>
                                <button type="button" onclick="insertEmoji('😂')" class="btn btn-sm" style="font-size: 24px; padding: 4px;">😂</button>
                                <button type="button" onclick="insertEmoji('😍')" class="btn btn-sm" style="font-size: 24px; padding: 4px;">😍</button>
                                <button type="button" onclick="insertEmoji('😭')" class="btn btn-sm" style="font-size: 24px; padding: 4px;">😭</button>
                                <button type="button" onclick="insertEmoji('😊')" class="btn btn-sm" style="font-size: 24px; padding: 4px;">😊</button>
                                <button type="button" onclick="insertEmoji('😎')" class="btn btn-sm" style="font-size: 24px; padding: 4px;">😎</button>
                                <button type="button" onclick="insertEmoji('🥰')" class="btn btn-sm" style="font-size: 24px; padding: 4px;">🥰</button>
                                <button type="button" onclick="insertEmoji('🤔')" class="btn btn-sm" style="font-size: 24px; padding: 4px;">🤔</button>
                                <button type="button" onclick="insertEmoji('😅')" class="btn btn-sm" style="font-size: 24px; padding: 4px;">😅</button>
                                <button type="button" onclick="insertEmoji('😡')" class="btn btn-sm" style="font-size: 24px; padding: 4px;">😡</button>
                                <button type="button" onclick="insertEmoji('👍')" class="btn btn-sm" style="font-size: 24px; padding: 4px;">👍</button>
                                <button type="button" onclick="insertEmoji('👎')" class="btn btn-sm" style="font-size: 24px; padding: 4px;">👎</button>
                                <button type="button" onclick="insertEmoji('❤️')" class="btn btn-sm" style="font-size: 24px; padding: 4px;">❤️</button>
                                <button type="button" onclick="insertEmoji('🔥')" class="btn btn-sm" style="font-size: 24px; padding: 4px;">🔥</button>
                                <button type="button" onclick="insertEmoji('✨')" class="btn btn-sm" style="font-size: 24px; padding: 4px;">✨</button>
                                <button type="button" onclick="insertEmoji('💯')" class="btn btn-sm" style="font-size: 24px; padding: 4px;">💯</button>
                            </div>
                        </div>
                    </div>

                    <input type="text" 
                           id="messageInput"
                           name="message" 
                           placeholder="Aa" 
                           class="form-control rounded-pill flex-fill"
                           style="background: white; border: none;"
                           autocomplete="off">
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
    const displayedMessageIds = new Set([
        @foreach($messages as $message)
            {{ $message->id }},
        @endforeach
    ]);

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
    let selectedGifUrl = null;

    messageForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const message = messageInput.value.trim();
        const imageInput = document.getElementById('imageInput');
        const hasImage = imageInput.files.length > 0;
        const hasGif = selectedGifUrl !== null;
        
        if (!message && !hasImage && !hasGif) return;

        try {
            const formData = new FormData();
            formData.append('receiver_id', friendUid);
            
            // Nếu có GIF URL, gửi làm message
            if (hasGif) {
                formData.append('message', selectedGifUrl);
                formData.append('message_type', 'gif');
            } else {
                if (message) formData.append('message', message);
                if (hasImage) formData.append('image', imageInput.files[0]);
            }

            const response = await fetch('{{ route("messages.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                // Add message to UI
                appendMessage(data.message, true);
                messageInput.value = '';
                imageInput.value = '';
                selectedGifUrl = null;
                removeImage();
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
        // Check if message already exists
        if (displayedMessageIds.has(message.id)) {
            return;
        }
        displayedMessageIds.add(message.id);
        
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
        
        let messageContent = '';
        if (message.message_type === 'image') {
            messageContent = `
                <div style="max-width: 300px;">
                    <img src="/storage/${message.image}" alt="Image" style="max-width: 100%; border-radius: 18px; cursor: pointer;" onclick="window.open(this.src, '_blank')">
                    ${message.message ? `<p class="mb-0 mt-2" style="font-size: 15px;">${escapeHtml(message.message)}</p>` : ''}
                </div>
            `;
        } else if (message.message_type === 'gif') {
            messageContent = `
                <div style="max-width: 300px;">
                    <img src="${message.message}" alt="GIF" style="max-width: 100%; border-radius: 18px; cursor: pointer;" onclick="window.open(this.src, '_blank')">
                </div>
            `;
        } else {
            messageContent = `
                <div class="rounded-pill px-3 py-2" style="background: ${bgColor}; color: ${textColor};">
                    <p class="mb-0" style="font-size: 15px;">${escapeHtml(message.message)}</p>
                </div>
            `;
        }
        
        messageDiv.innerHTML = `
            <div class="d-flex gap-2" style="max-width: 70%; ${isOwnMessage ? 'flex-direction: row-reverse;' : ''}">
                ${avatarHtml}
                <div>
                    ${messageContent}
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

    // Preview ảnh trước khi gửi
    function previewMessageImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImage').src = e.target.result;
                document.getElementById('imagePreview').style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Xóa ảnh preview
    function removeImage() {
        document.getElementById('imageInput').value = '';
        document.getElementById('imagePreview').style.display = 'none';
        document.getElementById('previewImage').src = '';
        selectedGifUrl = null;
    }

    // Toggle emoji picker
    function toggleEmojiPicker() {
        const picker = document.getElementById('emojiPicker');
        const gifPicker = document.getElementById('gifPicker');
        picker.style.display = picker.style.display === 'none' ? 'block' : 'none';
        if (gifPicker) gifPicker.style.display = 'none';
    }

    // Toggle GIF picker
    function toggleGifPicker() {
        const picker = document.getElementById('gifPicker');
        const emojiPicker = document.getElementById('emojiPicker');
        picker.style.display = picker.style.display === 'none' ? 'block' : 'none';
        if (emojiPicker) emojiPicker.style.display = 'none';
    }

    // Handle GIF selection
    document.querySelectorAll('.gif-item').forEach(gif => {
        gif.addEventListener('click', function() {
            const imagePreview = document.getElementById('imagePreview');
            const previewImg = document.getElementById('previewImage');
            const imageInput = document.getElementById('imageInput');
            
            // Clear file input
            imageInput.value = '';
            
            // Set selected GIF URL
            selectedGifUrl = this.src;
            
            // Show GIF preview
            previewImg.src = this.src;
            imagePreview.style.display = 'block';
            
            // Close GIF picker
            document.getElementById('gifPicker').style.display = 'none';
        });
    });

    // Insert emoji vào input
    function insertEmoji(emoji) {
        const input = document.getElementById('messageInput');
        input.value += emoji;
        input.focus();
        toggleEmojiPicker();
    }

    // Đóng emoji picker khi click ngoài
    document.addEventListener('click', function(e) {
        const emojiPicker = document.getElementById('emojiPicker');
        const gifPicker = document.getElementById('gifPicker');
        const emojiButton = e.target.closest('button[onclick="toggleEmojiPicker()"]');
        const gifButton = e.target.closest('button[onclick="toggleGifPicker()"]');
        const emojiItem = e.target.closest('button[onclick^="insertEmoji"]');
        const gifItem = e.target.closest('.gif-item');
        const gifSearch = e.target.closest('#gifSearch');
        
        if (!emojiButton && !emojiItem && emojiPicker.style.display === 'block') {
            emojiPicker.style.display = 'none';
        }
        
        if (!gifButton && !gifItem && !gifSearch && gifPicker.style.display === 'block') {
            gifPicker.style.display = 'none';
        }
    });

    // Toggle sidebar on mobile
    function toggleSidebar() {
        const sidebar = document.querySelector('.messenger-sidebar');
        sidebar.classList.toggle('show');
    }

    // Close sidebar when clicking friend on mobile
    document.querySelectorAll('.friend-item').forEach(item => {
        item.addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                setTimeout(() => {
                    document.querySelector('.messenger-sidebar').classList.remove('show');
                }, 100);
            }
        });
    });
</script>
@endsection
