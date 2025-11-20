

<?php $__env->startSection('title', 'Thông báo - AnimeTalk'); ?>

<?php $__env->startSection('content'); ?>
<div class="container" style="max-width: 900px; margin-top: 30px;">
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center" style="padding: 1.5rem;">
            <h4 class="mb-0">
                <i class="bi bi-bell"></i>
                Thông báo
            </h4>
            <?php if($notifications->where('is_read', false)->count() > 0): ?>
                <form method="POST" action="<?php echo e(route('notifications.read-all')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-check-all"></i>
                        Đánh dấu tất cả là đã đọc
                    </button>
                </form>
            <?php endif; ?>
        </div>

        <div class="card-body p-0">
            <?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="notification-item <?php echo e(!$notification->is_read ? 'unread' : ''); ?>" 
                     style="padding: 1rem 1.5rem; border-bottom: 1px solid #e9ecef; display: flex; gap: 1rem; align-items: start; <?php echo e(!$notification->is_read ? 'background-color: #f0f7ff;' : ''); ?>">
                    
                    <div style="flex-shrink: 0;">
                        <?php if($notification->event && $notification->event->cover_image): ?>
                            <img src="<?php echo e(asset('storage/' . $notification->event->cover_image)); ?>" 
                                 alt="Event" 
                                 style="width: 50px; height: 50px; border-radius: 8px; object-fit: cover;">
                        <?php else: ?>
                            <div style="width: 50px; height: 50px; border-radius: 8px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-calendar-event" style="font-size: 24px; color: white;"></i>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div style="flex: 1; min-width: 0;">
                        <div style="display: flex; justify-content: between; align-items: start; gap: 1rem;">
                            <div style="flex: 1;">
                                <p class="mb-1" style="font-weight: <?php echo e(!$notification->is_read ? '600' : '400'); ?>; color: #1a202c;">
                                    <?php echo e($notification->message); ?>

                                </p>
                                <?php if($notification->event): ?>
                                    <a href="<?php echo e(route('events.show', $notification->event)); ?>" 
                                       class="text-decoration-none"
                                       style="color: #5b21b6; font-size: 0.9rem;">
                                        <i class="bi bi-calendar-event"></i>
                                        <?php echo e($notification->event->title); ?>

                                    </a>
                                <?php endif; ?>
                                <p class="mb-0 text-muted" style="font-size: 0.85rem; margin-top: 0.25rem;">
                                    <i class="bi bi-clock"></i>
                                    <?php echo e($notification->created_at->diffForHumans()); ?>

                                </p>
                            </div>

                            <?php if(!$notification->is_read): ?>
                                <button onclick="markAsRead(<?php echo e($notification->id); ?>)" 
                                        class="btn btn-sm btn-link p-0"
                                        style="color: #5b21b6;"
                                        title="Đánh dấu đã đọc">
                                    <i class="bi bi-check2"></i>
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="text-center py-5" style="color: #64748b;">
                    <i class="bi bi-bell-slash" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 1rem;"></i>
                    <p class="mb-0">Bạn chưa có thông báo nào</p>
                </div>
            <?php endif; ?>
        </div>

        <?php if($notifications->hasPages()): ?>
            <div class="card-footer bg-white border-top">
                <?php echo e($notifications->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>

<script>
function markAsRead(notificationId) {
    fetch(`/notifications/${notificationId}/read`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}
</script>

<style>
.notification-item:hover {
    background-color: #f9fafb !important;
}

.notification-item:last-child {
    border-bottom: none !important;
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\AnimeTalk\resources\views/notifications/index.blade.php ENDPATH**/ ?>