@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 900px;">
    <div class="bg-white rounded shadow-sm d-flex flex-column" style="height: calc(100vh - 12rem);">
        <!-- Chat Header -->
        <div class="p-3 border-bottom d-flex align-items-center gap-3">
            <a href="{{ route('messages.index') }}" class="text-secondary text-decoration-none">
                <i class="bi bi-arrow-left fs-4"></i>
            </a>
            
            @if($friend->profile_photo)
                <img src="{{ asset('storage/' . $friend->profile_photo) }}" 
                     alt="{{ $friend->name }}" 
                     style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
            @elseif($friend->avatar)
                <img src="{{ $friend->avatar }}" 
                     alt="{{ $friend->name }}" 
                     style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
            @else
                <div style="width: 40px; height: 40px; border-radius: 50%; background: #9333ea; color: white; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                    {{ strtoupper(substr($friend->name, 0, 1)) }}
                </div>
            @endif
            
            <div>
                <h5 class="mb-0 fw-semibold">{{ $friend->name }}</h5>
                <small class="text-muted">Active now</small>
            </div>
        </div>

        <!-- Messages Container -->
        <div id="messagesContainer" class="flex-fill overflow-auto p-3" style="background: #f8f9fa;">
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
                            @elseif($friend->avatar)
                                <img src="{{ $friend->avatar }}" 
                                     alt="{{ $friend->name }}" 
                                     style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; flex-shrink: 0;">
                            @else
                                <div style="width: 32px; height: 32px; border-radius: 50%; background: #6c757d; color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 14px; flex-shrink: 0;">
                                    {{ strtoupper(substr($friend->name, 0, 1)) }}
                                </div>
                            @endif
                        @endif

                        <div>
                            <div class="rounded px-3 py-2" style="background: {{ $isOwnMessage ? '#9333ea' : '#e9ecef' }}; color: {{ $isOwnMessage ? 'white' : '#212529' }};">
                                <p class="mb-0" style="font-size: 14px;">{{ $message->message }}</p>
                            </div>
                            <small class="text-muted d-block {{ $isOwnMessage ? 'text-end' : '' }}" style="font-size: 11px; margin-top: 2px;">
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
        <div class="p-3 border-top bg-white">
            <form id="messageForm" class="d-flex gap-2">
                @csrf
                <input type="text" 
                       id="messageInput"
                       name="message" 
                       placeholder="Type a message..." 
                       class="form-control rounded-pill"
                       autocomplete="off"
                       required>
                <button type="submit" 
                        class="btn btn-primary rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 40px; height: 40px; background: #9333ea; border: none;">
                    <i class="bi bi-send-fill"></i>
                </button>
            </form>
        </div>
    </div>
</div>

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
        @elseif($friend->avatar)
        type: 'avatar',
        url: '{{ $friend->avatar }}'
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
                avatarHtml = `<div style="width: 32px; height: 32px; border-radius: 50%; background: #6c757d; color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 14px; flex-shrink: 0;">${friendAvatar.initial}</div>`;
            }
        }
        
        const bgColor = isOwnMessage ? '#9333ea' : '#e9ecef';
        const textColor = isOwnMessage ? 'white' : '#212529';
        const alignText = isOwnMessage ? 'text-end' : '';
        
        messageDiv.innerHTML = `
            <div class="d-flex gap-2" style="max-width: 70%; ${isOwnMessage ? 'flex-direction: row-reverse;' : ''}">
                ${avatarHtml}
                <div>
                    <div class="rounded px-3 py-2" style="background: ${bgColor}; color: ${textColor};">
                        <p class="mb-0" style="font-size: 14px;">${escapeHtml(message.message)}</p>
                    </div>
                    <small class="text-muted d-block ${alignText}" style="font-size: 11px; margin-top: 2px;">
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
