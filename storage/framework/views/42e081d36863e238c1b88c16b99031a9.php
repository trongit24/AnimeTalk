

<?php $__env->startSection('title', 'Quản lý Thông báo'); ?>
<?php $__env->startSection('page-title', 'Quản lý Thông báo'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6">
    <div class="flex justify-between items-center">
        <p class="text-gray-600">Gửi thông báo cho tất cả người dùng trong hệ thống</p>
        <a href="<?php echo e(route('admin.notifications.create')); ?>" class="px-6 py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-lg hover:shadow-lg transition">
            <i class="fas fa-plus mr-2"></i>Gửi thông báo mới
        </a>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

    <?php if($notifications->count() > 0): ?>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Loại</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tiêu đề</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nội dung</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Thời gian</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo e($notification->id); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php
                                $badges = [
                                    'admin_announcement' => ['bg-blue-100 text-blue-800', 'Thông báo'],
                                    'system_maintenance' => ['bg-yellow-100 text-yellow-800', 'Bảo trì'],
                                    'new_event' => ['bg-green-100 text-green-800', 'Sự kiện mới'],
                                    'other' => ['bg-gray-100 text-gray-800', 'Khác']
                                ];
                                $badge = $badges[$notification->type] ?? ['bg-gray-100 text-gray-800', 'Khác'];
                            ?>
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo e($badge[0]); ?>">
                                <?php echo e($badge[1]); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900"><?php echo e($notification->title); ?></td>
                        <td class="px-6 py-4 text-sm text-gray-600"><?php echo e(\Illuminate\Support\Str::limit($notification->message, 60)); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo e($notification->created_at->diffForHumans()); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <form action="<?php echo e(route('admin.notifications.destroy', $notification->id)); ?>" method="POST" onsubmit="return confirm('Xác nhận xóa thông báo này?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-red-600 hover:text-red-900 transition" title="Xóa">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-200">
            <?php echo e($notifications->links()); ?>

        </div>
    <?php else: ?>
        <div class="text-center py-16">
            <i class="fas fa-bell-slash text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 text-lg">Chưa có thông báo nào</p>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\AnimeTalk\resources\views/admin/notifications/index.blade.php ENDPATH**/ ?>