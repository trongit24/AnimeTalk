

<?php $__env->startSection('title', 'Thông báo - AnimeTalk'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 fw-bold">
                            <i class="bi bi-bell-fill me-2"></i>Thông báo
                        </h4>
                        <?php if($notifications->where('is_read', false)->count() > 0): ?>
                        <form action="<?php echo e(route('notifications.read-all')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-check-all me-1"></i>Đánh dấu tất cả đã đọc
                            </button>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="card-body p-0">
                    <?php if($notifications->count() > 0): ?>
                        <div class="list-group list-group-flush">
                            <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="list-group-item notification-item <?php echo e(!$notification->is_read ? 'unread' : ''); ?>">
                                <div class="d-flex align-items-start">
                                    <div class="notification-icon me-3">
                                        <?php switch($notification->type):
                                            case ('friend_request'): ?>
                                                <i class="bi bi-person-plus-fill text-primary"></i>
                                                <?php break; ?>
                                            <?php case ('event_reminder'): ?>
                                            <?php case ('event_starting'): ?>
                                                <i class="bi bi-calendar-event-fill text-success"></i>
                                                <?php break; ?>
                                            <?php case ('admin_announcement'): ?>
                                                <i class="bi bi-megaphone-fill text-warning"></i>
                                                <?php break; ?>
                                            <?php case ('system_maintenance'): ?>
                                                <i class="bi bi-exclamation-triangle-fill text-danger"></i>
                                                <?php break; ?>
                                            <?php case ('new_event'): ?>
                                                <i class="bi bi-star-fill text-info"></i>
                                                <?php break; ?>
                                            <?php default: ?>
                                                <i class="bi bi-bell-fill text-secondary"></i>
                                        <?php endswitch; ?>
                                    </div>
                                    
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 fw-bold"><?php echo e($notification->title); ?></h6>
                                                <p class="mb-2 text-muted"><?php echo e($notification->message); ?></p>
                                                <small class="text-muted">
                                                    <i class="bi bi-clock me-1"></i><?php echo e($notification->created_at->diffForHumans()); ?>

                                                </small>
                                            </div>
                                            
                                            <div class="d-flex align-items-center gap-2">
                                                <?php if(!$notification->is_read): ?>
                                                <span class="badge bg-primary rounded-pill">Mới</span>
                                                <?php endif; ?>
                                                <button class="btn btn-sm btn-link text-danger p-0 delete-notification-btn" data-id="<?php echo e($notification->id); ?>" title="Xóa thông báo">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <?php if($notification->action_url): ?>
                                        <div class="mt-2">
                                            <a href="<?php echo e($notification->action_url); ?>" class="btn btn-sm btn-outline-primary mark-read-btn" data-id="<?php echo e($notification->id); ?>">
                                                Xem chi tiết <i class="bi bi-arrow-right ms-1"></i>
                                            </a>
                                        </div>
                                        <?php else: ?>
                                            <?php if(!$notification->is_read): ?>
                                            <button class="btn btn-sm btn-link text-muted p-0 mt-2 mark-read-btn" data-id="<?php echo e($notification->id); ?>">
                                                Đánh dấu đã đọc
                                            </button>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <div class="p-3">
                            <?php echo e($notifications->links()); ?>

                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="bi bi-bell-slash display-1 text-muted"></i>
                            <p class="text-muted mt-3">Bạn chưa có thông báo nào</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.notification-item {
    transition: background-color 0.2s;
    border-left: 3px solid transparent;
}

.notification-item.unread {
    background-color: #f8f9fa;
    border-left-color: #667eea;
}

.notification-item:hover {
    background-color: #f0f0f0;
}

.notification-icon {
    font-size: 1.5rem;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background-color: rgba(102, 126, 234, 0.1);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.mark-read-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            const notificationId = this.getAttribute('data-id');
            
            fetch(`/notifications/${notificationId}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const item = this.closest('.notification-item');
                    if (item) {
                        item.classList.remove('unread');
                        const badge = item.querySelector('.badge');
                        if (badge) badge.remove();
                        if (!this.href) this.remove();
                    }
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });

    // Handle delete notification
    document.querySelectorAll('.delete-notification-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (!confirm('Bạn có chắc muốn xóa thông báo này?')) {
                return;
            }
            
            const notificationId = this.getAttribute('data-id');
            const item = this.closest('.notification-item');
            
            fetch(`/notifications/${notificationId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Animate and remove the notification
                    item.style.transition = 'opacity 0.3s, transform 0.3s';
                    item.style.opacity = '0';
                    item.style.transform = 'translateX(100%)';
                    
                    setTimeout(() => {
                        item.remove();
                        
                        // Check if there are no more notifications
                        const remainingNotifications = document.querySelectorAll('.notification-item');
                        if (remainingNotifications.length === 0) {
                            location.reload();
                        }
                    }, 300);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi xóa thông báo');
            });
        });
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\AnimeTalk\resources\views/notifications/index.blade.php ENDPATH**/ ?>