@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 900px; padding: 2rem 1rem;">
    <div class="bg-white rounded shadow-sm">
        <div class="p-4 border-bottom">
            <h2 class="mb-0 fw-bold">Messages</h2>
        </div>

        <div>
            @forelse($conversations as $conversation)
                @php
                    $otherUser = $conversation['user'];
                    $lastMessage = $conversation['last_message'];
                    $unreadCount = $conversation['unread_count'];
                @endphp
                <a href="{{ route('messages.show', $otherUser->uid) }}" 
                   class="d-block p-3 border-bottom text-decoration-none text-dark" 
                   style="transition: background 0.2s;"
                   onmouseover="this.style.background='#f8f9fa'" 
                   onmouseout="this.style.background='white'">
                    <div class="d-flex align-items-start gap-3">
                        <!-- Avatar -->
                        <div style="flex-shrink: 0;">
                            @if($otherUser->profile_photo)
                                <img src="{{ asset('storage/' . $otherUser->profile_photo) }}" 
                                     alt="{{ $otherUser->name }}" 
                                     style="width: 48px; height: 48px; border-radius: 50%; object-fit: cover;">
                            @elseif($otherUser->avatar)
                                <img src="{{ $otherUser->avatar }}" 
                                     alt="{{ $otherUser->name }}" 
                                     style="width: 48px; height: 48px; border-radius: 50%; object-fit: cover;">
                            @else
                                <div style="width: 48px; height: 48px; border-radius: 50%; background: #9333ea; color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 18px;">
                                    {{ strtoupper(substr($otherUser->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>

                        <!-- Message Info -->
                        <div class="flex-fill" style="min-width: 0;">
                            <div class="d-flex align-items-baseline justify-content-between gap-2">
                                <h6 class="mb-0 text-truncate {{ $unreadCount > 0 ? 'fw-bold' : 'fw-semibold' }}">
                                    {{ $otherUser->name }}
                                </h6>
                                @if($lastMessage)
                                    <small class="text-muted" style="flex-shrink: 0; font-size: 11px;">
                                        {{ $lastMessage->created_at->diffForHumans() }}
                                    </small>
                                @endif
                            </div>
                            
                            @if($lastMessage)
                                <p class="mb-0 text-truncate mt-1 {{ $unreadCount > 0 ? 'fw-semibold' : '' }}" style="font-size: 14px; color: #6c757d;">
                                    @if($lastMessage->sender_id === auth()->user()->uid)
                                        <span class="text-muted">You: </span>
                                    @endif
                                    {{ $lastMessage->message }}
                                </p>
                            @else
                                <p class="mb-0 text-muted mt-1" style="font-size: 14px;">No messages yet</p>
                            @endif
                        </div>

                        <!-- Unread Badge -->
                        @if($unreadCount > 0)
                            <div style="flex-shrink: 0;">
                                <span class="badge rounded-pill" style="background: #9333ea; width: 24px; height: 24px; display: inline-flex; align-items: center; justify-content: center; font-size: 11px;">
                                    {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                                </span>
                            </div>
                        @endif
                    </div>
                </a>
            @empty
                <div class="p-5 text-center">
                    <i class="bi bi-chat-dots text-muted" style="font-size: 64px;"></i>
                    <h5 class="mt-3">No messages</h5>
                    <p class="text-muted">Start chatting with your friends!</p>
                    <div class="mt-4">
                        <a href="{{ route('friends.index') }}" class="btn btn-primary" style="background: #9333ea; border: none;">
                            <i class="bi bi-people"></i> View Friends
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
</div>
@endsection
