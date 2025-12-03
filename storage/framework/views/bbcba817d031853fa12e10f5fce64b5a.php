

<?php $__env->startSection('title', 'Chat - ' . $community->name); ?>

<?php $__env->startPush('styles'); ?>
<style>
.chat-container {
    max-width: 100%;
    margin: 0 auto;
    background: white;
    height: 100vh;
    display: flex;
    flex-direction: column;
}

.chat-header {
    padding: 1rem;
    background: linear-gradient(135deg, #5BA3D0, #9B7EDE);
    color: white;
    font-weight: 600;
    border-bottom: 2px solid #4a92bf;
}

.chat-messages {
    flex: 1;
    overflow-y: auto;
    padding: 1rem;
    background: #f9fafb;
}

.message {
    margin-bottom: 1rem;
    animation: fadeIn 0.3s;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.message.pinned {
    background: #fff9e6;
    border-left: 4px solid #ffc107;
    padding: 0.5rem;
    border-radius: 8px;
}

.message-header {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.5rem;
}

.message-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    object-fit: cover;
}

.message-avatar-placeholder {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: linear-gradient(135deg, #5BA3D0, #9B7EDE);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
}

.message-author {
    font-weight: 600;
    color: #333;
}

.message-time {
    font-size: 0.8rem;
    color: #999;
}

.message-content {
    margin-left: 44px;
    background: white;
    padding: 0.75rem;
    border-radius: 8px;
    border: 1px solid #e0e0e0;
    word-wrap: break-word;
}

.message-image {
    max-width: 300px;
    border-radius: 8px;
    margin-top: 0.5rem;
    cursor: pointer;
}

.chat-input-container {
    padding: 1rem;
    background: white;
    border-top: 1px solid #e0e0e0;
}

.chat-input-form {
    display: flex;
    gap: 0.5rem;
}

.chat-input {
    flex: 1;
    padding: 0.75rem;
    border: 1px solid #e0e0e0;
    border-radius: 24px;
    font-family: inherit;
    resize: none;
}

.chat-send-btn {
    padding: 0.75rem 1.5rem;
    background: linear-gradient(135deg, #5BA3D0, #9B7EDE);
    color: white;
    border: none;
    border-radius: 24px;
    font-weight: 600;
    cursor: pointer;
    transition: transform 0.2s;
}

.chat-send-btn:hover {
    transform: scale(1.05);
}

.chat-send-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="chat-container">
    <div class="chat-header">
        <i class="bi bi-chat-dots"></i> <?php echo e($community->name); ?> - Group Chat
    </div>

    <div class="chat-messages" id="chat-messages">
        <?php $__empty_1 = true; $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="message <?php echo e($message->is_pinned ? 'pinned' : ''); ?>" data-message-id="<?php echo e($message->id); ?>">
            <div class="message-header">
                <?php if($message->user->profile_photo): ?>
                <img src="<?php echo e(asset('storage/' . $message->user->profile_photo)); ?>" alt="<?php echo e($message->user->name); ?>" class="message-avatar">
                <?php else: ?>
                <div class="message-avatar-placeholder">
                    <?php echo e(strtoupper(substr($message->user->name, 0, 1))); ?>

                </div>
                <?php endif; ?>
                <span class="message-author"><?php echo e($message->user->name); ?></span>
                <span class="message-time"><?php echo e($message->created_at->diffForHumans()); ?></span>
                <?php if($message->is_pinned): ?>
                <span style="color: #ffc107; margin-left: auto;">
                    <i class="bi bi-pin-fill"></i> Pinned
                </span>
                <?php endif; ?>
            </div>
            <div class="message-content">
                <p style="margin: 0; white-space: pre-wrap;"><?php echo e($message->message); ?></p>
                <?php if($message->image): ?>
                <img src="<?php echo e(asset('storage/' . $message->image)); ?>" alt="Message image" class="message-image">
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div style="text-align: center; color: #999; padding: 3rem;">
            <i class="bi bi-chat-dots" style="font-size: 3rem;"></i>
            <p style="margin-top: 1rem;">No messages yet. Start the conversation!</p>
        </div>
        <?php endif; ?>
    </div>

    <div class="chat-input-container">
        <form id="chat-form" class="chat-input-form" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <textarea id="message-input" name="message" class="chat-input" rows="1" 
                      placeholder="Type a message..." required></textarea>
            <input type="file" id="image-input" name="image" accept="image/*" style="display: none;">
            <button type="button" onclick="document.getElementById('image-input').click()" 
                    style="padding: 0.75rem 1rem; background: #f0f0f0; border: none; border-radius: 50%; cursor: pointer;">
                <i class="bi bi-image"></i>
            </button>
            <button type="submit" class="chat-send-btn">
                <i class="bi bi-send"></i> Send
            </button>
        </form>
        <div id="image-preview" style="margin-top: 0.5rem; display: none;">
            <img id="preview-img" style="max-height: 100px; border-radius: 8px; border: 1px solid #e0e0e0;">
            <button type="button" onclick="clearImage()" style="margin-left: 0.5rem; padding: 0.25rem 0.5rem; background: #ff4444; color: white; border: none; border-radius: 4px; cursor: pointer;">
                <i class="bi bi-x"></i>
            </button>
        </div>
    </div>
</div>

<script>
let lastMessageId = <?php echo e($messages->first()->id ?? 0); ?>;

// Auto-resize textarea
document.getElementById('message-input').addEventListener('input', function() {
    this.style.height = 'auto';
    this.style.height = (this.scrollHeight) + 'px';
});

// Image preview
document.getElementById('image-input').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('image-preview').style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});

function clearImage() {
    document.getElementById('image-input').value = '';
    document.getElementById('image-preview').style.display = 'none';
}

// Send message
document.getElementById('chat-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const sendBtn = this.querySelector('.chat-send-btn');
    
    sendBtn.disabled = true;
    
    fetch('<?php echo e(route('communities.chat.store', $community->slug)); ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            addMessage(data.message);
            document.getElementById('message-input').value = '';
            document.getElementById('message-input').style.height = 'auto';
            clearImage();
        }
    })
    .catch(error => console.error('Error:', error))
    .finally(() => {
        sendBtn.disabled = false;
    });
});

// Add message to chat
function addMessage(message) {
    const messagesContainer = document.getElementById('chat-messages');
    
    const messageDiv = document.createElement('div');
    messageDiv.className = 'message';
    messageDiv.dataset.messageId = message.id;
    
    messageDiv.innerHTML = `
        <div class="message-header">
            ${message.user.profile_photo ? 
                `<img src="/storage/${message.user.profile_photo}" alt="${message.user.name}" class="message-avatar">` :
                `<div class="message-avatar-placeholder">${message.user.name.charAt(0).toUpperCase()}</div>`
            }
            <span class="message-author">${message.user.name}</span>
            <span class="message-time">just now</span>
        </div>
        <div class="message-content">
            <p style="margin: 0; white-space: pre-wrap;">${message.message}</p>
            ${message.image ? `<img src="/storage/${message.image}" alt="Message image" class="message-image">` : ''}
        </div>
    `;
    
    messagesContainer.appendChild(messageDiv);
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
    lastMessageId = message.id;
}

// Poll for new messages every 3 seconds
setInterval(() => {
    fetch('<?php echo e(route('communities.chat.messages', $community->slug)); ?>?last_id=' + lastMessageId)
        .then(response => response.json())
        .then(data => {
            if (data.messages && data.messages.length > 0) {
                data.messages.reverse().forEach(message => {
                    addMessage(message);
                });
            }
        })
        .catch(error => console.error('Error:', error));
}, 3000);

// Scroll to bottom on load
document.getElementById('chat-messages').scrollTop = document.getElementById('chat-messages').scrollHeight;
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\AnimeTalk\resources\views/communities/chat.blade.php ENDPATH**/ ?>