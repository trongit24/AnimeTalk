@extends('layouts.app')

@section('title', 'Friends - AnimeTalk')

@section('content')
<div class="container" style="max-width: 1200px; margin: 2rem auto; padding: 0 1rem;">
    <h1 style="margin-bottom: 2rem; font-size: 2rem; font-weight: 700;">Friends</h1>

    <div style="display: grid; grid-template-columns: 1fr 350px; gap: 2rem;">
        <!-- Main Content -->
        <div>
            <!-- Search Box -->
            <div style="background: white; border-radius: 12px; padding: 1.5rem; margin-bottom: 1.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                <h3 style="margin-bottom: 1rem; font-size: 1.1rem; font-weight: 600;">Find Friends</h3>
                <div style="position: relative;">
                    <input type="text" id="searchInput" placeholder="Search by name..." 
                           style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #ddd; border-radius: 8px; font-size: 1rem;">
                    <div id="searchResults" style="position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #ddd; border-radius: 8px; margin-top: 0.5rem; max-height: 400px; overflow-y: auto; display: none; z-index: 100; box-shadow: 0 4px 12px rgba(0,0,0,0.1);"></div>
                </div>
            </div>

            <!-- Friends List -->
            <div style="background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                <h3 style="margin-bottom: 1rem; font-size: 1.1rem; font-weight: 600;">My Friends ({{ $friends->count() }})</h3>
                
                @forelse($friends as $friend)
                <div style="display: flex; align-items: center; gap: 1rem; padding: 1rem; border-bottom: 1px solid #f0f0f0;">
                    @if($friend->profile_photo)
                        <img src="{{ asset('storage/' . $friend->profile_photo) }}" alt="{{ $friend->name }}" 
                             style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                    @else
                        <div style="width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.2rem;">
                            {{ strtoupper(substr($friend->name, 0, 1)) }}
                        </div>
                    @endif
                    
                    <div style="flex: 1;">
                        <div style="font-weight: 600; font-size: 1rem;">{{ $friend->name }}</div>
                        <div style="font-size: 0.875rem; color: #666;">{{ $friend->email }}</div>
                    </div>

                    <div style="display: flex; gap: 0.5rem;">
                        <a href="{{ route('messages.show', $friend->uid) }}" 
                           style="padding: 0.5rem 1rem; background: #1a73e8; color: white; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 0.875rem;">
                            <i class="bi bi-chat-dots"></i> Message
                        </a>
                        <form action="{{ route('friends.unfriend', $friend->uid) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Are you sure you want to unfriend?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="padding: 0.5rem 1rem; background: #dc3545; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 0.875rem;">
                                <i class="bi bi-person-x"></i> Unfriend
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <p style="text-align: center; color: #999; padding: 2rem;">No friends yet. Search and add friends above!</p>
                @endforelse
            </div>
        </div>

        <!-- Sidebar -->
        <div>
            <!-- Pending Requests -->
            <div style="background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                <h3 style="margin-bottom: 1rem; font-size: 1.1rem; font-weight: 600;">
                    Friend Requests
                    @if($pendingRequests->count() > 0)
                        <span style="background: #dc3545; color: white; padding: 0.25rem 0.5rem; border-radius: 12px; font-size: 0.75rem; margin-left: 0.5rem;">{{ $pendingRequests->count() }}</span>
                    @endif
                </h3>
                
                @forelse($pendingRequests as $request)
                <div style="padding: 1rem; border-bottom: 1px solid #f0f0f0;">
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem;">
                        @if($request->user->profile_photo)
                            <img src="{{ asset('storage/' . $request->user->profile_photo) }}" alt="{{ $request->user->name }}" 
                                 style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                        @else
                            <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700;">
                                {{ strtoupper(substr($request->user->name, 0, 1)) }}
                            </div>
                        @endif
                        
                        <div>
                            <div style="font-weight: 600; font-size: 0.9rem;">{{ $request->user->name }}</div>
                            <div style="font-size: 0.75rem; color: #999;">{{ $request->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    
                    <div style="display: flex; gap: 0.5rem;">
                        <button onclick="acceptRequest({{ $request->id }})" 
                                style="flex: 1; padding: 0.5rem; background: #28a745; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 0.875rem;">
                            Accept
                        </button>
                        <button onclick="rejectRequest({{ $request->id }})" 
                                style="flex: 1; padding: 0.5rem; background: #6c757d; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 0.875rem;">
                            Reject
                        </button>
                    </div>
                </div>
                @empty
                <p style="text-align: center; color: #999; padding: 1rem; font-size: 0.875rem;">No pending requests</p>
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
                    searchResults.innerHTML = '<div style="padding: 1rem; text-align: center; color: #999;">No users found</div>';
                } else {
                    searchResults.innerHTML = users.map(user => `
                        <div style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; border-bottom: 1px solid #f0f0f0; cursor: pointer;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='white'">
                            ${user.profile_photo ? 
                                `<img src="/storage/${user.profile_photo}" alt="${user.name}" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">` :
                                `<div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700;">${user.name.charAt(0).toUpperCase()}</div>`
                            }
                            <div style="flex: 1;">
                                <div style="font-weight: 600;">${user.name}</div>
                                <div style="font-size: 0.875rem; color: #666;">${user.email}</div>
                            </div>
                            <button onclick="sendFriendRequest('${user.uid}', event)" style="padding: 0.5rem 1rem; background: #1a73e8; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 0.875rem;">
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
