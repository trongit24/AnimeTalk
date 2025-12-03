@extends('layouts.app')

@section('title', 'Bạn bè - AnimeTalk')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12 col-lg-10 mx-auto">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <h2 class="mb-4 fw-bold text-gradient">
                        <i class="bi bi-people-fill me-2"></i>Bạn bè
                    </h2>

                    <!-- Search Box -->
                    <div class="mb-4 position-relative">
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-search"></i>
                            </span>
                            <input 
                                type="text" 
                                class="form-control border-start-0 ps-0" 
                                id="friendSearchInput" 
                                placeholder="Tìm kiếm người dùng..."
                                autocomplete="off"
                            >
                        </div>
                        
                        <!-- Search Results Dropdown -->
                        <div id="searchResultsBox" class="search-results-dropdown">
                            <div id="searchLoadingState" class="text-center py-3 d-none">
                                <div class="spinner-border spinner-border-sm text-primary" role="status">
                                    <span class="visually-hidden">Đang tìm...</span>
                                </div>
                            </div>
                            <div id="searchResultsList"></div>
                            <div id="searchEmptyState" class="text-center py-3 text-muted d-none">
                                Không tìm thấy kết quả
                            </div>
                        </div>
                    </div>

                    <!-- Pending Friend Requests -->
                    @if(count($pendingRequests) > 0)
                    <div class="mb-4">
                        <h5 class="mb-3 fw-semibold">
                            <i class="bi bi-envelope-heart me-2"></i>Lời mời kết bạn 
                            <span class="badge bg-primary rounded-pill">{{ count($pendingRequests) }}</span>
                        </h5>
                        
                        <div class="row g-3">
                            @foreach($pendingRequests as $request)
                            <div class="col-12 col-md-6" id="pending-{{ $request->id }}">
                                <div class="card border pending-request-card">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-center">
                                            <img 
                                                src="{{ $request->user->profile_photo ? asset('storage/' . $request->user->profile_photo) : asset('images/default-avatar.png') }}" 
                                                class="rounded-circle me-3" 
                                                style="width: 50px; height: 50px; object-fit: cover;"
                                                alt="{{ $request->user->name }}"
                                            >
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">{{ $request->user->name }}</h6>
                                                <small class="text-muted">{{ $request->user->email }}</small>
                                            </div>
                                            <div class="btn-group">
                                                <button 
                                                    class="btn btn-sm btn-success accept-request" 
                                                    data-id="{{ $request->id }}"
                                                >
                                                    <i class="bi bi-check-lg"></i>
                                                </button>
                                                <button 
                                                    class="btn btn-sm btn-danger reject-request" 
                                                    data-id="{{ $request->id }}"
                                                >
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Friends List -->
                    <div>
                        <h5 class="mb-3 fw-semibold">
                            <i class="bi bi-people me-2"></i>Danh sách bạn bè 
                            <span class="badge bg-secondary rounded-pill">{{ count($friends) }}</span>
                        </h5>

                        @if(count($friends) > 0)
                        <div class="row g-3">
                            @foreach($friends as $friend)
                            <div class="col-12 col-sm-6 col-lg-4 col-xl-3" id="friend-{{ $friend->uid }}">
                                <div class="card border friend-card h-100">
                                    <div class="card-body p-3 text-center">
                                        <img 
                                            src="{{ $friend->profile_photo ? asset('storage/' . $friend->profile_photo) : asset('images/default-avatar.png') }}" 
                                            class="rounded-circle mb-2" 
                                            style="width: 80px; height: 80px; object-fit: cover;"
                                            alt="{{ $friend->name }}"
                                        >
                                        <h6 class="mb-1">{{ $friend->name }}</h6>
                                        <small class="text-muted d-block mb-3">{{ $friend->email }}</small>
                                        
                                        <div class="d-grid gap-2">
                                            <a href="{{ route('profile.show', $friend->uid) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-person me-1"></i>Xem trang
                                            </a>
                                            <a href="{{ route('messages.show', $friend->uid) }}" class="btn btn-sm btn-outline-info">
                                                <i class="bi bi-chat-dots me-1"></i>Nhắn tin
                                            </a>
                                            <button 
                                                class="btn btn-sm btn-outline-danger unfriend-btn" 
                                                data-id="{{ $friend->uid }}"
                                                data-name="{{ $friend->name }}"
                                            >
                                                <i class="bi bi-person-x me-1"></i>Hủy kết bạn
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-5">
                            <i class="bi bi-people display-1 text-muted"></i>
                            <p class="text-muted mt-3">Bạn chưa có bạn bè nào. Hãy tìm kiếm và kết bạn!</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.text-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.search-results-dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: white;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    margin-top: 8px;
    max-height: 400px;
    overflow-y: auto;
    z-index: 1000;
    display: none;
}

.search-results-dropdown.show {
    display: block;
}

.search-result-item {
    padding: 12px 16px;
    border-bottom: 1px solid #f0f0f0;
    cursor: pointer;
    transition: background-color 0.2s;
}

.search-result-item:last-child {
    border-bottom: none;
}

.search-result-item:hover {
    background-color: #f8f9fa;
}

.search-result-item img {
    width: 40px;
    height: 40px;
    object-fit: cover;
}

.pending-request-card {
    transition: transform 0.2s, box-shadow 0.2s;
}

.pending-request-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.friend-card {
    transition: transform 0.2s, box-shadow 0.2s;
}

.friend-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.1);
}

.btn-group .btn {
    border-radius: 6px;
}

.btn-group .btn:first-child {
    margin-right: 4px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('friendSearchInput');
    const resultsBox = document.getElementById('searchResultsBox');
    const resultsList = document.getElementById('searchResultsList');
    const loadingState = document.getElementById('searchLoadingState');
    const emptyState = document.getElementById('searchEmptyState');
    
    let searchTimeout = null;

    // Search functionality
    searchInput.addEventListener('input', function() {
        const query = this.value.trim();
        
        clearTimeout(searchTimeout);
        
        if (query.length < 2) {
            resultsBox.classList.remove('show');
            return;
        }

        loadingState.classList.remove('d-none');
        emptyState.classList.add('d-none');
        resultsList.innerHTML = '';
        resultsBox.classList.add('show');

        searchTimeout = setTimeout(() => {
            fetch(`/friends/search?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(users => {
                    loadingState.classList.add('d-none');
                    
                    if (users.length === 0) {
                        emptyState.classList.remove('d-none');
                        return;
                    }

                    resultsList.innerHTML = users.map(user => `
                        <div class="search-result-item d-flex align-items-center">
                            <img 
                                src="${user.profile_photo ? '/storage/' + user.profile_photo : '/images/default-avatar.png'}" 
                                class="rounded-circle me-3"
                                alt="${user.name}"
                            >
                            <div class="flex-grow-1">
                                <div class="fw-semibold">${user.name}</div>
                                <small class="text-muted">${user.email}</small>
                            </div>
                            <button 
                                class="btn btn-sm btn-primary send-request-btn" 
                                data-id="${user.uid}"
                                data-name="${user.name}"
                            >
                                <i class="bi bi-person-plus me-1"></i>Kết bạn
                            </button>
                        </div>
                    `).join('');

                    attachSendRequestHandlers();
                })
                .catch(error => {
                    console.error('Search error:', error);
                    loadingState.classList.add('d-none');
                    emptyState.classList.remove('d-none');
                });
        }, 500);
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !resultsBox.contains(e.target)) {
            resultsBox.classList.remove('show');
        }
    });

    // Send friend request
    function attachSendRequestHandlers() {
        document.querySelectorAll('.send-request-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const friendId = this.getAttribute('data-id');
                const friendName = this.getAttribute('data-name');
                const button = this;

                button.disabled = true;
                button.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Đang gửi...';

                fetch('/friends/request', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ friend_id: friendId })
                })
                .then(response => response.json())
                .then(data => {
                    button.innerHTML = '<i class="bi bi-check-lg me-1"></i>Đã gửi';
                    button.classList.remove('btn-primary');
                    button.classList.add('btn-success');
                    
                    setTimeout(() => {
                        button.disabled = true;
                    }, 100);
                })
                .catch(error => {
                    console.error('Error:', error);
                    button.disabled = false;
                    button.innerHTML = '<i class="bi bi-person-plus me-1"></i>Kết bạn';
                    alert('Có lỗi xảy ra. Vui lòng thử lại!');
                });
            });
        });
    }

    // Accept friend request
    document.querySelectorAll('.accept-request').forEach(btn => {
        btn.addEventListener('click', function() {
            const requestId = this.getAttribute('data-id');
            const button = this;
            
            button.disabled = true;

            fetch(`/friends/accept/${requestId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById(`pending-${requestId}`).remove();
                location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
                button.disabled = false;
                alert('Có lỗi xảy ra!');
            });
        });
    });

    // Reject friend request
    document.querySelectorAll('.reject-request').forEach(btn => {
        btn.addEventListener('click', function() {
            const requestId = this.getAttribute('data-id');
            const button = this;
            
            button.disabled = true;

            fetch(`/friends/reject/${requestId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById(`pending-${requestId}`).remove();
            })
            .catch(error => {
                console.error('Error:', error);
                button.disabled = false;
                alert('Có lỗi xảy ra!');
            });
        });
    });

    // Unfriend
    document.querySelectorAll('.unfriend-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const friendId = this.getAttribute('data-id');
            const friendName = this.getAttribute('data-name');
            
            if (!confirm(`Bạn có chắc muốn hủy kết bạn với ${friendName}?`)) {
                return;
            }

            const button = this;
            button.disabled = true;

            fetch(`/friends/unfriend/${friendId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById(`friend-${friendId}`).remove();
            })
            .catch(error => {
                console.error('Error:', error);
                button.disabled = false;
                alert('Có lỗi xảy ra!');
            });
        });
    });
});
</script>
@endsection
