

<?php $__env->startSection('title', 'Chi tiết người dùng'); ?>
<?php $__env->startSection('page-title', 'Chi tiết người dùng'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Back Button -->
    <a href="<?php echo e(route('admin.users.index')); ?>" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800">
        <i class="fas fa-arrow-left"></i>
        <span>Quay lại danh sách</span>
    </a>

    <!-- User Info -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="h-32 bg-gradient-to-r from-purple-500 to-pink-500"></div>
        <div class="px-8 pb-8">
            <div class="flex items-end gap-6 -mt-16">
                <img src="<?php echo e($user->profile_photo ? asset('storage/' . $user->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&size=200'); ?>" 
                     alt="<?php echo e($user->name); ?>" 
                     class="w-32 h-32 rounded-full border-4 border-white shadow-lg">
                <div class="flex-1 pb-4">
                    <div class="flex items-start justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800"><?php echo e($user->name); ?></h2>
                            <p class="text-gray-600"><?php echo e($user->email); ?></p>
                            <p class="text-sm text-gray-500 mt-1">UID: <?php echo e($user->uid); ?></p>
                        </div>
                        <div class="flex items-center gap-2">
                            <?php if($user->role === 'admin'): ?>
                                <span class="px-4 py-2 bg-purple-100 text-purple-700 font-medium rounded-lg">
                                    <i class="fas fa-shield-halved mr-2"></i>Administrator
                                </span>
                            <?php else: ?>
                                <span class="px-4 py-2 bg-gray-100 text-gray-700 font-medium rounded-lg">
                                    <i class="fas fa-user mr-2"></i>User
                                </span>
                            <?php endif; ?>
                            <a href="<?php echo e(route('admin.users.edit', $user)); ?>" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                                <i class="fas fa-edit mr-2"></i>Chỉnh sửa
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <?php if($user->bio): ?>
                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                    <p class="text-gray-700"><?php echo e($user->bio); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-newspaper text-purple-500 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Tổng bài viết</p>
                    <h3 class="text-2xl font-bold text-gray-800"><?php echo e($user->posts_count); ?></h3>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-comments text-blue-500 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Tổng bình luận</p>
                    <h3 class="text-2xl font-bold text-gray-800"><?php echo e($user->comments_count); ?></h3>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users-rectangle text-pink-500 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Cộng đồng tham gia</p>
                    <h3 class="text-2xl font-bold text-gray-800"><?php echo e($user->communities_count); ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Posts -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Bài viết gần đây</h3>
            <div class="space-y-3">
                <?php $__empty_1 = true; $__currentLoopData = $user->posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a href="<?php echo e(route('admin.posts.show', $post)); ?>" class="block p-3 hover:bg-gray-50 rounded-lg transition">
                        <h4 class="font-medium text-gray-800 line-clamp-1"><?php echo e($post->title); ?></h4>
                        <p class="text-sm text-gray-500 mt-1"><?php echo e($post->created_at->diffForHumans()); ?></p>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-gray-500 text-center py-8">Chưa có bài viết nào</p>
                <?php endif; ?>
            </div>
            <?php if($user->posts_count > 10): ?>
                <a href="<?php echo e(route('admin.posts.index', ['search' => $user->email])); ?>" class="block mt-4 text-center text-purple-600 hover:text-purple-800">
                    Xem tất cả bài viết →
                </a>
            <?php endif; ?>
        </div>

        <!-- Recent Comments -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Bình luận gần đây</h3>
            <div class="space-y-3">
                <?php $__empty_1 = true; $__currentLoopData = $user->comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="p-3 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-700 line-clamp-2"><?php echo e($comment->content); ?></p>
                        <p class="text-xs text-gray-500 mt-1"><?php echo e($comment->created_at->diffForHumans()); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-gray-500 text-center py-8">Chưa có bình luận nào</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Hành động</h3>
        <div class="flex flex-wrap gap-4">
            <?php if($user->uid !== auth()->user()->uid): ?>
                <form method="POST" action="<?php echo e(route('admin.users.toggleRole', $user)); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="px-6 py-2 <?php echo e($user->role === 'admin' ? 'bg-gray-500' : 'bg-purple-500'); ?> text-white rounded-lg hover:opacity-90 transition">
                        <i class="fas fa-<?php echo e($user->role === 'admin' ? 'user' : 'shield-halved'); ?> mr-2"></i>
                        <?php echo e($user->role === 'admin' ? 'Hạ xuống User' : 'Nâng lên Admin'); ?>

                    </button>
                </form>

                <form method="POST" action="<?php echo e(route('admin.users.destroy', $user)); ?>" 
                      onsubmit="return confirm('Bạn có chắc muốn xóa người dùng này? Hành động này không thể hoàn tác!')">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                        <i class="fas fa-trash mr-2"></i>Xóa người dùng
                    </button>
                </form>
            <?php else: ?>
                <p class="text-gray-500 italic">Bạn không thể thực hiện hành động trên chính mình.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\AnimeTalk\resources\views/admin/users/show.blade.php ENDPATH**/ ?>