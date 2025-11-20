@extends('layouts.app')

@section('title', 'Friends - AnimeTalk')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/friends-responsive.css') }}">
<style>
.friends-container,
.friends-container *,
.friend-item,
.friend-item *,
.search-box,
.search-box *,
.pending-requests,
.pending-requests * {
    opacity: 1 !important;
    visibility: visible !important;
}
.friend-item,
.search-box,
.pending-requests,
.request-item {
    background: white !important;
}
</style>
@endpush

@section('content')
<div class="friends-container" style="opacity: 1 !important; visibility: visible !important;">
    <h1 class="friends-title">Friends</h1>

    <div class="friends-grid">
        <!-- Main Content -->
        <div>
            <!-- Search Box -->
            <div class="search-box">
                <h3>Find Friends</h3>
                <div class="search-input-wrapper">
                    <input type="text" id="searchInput" placeholder="Search by name..." class="search-input">
                    <div id="searchResults" class="search-results"></div>
                </div>
            </div>

            <!-- Friends List -->
            <div class="friends-list">
                <h3>My Friends ({{ $friends->count() }})</h3>
                
                @forelse($friends as $friend)
                <div class="friend-item">
                    @if($friend->profile_photo)
                        <img src="{{ asset('storage/' . $friend->profile_photo) }}" alt="{{ $friend->name }}" class="friend-avatar">
                    @else
                        <div class="friend-avatar-placeholder">
                            {{ strtoupper(substr($friend->name, 0, 1)) }}
                        </div>
                    @endif
                    
                    <div class="friend-info">
                        <div class="friend-name">{{ $friend->name }}</div>
                        <div class="friend-email">{{ $friend->email }}</div>
                    </div>

                    <div class="friend-actions">
                        <a href="{{ route('messages.show', $friend->uid) }}" class="btn-message">
                            <i class="bi bi-chat-dots"></i> Message
                        </a>
                        <form action="{{ route('friends.unfriend', $friend->uid) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Are you sure you want to unfriend?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-unfriend">
                                <i class="bi bi-person-x"></i> Unfriend
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <p class="empty-state">No friends yet. Search and add friends above!</p>
                @endforelse
            </div>
        </div>

        <!-- Sidebar -->
        <div class="friends-sidebar">
            <!-- Pending Requests -->
            <div class="pending-requests">
                <h3>
                    Friend Requests
                    @if($pendingRequests->count() > 0)
                        <span class="badge-count">{{ $pendingRequests->count() }}</span>
                    @endif
                </h3>
                
                @forelse($pendingRequests as $request)
                <div class="request-item">
                    <div class="request-header">
                        @if($request->user->profile_photo)
                            <img src="{{ asset('storage/' . $request->user->profile_photo) }}" alt="{{ $request->user->name }}" class="request-avatar">
                        @else
                            <div class="request-avatar-placeholder">
                                {{ strtoupper(substr($request->user->name, 0, 1)) }}
                            </div>
                        @endif
                        
                        <div class="request-info">
                            <div class="request-name">{{ $request->user->name }}</div>
                            <div class="request-time">{{ $request->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    
                    <div class="request-actions">
                        <button onclick="acceptRequest({{ $request->id }})" class="btn-accept">
                            Accept
                        </button>
                        <button onclick="rejectRequest({{ $request->id }})" class="btn-reject">
                            Reject
                        </button>
                    </div>
                </div>
                @empty
                <p class="empty-state" style="padding: 1rem; font-size: 0.875rem;">No pending requests</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
let searchTimeout;
const searchInput = document.getElementById('searchInput');
const searchResults = document.getElementById('searchResults');

searchInput.addEventListener('input', function() {
    clearTimeout(searchTimeout);
    const query = this.value.trim();
    
    if (query.length < 2) {
        searchResults.style.display = 'none';
        return;
    }
    
    searchTimeout = setTimeout(() => {
        fetch(`/friends/search?q=${encodeURIComponent(query)}`)
            .then(res => res.json())
            .then(users => {
                if (users.length === 0) {
                    searchResults.innerHTML = '<div class="empty-state" style="padding: 1rem;">No users found</div>';
                } else {
                    searchResults.innerHTML = users.map(user => `
                        <div class="search-result-item">
                            ${user.profile_photo ? 
                                `<img src="/storage/${user.profile_photo}" alt="${user.name}" class="friend-avatar">` :
                                `<div class="friend-avatar-placeholder">${user.name.charAt(0).toUpperCase()}</div>`
                            }
                            <div class="friend-info">
                                <div class="friend-name">${user.name}</div>
                                <div class="friend-email">${user.email}</div>
                            </div>
                            <button onclick="sendFriendRequest('${user.uid}', event)" class="btn-add-friend">
                                <i class="bi bi-person-plus"></i> Add
                            </button>
                        </div>
                    `).join('');
                }
                searchResults.style.display = 'block';
            });
    }, 300);
});

// Close search results when clicking outside
document.addEventListener('click', function(e) {
    if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
        searchResults.style.display = 'none';
    }
});

function sendFriendRequest(friendId, event) {
    event.stopPropagation();
    
    fetch('/friends/request', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ friend_id: friendId })
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        searchResults.style.display = 'none';
        searchInput.value = '';
    })
    .catch(err => {
        console.error(err);
        alert('Error sending friend request');
    });
}

function acceptRequest(requestId) {
    fetch(`/friends/accept/${requestId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        location.reload();
    });
}

function rejectRequest(requestId) {
    fetch(`/friends/reject/${requestId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        location.reload();
    });
}
</script>
@endsection
