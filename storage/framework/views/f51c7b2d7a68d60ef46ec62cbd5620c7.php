

<?php $__env->startSection('title', 'Gửi Thông báo'); ?>
<?php $__env->startSection('page-title', 'Gửi Thông báo'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">
                <i class="fas fa-paper-plane mr-2 text-purple-600"></i>Gửi thông báo đến tất cả người dùng
            </h3>
        </div>

        <div class="p-6">
            <form action="<?php echo e(route('admin.notifications.store')); ?>" method="POST" class="space-y-6">
                <?php echo csrf_field(); ?>

                <div>
                    <label for="type" class="block text-sm font-semibold text-gray-700 mb-2">Loại thông báo</label>
                    <select name="type" id="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                        <option value="">-- Chọn loại --</option>
                        <option value="admin_announcement" <?php echo e(old('type') == 'admin_announcement' ? 'selected' : ''); ?>>
                            📢 Thông báo chung
                        </option>
                        <option value="system_maintenance" <?php echo e(old('type') == 'system_maintenance' ? 'selected' : ''); ?>>
                            ⚠️ Bảo trì hệ thống
                        </option>
                        <option value="new_event" <?php echo e(old('type') == 'new_event' ? 'selected' : ''); ?>>
                            🎉 Sự kiện mới
                        </option>
                        <option value="other" <?php echo e(old('type') == 'other' ? 'selected' : ''); ?>>
                            ℹ️ Khác
                        </option>
                    </select>
                    <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Tiêu đề</label>
                    <input 
                        type="text" 
                        name="title" 
                        id="title" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                        value="<?php echo e(old('title')); ?>"
                        placeholder="VD: Hệ thống bảo trì vào 3h sáng..."
                        required
                    >
                    <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">Nội dung</label>
                    <textarea 
                        name="message" 
                        id="message" 
                        rows="5" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        placeholder="Nhập nội dung chi tiết của thông báo..."
                        required
                    ><?php echo e(old('message')); ?></textarea>
                    <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label for="action_url" class="block text-sm font-semibold text-gray-700 mb-2">Link hành động (tùy chọn)</label>
                    <input 
                        type="url" 
                        name="action_url" 
                        id="action_url" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent <?php $__errorArgs = ['action_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        value="<?php echo e(old('action_url')); ?>"
                        placeholder="https://..."
                    >
                    <p class="mt-1 text-sm text-gray-500">Nếu có, người dùng sẽ được chuyển đến link này khi click vào thông báo</p>
                    <?php $__errorArgs = ['action_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                    <div class="flex">
                        <i class="fas fa-info-circle text-blue-500 mt-0.5 mr-3"></i>
                        <div>
                            <p class="text-sm text-blue-700">
                                <strong>Lưu ý:</strong> Thông báo này sẽ được gửi đến <strong>TẤT CẢ</strong> người dùng trong hệ thống.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="px-6 py-2 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-lg hover:shadow-lg transition">
                        <i class="fas fa-paper-plane mr-2"></i>Gửi thông báo
                    </button>
                    <a href="<?php echo e(route('admin.notifications.index')); ?>" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        <i class="fas fa-times mr-2"></i>Hủy
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\AnimeTalk\resources\views/admin/notifications/create.blade.php ENDPATH**/ ?>