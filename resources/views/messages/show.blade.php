@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-sm flex flex-col" style="height: calc(100vh - 12rem);">
        <!-- Chat Header -->
        <div class="p-4 border-b border-gray-200 flex items-center gap-3">
            <a href="{{ route('messages.index') }}" class="text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            
            @if($friend->profile_photo)
                <img src="{{ asset('storage/' . $friend->profile_photo) }}" 
                     alt="{{ $friend->name }}" 
                     class="w-10 h-10 rounded-full object-cover">
            @elseif($friend->avatar)
                <img src="{{ $friend->avatar }}" 
                     alt="{{ $friend->name }}" 
                     class="w-10 h-10 rounded-full object-cover">
            @else
                <div class="w-10 h-10 rounded-full bg-purple-500 flex items-center justify-center text-white font-bold">
                    {{ strtoupper(substr($friend->name, 0, 1)) }}
                </div>
            @endif
            
            <div>
                <h2 class="font-semibold text-gray-900">{{ $friend->name }}</h2>
                <p class="text-xs text-gray-500">Active now</p>
            </div>
        </div>

        <!-- Messages Container -->
        <div id="messagesContainer" class="flex-1 overflow-y-auto p-4 space-y-4">
            @forelse($messages as $message)
                @php
                    $isOwnMessage = $message->sender_id === auth()->user()->uid;
                @endphp
                <div class="flex {{ $isOwnMessage ? 'justify-end' : 'justify-start' }}">
                    <div class="flex gap-2 max-w-xs lg:max-w-md {{ $isOwnMessage ? 'flex-row-reverse' : '' }}">
                        <!-- Avatar for received messages -->
                        @if(!$isOwnMessage)
                            @if($friend->profile_photo)
                                <img src="{{ asset('storage/' . $friend->profile_photo) }}" 
                                     alt="{{ $friend->name }}" 
                                     class="w-8 h-8 rounded-full object-cover flex-shrink-0">
                            @elseif($friend->avatar)
                                <img src="{{ $friend->avatar }}" 
                                     alt="{{ $friend->name }}" 
                                     class="w-8 h-8 rounded-full object-cover flex-shrink-0">
                            @else
                                <div class="w-8 h-8 rounded-full bg-gray-400 flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                                    {{ strtoupper(substr($friend->name, 0, 1)) }}
                                </div>
                            @endif
                        @endif

                        <div>
                            <div class="rounded-lg px-4 py-2 {{ $isOwnMessage ? 'bg-purple-600 text-white' : 'bg-gray-100 text-gray-900' }}">
                                <p class="text-sm">{{ $message->message }}</p>
                            </div>
                            <p class="text-xs text-gray-500 mt-1 {{ $isOwnMessage ? 'text-right' : '' }}">
                                {{ $message->created_at->format('g:i A') }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="flex items-center justify-center h-full">
                    <div class="text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No messages yet</h3>
                        <p class="mt-1 text-sm text-gray-500">Send a message to start the conversation!</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Message Input -->
        <div class="p-4 border-t border-gray-200">
            <form id="messageForm" class="flex gap-2">
                @csrf
                <input type="text" 
                       id="messageInput"
                       name="message" 
                       placeholder="Type a message..." 
                       class="flex-1 rounded-full border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                       autocomplete="off"
                       required>
                <button type="submit" 
                        class="bg-purple-600 text-white rounded-full p-2 hover:bg-purple-700 transition-colors flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
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
        messageDiv.className = `flex ${isOwnMessage ? 'justify-end' : 'justify-start'}`;
        
        const time = new Date(message.created_at);
        const timeString = time.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' });
        
        let avatarHtml = '';
        if (!isOwnMessage) {
            if (friendAvatar.type === 'profile_photo' || friendAvatar.type === 'avatar') {
                avatarHtml = `<img src="${friendAvatar.url}" alt="${friendName}" class="w-8 h-8 rounded-full object-cover flex-shrink-0">`;
            } else {
                avatarHtml = `<div class="w-8 h-8 rounded-full bg-gray-400 flex items-center justify-center text-white text-sm font-bold flex-shrink-0">${friendAvatar.initial}</div>`;
            }
        }
        
        messageDiv.innerHTML = `
            <div class="flex gap-2 max-w-xs lg:max-w-md ${isOwnMessage ? 'flex-row-reverse' : ''}">
                ${avatarHtml}
                <div>
                    <div class="rounded-lg px-4 py-2 ${isOwnMessage ? 'bg-purple-600 text-white' : 'bg-gray-100 text-gray-900'}">
                        <p class="text-sm">${escapeHtml(message.message)}</p>
                    </div>
                    <p class="text-xs text-gray-500 mt-1 ${isOwnMessage ? 'text-right' : ''}">
                        ${timeString}
                    </p>
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
