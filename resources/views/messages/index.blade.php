@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b border-gray-200">
            <h1 class="text-2xl font-bold text-gray-900">Messages</h1>
        </div>

        <div class="divide-y divide-gray-200">
            @forelse($conversations as $conversation)
                @php
                    $otherUser = $conversation['user'];
                    $lastMessage = $conversation['last_message'];
                    $unreadCount = $conversation['unread_count'];
                @endphp
                <a href="{{ route('messages.show', $otherUser->uid) }}" 
                   class="block p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-start gap-4">
                        <!-- Avatar -->
                        <div class="flex-shrink-0">
                            @if($otherUser->profile_photo)
                                <img src="{{ asset('storage/' . $otherUser->profile_photo) }}" 
                                     alt="{{ $otherUser->name }}" 
                                     class="w-12 h-12 rounded-full object-cover">
                            @elseif($otherUser->avatar)
                                <img src="{{ $otherUser->avatar }}" 
                                     alt="{{ $otherUser->name }}" 
                                     class="w-12 h-12 rounded-full object-cover">
                            @else
                                <div class="w-12 h-12 rounded-full bg-purple-500 flex items-center justify-center text-white font-bold text-lg">
                                    {{ strtoupper(substr($otherUser->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>

                        <!-- Message Info -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-baseline justify-between gap-2">
                                <h3 class="font-semibold text-gray-900 truncate {{ $unreadCount > 0 ? 'font-bold' : '' }}">
                                    {{ $otherUser->name }}
                                </h3>
                                @if($lastMessage)
                                    <span class="text-xs text-gray-500 flex-shrink-0">
                                        {{ $lastMessage->created_at->diffForHumans() }}
                                    </span>
                                @endif
                            </div>
                            
                            @if($lastMessage)
                                <p class="text-sm text-gray-600 truncate mt-1 {{ $unreadCount > 0 ? 'font-semibold' : '' }}">
                                    @if($lastMessage->sender_id === auth()->user()->uid)
                                        <span class="text-gray-500">You: </span>
                                    @endif
                                    {{ $lastMessage->message }}
                                </p>
                            @else
                                <p class="text-sm text-gray-400 mt-1">No messages yet</p>
                            @endif
                        </div>

                        <!-- Unread Badge -->
                        @if($unreadCount > 0)
                            <div class="flex-shrink-0">
                                <span class="inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-purple-600 rounded-full">
                                    {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                                </span>
                            </div>
                        @endif
                    </div>
                </a>
            @empty
                <div class="p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No messages</h3>
                    <p class="mt-1 text-sm text-gray-500">Start chatting with your friends!</p>
                    <div class="mt-6">
                        <a href="{{ route('friends.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700">
                            View Friends
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
