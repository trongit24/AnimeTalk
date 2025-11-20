

<?php $__env->startSection('title', 'Friends - AnimeTalk'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/friends-responsive.css')); ?>">
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
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
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
                <h3>My Friends (<?php echo e($friends->count()); ?>)</h3>
                
                <?php $__empty_1 = true; $__currentLoopData = $friends; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $friend): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="friend-item">
                    <?php if($friend->profile_photo): ?>
                        <img src="<?php echo e(asset('storage/' . $friend->profile_photo)); ?>" alt="<?php echo e($friend->name); ?>" class="friend-avatar">
                    <?php else: ?>
                        <div class="friend-avatar-placeholder">
                            <?php echo e(strtoupper(substr($friend->name, 0, 1))); ?>

                        </div>
                    <?php endif; ?>
                    
                    <div class="friend-info">
                        <div class="friend-name"><?php echo e($friend->name); ?></div>
                        <div class="friend-email"><?php echo e($friend->email); ?></div>
                    </div>

                    <div class="friend-actions">
                        <a href="<?php echo e(route('messages.show', $friend->uid)); ?>" class="btn-message">
                            <i class="bi bi-chat-dots"></i> Message
                        </a>
                        <form action="<?php echo e(route('friends.unfriend', $friend->uid)); ?>" method="POST" style="margin: 0;" onsubmit="return confirm('Are you sure you want to unfriend?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn-unfriend">
                                <i class="bi bi-person-x"></i> Unfriend
                            </button>
                        </form>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="empty-state">No friends yet. Search and add friends above!</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="friends-sidebar">
            <!-- Pending Requests -->
            <div class="pending-requests">
                <h3>
                    Friend Requests
                    <?php if($pendingRequests->count() > 0): ?>
                        <span class="badge-count"><?php echo e($pendingRequests->count()); ?></span>
                    <?php endif; ?>
                </h3>
                
                <?php $__empty_1 = true; $__currentLoopData = $pendingRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="request-item">
                    <div class="request-header">
                        <?php if($request->user->profile_photo): ?>
                            <img src="<?php echo e(asset('storage/' . $request->user->profile_photo)); ?>" alt="<?php echo e($request->user->name); ?>" class="request-avatar">
                        <?php else: ?>
                            <div class="request-avatar-placeholder">
                                <?php echo e(strtoupper(substr($request->user->name, 0, 1))); ?>

                            </div>
                        <?php endif; ?>
                        
                        <div class="request-info">
                            <div class="request-name"><?php echo e($request->user->name); ?></div>
                            <div class="request-time"><?php echo e($request->created_at->diffForHumans()); ?></div>
                        </div>
                    </div>
                    
                    <div class="request-actions">
                        <button onclick="acceptRequest(<?php echo e($request->id); ?>)" class="btn-accept">
                            Accept
                        </button>
                        <button onclick="rejectRequest(<?php echo e($request->id); ?>)" class="btn-reject">
                            Reject
                        </button>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="empty-state" style="padding: 1rem; font-size: 0.875rem;">No pending requests</p>
                <?php endif; ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\AnimeTalk\resources\views/friends/index.blade.php ENDPATH**/ ?>