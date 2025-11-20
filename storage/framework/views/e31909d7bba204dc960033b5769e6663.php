

<?php $__env->startSection('content'); ?>
<style>
    /* FORCE VISIBILITY - COMPREHENSIVE OVERRIDE */
    .messages-show-page,
    .messages-show-page *,
    .messenger-sidebar,
    .messenger-sidebar *,
    .messenger-chat,
    .messenger-chat *,
    .message-bubble,
    .message-bubble *,
    .conversation-item,
    .conversation-item *,
    .user-avatar,
    .user-name,
    .last-message,
    .message-content,
    .message-time,
    .chat-header,
    .chat-header *,
    .messages-container,
    .messages-container *,
    .message-form,
    .message-form *,
    h1, h2, h3, h4, h5, h6, p, a, div, span, button, input, textarea {
        opacity: 1 !important;
        visibility: visible !important;
        color: #1c1c1c !important;
    }
    
    /* Shinkai-style Messenger */
    .messenger-sidebar {
        background: white !important;
        backdrop-filter: none !important;
        -webkit-backdrop-filter: none !important;
        border-right: 1px solid #e0e0e0 !important;
    }
    
    .messenger-chat {
        background: white !important;
        backdrop-filter: none !important;
        position: relative;
    }
    
    .messenger-chat::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><circle cx="100" cy="100" r="3" fill="rgba(255,255,255,0.3)"/><circle cx="300" cy="200" r="2" fill="rgba(255,255,255,0.2)"/><circle cx="500" cy="150" r="2.5" fill="rgba(255,255,255,0.25)"/><circle cx="700" cy="300" r="3" fill="rgba(255,255,255,0.3)"/><circle cx="900" cy="100" r="2" fill="rgba(255,255,255,0.2)"/></svg>');
        opacity: 0.3;
        pointer-events: none;
    }
    
    .message-bubble {
        max-width: 60%;
        padding: 12px 16px;
        border-radius: 18px;
        word-wrap: break-word;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        animation: messageSlideIn 0.3s ease-out;
    }
    
    @keyframes messageSlideIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .message-bubble.sent {
        background: linear-gradient(135deg, #4A90E2, #9B59B6);
        color: white;
        margin-left: auto;
    }
    
    .message-bubble.received {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        color: #2C3E50;
        border: 1px solid rgba(255, 255, 255, 0.5);
    }
    
    #messageInput {
        background: rgba(255, 255, 255, 0.5);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 25px;
        transition: all 0.3s ease;
    }
    
    #messageInput:focus {
        background: rgba(255, 255, 255, 0.7);
        box-shadow: 0 0 20px rgba(74, 144, 226, 0.3);
    }
    
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

<div class="container-fluid messages-show-page" style="padding: 0; height: calc(100vh - 80px); opacity: 1 !important; visibility: visible !important; background: white !important;" data-aos="fade-in">
    <div class="row g-0 h-100" style="opacity: 1 !important; visibility: visible !important;">
        <!-- Sidebar - Danh sách bạn bè -->
        <div class="col-md-4 col-lg-3 border-end messenger-sidebar" style="background: white !important; overflow-y: auto; opacity: 1 !important; visibility: visible !important;">
            <div class="p-3 border-bottom" style="opacity: 1 !important; visibility: visible !important; background: white !important;">
                <h4 class="mb-0 fw-bold" style="color: #1c1c1c !important; opacity: 1 !important; visibility: visible !important;">Đoạn chat</h4>
            </div>
            
            <div class="p-2" style="opacity: 1 !important; visibility: visible !important;">
                <!-- Search box -->
                <div class="mb-2" style="opacity: 1 !important; visibility: visible !important;">
                    <input type="text" id="searchFriends" class="form-control rounded-pill" placeholder="Tìm kiếm trên Messenger" style="opacity: 1 !important; visibility: visible !important; background: white !important; color: #1c1c1c !important;">
                </div>

                <!-- Friends list -->
                <div id="friendsList" style="opacity: 1 !important; visibility: visible !important;">
                    <?php $__currentLoopData = $allFriends; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $friendItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('messages.show', $friendItem->uid)); ?>" 
                           class="d-flex align-items-center p-2 text-decoration-none text-dark rounded friend-item <?php echo e($friendItem->uid == $friend->uid ? 'active' : ''); ?>"
                           data-name="<?php echo e(strtolower($friendItem->name)); ?>"
                           style="opacity: 1 !important; visibility: visible !important; color: #1c1c1c !important;">
                            <div class="position-relative" style="flex-shrink: 0; opacity: 1 !important; visibility: visible !important;">
                                <?php if($friendItem->profile_photo): ?>
                                    <img src="<?php echo e(asset('storage/' . $friendItem->profile_photo)); ?>" 
                                         alt="<?php echo e($friendItem->name); ?>" 
                                         style="width: 56px; height: 56px; border-radius: 50%; object-fit: cover; opacity: 1 !important; visibility: visible !important;">
                                <?php else: ?>
                                    <div style="width: 56px; height: 56px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white !important; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 20px; opacity: 1 !important; visibility: visible !important;">
                                        <?php echo e(strtoupper(substr($friendItem->name, 0, 1))); ?>

                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="ms-3 flex-fill" style="min-width: 0; opacity: 1 !important; visibility: visible !important;">
                                <div class="fw-semibold text-truncate" style="color: #1c1c1c !important; opacity: 1 !important; visibility: visible !important;"><?php echo e($friendItem->name); ?></div>
                                <?php
                                    $lastMsg = $lastMessages[$friendItem->uid] ?? null;
                                ?>
                                <?php if($lastMsg): ?>
                                    <small class="text-muted text-truncate d-block" style="color: #666 !important; opacity: 1 !important; visibility: visible !important;">
                                        <?php if($lastMsg->sender_id === auth()->user()->uid): ?>
                                            Bạn: 
                                        <?php endif; ?>
                                        <?php if($lastMsg->message_type === 'image'): ?>
                                            <i class="bi bi-image"></i> Đã gửi một ảnh
                                        <?php elseif($lastMsg->message_type === 'gif'): ?>
                                            <i class="bi bi-file-play"></i> Đã gửi một GIF
                                        <?php else: ?>
                                            <?php echo e($lastMsg->message); ?>

                                        <?php endif; ?>
                                    </small>
                                <?php else: ?>
                                    <small class="text-muted" style="color: #666 !important; opacity: 1 !important; visibility: visible !important;">Bắt đầu trò chuyện</small>
                                <?php endif; ?>
                            </div>
                            <?php
                                $unread = $unreadCounts[$friendItem->uid] ?? 0;
                            ?>
                            <?php if($unread > 0 && $friendItem->uid != $friend->uid): ?>
                                <span class="badge rounded-pill" style="background: #0084ff !important; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 11px; color: white !important; opacity: 1 !important; visibility: visible !important;">
                                    <?php echo e($unread > 9 ? '9+' : $unread); ?>

                                </span>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>

        <!-- Main chat area -->
        <div class="col-md-8 col-lg-9 d-flex flex-column messenger-chat" style="background: white !important; opacity: 1 !important; visibility: visible !important;">
            <!-- Chat Header -->
            <div class="p-3 border-bottom d-flex align-items-center gap-3" style="box-shadow: 0 1px 2px rgba(0,0,0,0.1); opacity: 1 !important; visibility: visible !important; background: white !important;">
                <!-- Back button for mobile -->
                <button onclick="toggleSidebar()" class="btn btn-link p-0 back-btn-mobile" style="display: none; opacity: 1 !important; visibility: visible !important;">
                    <i class="bi bi-arrow-left" style="font-size: 24px; color: #050505 !important; opacity: 1 !important; visibility: visible !important;"></i>
                </button>
                
                <?php if($friend->profile_photo): ?>
                    <img src="<?php echo e(asset('storage/' . $friend->profile_photo)); ?>" 
                         alt="<?php echo e($friend->name); ?>" 
                         style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; opacity: 1 !important; visibility: visible !important;">
                <?php else: ?>
                    <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white !important; display: flex; align-items: center; justify-content: center; font-weight: bold; opacity: 1 !important; visibility: visible !important;">
                        <?php echo e(strtoupper(substr($friend->name, 0, 1))); ?>

                    </div>
                <?php endif; ?>
                
                <div class="flex-fill" style="opacity: 1 !important; visibility: visible !important;">
                    <h6 class="mb-0 fw-semibold" style="color: #1c1c1c !important; opacity: 1 !important; visibility: visible !important;"><?php echo e($friend->name); ?></h6>
                    <small class="text-muted" style="color: #666 !important; opacity: 1 !important; visibility: visible !important;">Đang hoạt động</small>
                </div>
            </div>

            <!-- Messages Container -->
            <div id="messagesContainer" class="flex-fill overflow-auto p-3" style="background: white !important; opacity: 1 !important; visibility: visible !important;">
            <?php $__empty_1 = true; $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $isOwnMessage = $message->sender_id === auth()->user()->uid;
                ?>
                <div class="mb-3 d-flex <?php echo e($isOwnMessage ? 'justify-content-end' : 'justify-content-start'); ?>" style="opacity: 1 !important; visibility: visible !important;">
                    <div class="d-flex gap-2" style="max-width: 70%; <?php echo e($isOwnMessage ? 'flex-direction: row-reverse;' : ''); ?> opacity: 1 !important; visibility: visible !important;">
                        <!-- Avatar for received messages -->
                        <?php if(!$isOwnMessage): ?>
                            <?php if($friend->profile_photo): ?>
                                <img src="<?php echo e(asset('storage/' . $friend->profile_photo)); ?>" 
                                     alt="<?php echo e($friend->name); ?>" 
                                     style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; flex-shrink: 0; opacity: 1 !important; visibility: visible !important;">
                            <?php else: ?>
                                <div style="width: 32px; height: 32px; border-radius: 50%; background: #6c757d !important; color: white !important; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 14px; flex-shrink: 0; opacity: 1 !important; visibility: visible !important;">
                                    <?php echo e(strtoupper(substr($friend->name, 0, 1))); ?>

                                </div>
                            <?php endif; ?>
                        <?php endif; ?>

                        <div style="opacity: 1 !important; visibility: visible !important;">
                            <?php if($message->message_type === 'image'): ?>
                                <div style="max-width: 300px; opacity: 1 !important; visibility: visible !important;">
                                    <img src="<?php echo e(asset('storage/' . $message->image)); ?>" 
                                         alt="Image" 
                                         style="max-width: 100%; border-radius: 18px; cursor: pointer;"
                                         onclick="window.open(this.src, '_blank')">
                                    <?php if($message->message): ?>
                                        <p class="mb-0 mt-2" style="font-size: 15px;"><?php echo e($message->message); ?></p>
                                    <?php endif; ?>
                                </div>
                            <?php elseif($message->message_type === 'gif'): ?>
                                <div style="max-width: 300px;">
                                    <img src="<?php echo e($message->message); ?>" 
                                         alt="GIF" 
                                         style="max-width: 100%; border-radius: 18px; cursor: pointer;"
                                         onclick="window.open(this.src, '_blank')">
                                </div>
                            <?php else: ?>
                                <div class="rounded-pill px-3 py-2" style="background: <?php echo e($isOwnMessage ? '#0084ff' : '#e4e6eb'); ?>; color: <?php echo e($isOwnMessage ? 'white' : '#050505'); ?>;">
                                    <p class="mb-0" style="font-size: 15px;"><?php echo e($message->message); ?></p>
                                </div>
                            <?php endif; ?>
                            <small class="text-muted d-block <?php echo e($isOwnMessage ? 'text-end' : ''); ?>" style="font-size: 11px; margin-top: 4px; padding: 0 12px;">
                                <?php echo e($message->created_at->format('g:i A')); ?>

                            </small>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="d-flex align-items-center justify-content-center h-100">
                    <div class="text-center">
                        <i class="bi bi-chat-dots text-muted" style="font-size: 48px;"></i>
                        <h5 class="mt-3">No messages yet</h5>
                        <p class="text-muted">Send a message to start the conversation!</p>
                    </div>
                </div>
            <?php endif; ?>
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
                    <?php echo csrf_field(); ?>
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
                            <input type="text" id="gifSearch" class="form-control form-control-sm mb-2" placeholder="Tìm kiếm GIF anime..." style="font-size: 13px;" autocomplete="off">
                            <div id="msg-gif-loading" style="display: none; text-align: center; padding: 20px; color: #65676b;">
                                <i class="bi bi-arrow-repeat" style="font-size: 24px; animation: spin 1s linear infinite;"></i>
                                <p style="margin-top: 8px; font-size: 13px;">Đang tìm kiếm...</p>
                            </div>
                            <div id="gifGrid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; max-height: 340px; overflow-y: auto;">
                                <!-- Trending anime GIFs will load here via Giphy API -->
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
    // Giphy API Configuration for Messenger
    const GIPHY_API_KEY = '2UNLRUTAqLhcKD4ZX3mZZpn5Tw1eVryk';
    const GIPHY_LIMIT = 20;
    let gifSearchTimeout;

    // Load trending anime GIFs for messenger
    async function loadMessengerGIFs() {
        const gifGrid = document.getElementById('gifGrid');
        const gifLoading = document.getElementById('msg-gif-loading');
        
        if (!gifGrid || !gifLoading) return;
        
        try {
            gifLoading.style.display = 'block';
            gifGrid.innerHTML = '';
            
            const url = `https://api.giphy.com/v1/gifs/search?api_key=${GIPHY_API_KEY}&q=anime&limit=${GIPHY_LIMIT}&rating=g`;
            const response = await fetch(url);
            
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            
            const data = await response.json();
            gifLoading.style.display = 'none';
            
            if (data.data && data.data.length > 0) {
                data.data.forEach(gif => {
                    const img = document.createElement('img');
                    img.src = gif.images.fixed_height.url;
                    img.className = 'gif-item';
                    img.alt = gif.title || 'GIF';
                    img.style.cssText = 'width: 100%; border-radius: 8px; cursor: pointer;';
                    img.addEventListener('click', function() {
                        selectMessengerGIF(gif.images.original.url);
                    });
                    gifGrid.appendChild(img);
                });
            }
        } catch (error) {
            console.error('Error loading GIFs:', error);
            gifLoading.style.display = 'none';
            gifGrid.innerHTML = '<p style="text-align:center;color:#65676b;padding:20px;">Không thể tải GIF</p>';
        }
    }

    // Search GIFs for messenger
    async function searchMessengerGIFs(query) {
        if (!query.trim()) {
            loadMessengerGIFs();
            return;
        }
        
        const gifGrid = document.getElementById('gifGrid');
        const gifLoading = document.getElementById('msg-gif-loading');
        
        try {
            gifLoading.style.display = 'block';
            gifGrid.innerHTML = '';
            
            const url = `https://api.giphy.com/v1/gifs/search?api_key=${GIPHY_API_KEY}&q=${encodeURIComponent(query)}&limit=${GIPHY_LIMIT}&rating=g`;
            const response = await fetch(url);
            const data = await response.json();
            
            gifLoading.style.display = 'none';
            
            if (data.data && data.data.length > 0) {
                data.data.forEach(gif => {
                    const img = document.createElement('img');
                    img.src = gif.images.fixed_height.url;
                    img.className = 'gif-item';
                    img.alt = gif.title || 'GIF';
                    img.style.cssText = 'width: 100%; border-radius: 8px; cursor: pointer;';
                    img.addEventListener('click', function() {
                        selectMessengerGIF(gif.images.original.url);
                    });
                    gifGrid.appendChild(img);
                });
            } else {
                gifGrid.innerHTML = '<p style="text-align:center;color:#65676b;padding:20px;">Không tìm thấy GIF</p>';
            }
        } catch (error) {
            console.error('Error searching GIFs:', error);
            gifLoading.style.display = 'none';
        }
    }

    // Select GIF for messenger
    function selectMessengerGIF(gifUrl) {
        const imagePreview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImage');
        const imageInput = document.getElementById('imageInput');
        
        // Clear file input
        imageInput.value = '';
        
        // Set selected GIF URL
        selectedGifUrl = gifUrl;
        
        // Show GIF preview
        previewImg.src = gifUrl;
        imagePreview.style.display = 'block';
        
        // Close GIF picker
        document.getElementById('gifPicker').style.display = 'none';
    }

    const messagesContainer = document.getElementById('messagesContainer');
    const messageForm = document.getElementById('messageForm');
    const messageInput = document.getElementById('messageInput');
    const friendUid = '<?php echo e($friend->uid); ?>';
    const currentUserId = '<?php echo e(auth()->user()->uid); ?>';
    let lastMessageId = <?php echo e($messages->isNotEmpty() ? $messages->last()->id : 0); ?>;
    const displayedMessageIds = new Set([
        <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo e($message->id); ?>,
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    ]);

    // Friend info for avatar
    const friendAvatar = {
        <?php if($friend->profile_photo): ?>
        type: 'profile_photo',
        url: '<?php echo e(asset('storage/' . $friend->profile_photo)); ?>'
        <?php else: ?>
        type: 'initial',
        initial: '<?php echo e(strtoupper(substr($friend->name, 0, 1))); ?>'
        <?php endif; ?>
    };
    const friendName = '<?php echo e($friend->name); ?>';

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

            const response = await fetch('<?php echo e(route("messages.store")); ?>', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: formData
            });

            if (!response.ok) {
                const errorData = await response.json();
                console.error('Server error:', errorData);
                
                if (errorData.errors) {
                    // Validation errors
                    const errorMessages = Object.values(errorData.errors).flat().join('\n');
                    alert('Validation error:\n' + errorMessages);
                } else if (errorData.error) {
                    alert(errorData.error);
                } else {
                    alert('Failed to send message. Please try again.');
                }
                return;
            }

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
            const response = await fetch(`<?php echo e(route('messages.getMessages', ['user' => $friend->uid])); ?>?last_id=${lastMessageId}`);
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
    }, 1000);

    // Mark messages as read
    if (lastMessageId > 0) {
        fetch(`<?php echo e(route('messages.show', $friend->uid)); ?>`, {
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
        const isVisible = picker.style.display === 'block';
        picker.style.display = isVisible ? 'none' : 'block';
        if (emojiPicker) emojiPicker.style.display = 'none';
        
        // Load GIFs when opening
        if (!isVisible) {
            loadMessengerGIFs();
        }
    }
    
    // GIF search input handler
    const gifSearchInput = document.getElementById('gifSearch');
    if (gifSearchInput) {
        gifSearchInput.addEventListener('input', function() {
            clearTimeout(gifSearchTimeout);
            gifSearchTimeout = setTimeout(() => {
                searchMessengerGIFs(this.value);
            }, 500);
        });
    }

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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\AnimeTalk\resources\views/messages/show.blade.php ENDPATH**/ ?>