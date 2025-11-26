

<?php $__env->startSection('title', 'Chi tiết cộng đồng'); ?>
<?php $__env->startSection('page-title', 'Chi tiết cộng đồng'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Back Button -->
    <a href="<?php echo e(route('admin.communities.index')); ?>" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800">
        <i class="fas fa-arrow-left"></i>
        <span>Quay lại danh sách</span>
    </a>

    <!-- Community Header -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <?php if($community->banner): ?>
            <img src="<?php echo e(asset('storage/' . $community->banner)); ?>" alt="<?php echo e($community->name); ?>" class="w-full h-64 object-cover">
        <?php elseif($community->icon): ?>
            <div class="w-full h-64 bg-gray-100 flex items-center justify-center">
                <img src="<?php echo e(asset('storage/' . $community->icon)); ?>" alt="<?php echo e($community->name); ?>" class="w-48 h-48 object-contain">
            </div>
        <?php else: ?>
            <div class="w-full h-64 bg-gradient-to-br from-purple-400 to-pink-400 flex items-center justify-center">
                <span class="text-8xl text-white font-bold"><?php echo e(strtoupper(substr($community->name, 0, 2))); ?></span>
            </div>
        <?php endif; ?>

        <div class="p-8">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-gray-800 mb-2"><?php echo e($community->name); ?></h1>
                    
                    <?php if($community->description): ?>
                        <p class="text-gray-600 mb-4"><?php echo e($community->description); ?></p>
                    <?php endif; ?>

                    <div class="flex items-center gap-4 text-sm text-gray-500">
                        <span><i class="fas fa-user text-purple-500 mr-1"></i>Tạo bởi: <?php echo e($community->creator->name); ?></span>
                        <span>•</span>
                        <span><?php echo e($community->created_at->format('d/m/Y')); ?></span>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a href="<?php echo e(route('communities.show', $community->slug)); ?>" target="_blank" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                        <i class="fas fa-external-link-alt mr-2"></i>Xem trên trang
                    </a>
                    <form method="POST" action="<?php echo e(route('admin.communities.destroy', $community)); ?>" 
                          onsubmit="return confirm('Bạn có chắc muốn xóa cộng đồng này?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                            <i class="fas fa-trash mr-2"></i>Xóa
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-blue-500 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Tổng thành viên</p>
                    <h3 class="text-2xl font-bold text-gray-800"><?php echo e($community->members_count); ?></h3>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-newspaper text-purple-500 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Tổng bài viết</p>
                    <h3 class="text-2xl font-bold text-gray-800"><?php echo e($community->posts_count); ?></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Members -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Thành viên (<?php echo e($community->members_count); ?>)</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php $__empty_1 = true; $__currentLoopData = $community->members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <img src="<?php echo e($member->profile_photo ? asset('storage/' . $member->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode($member->name)); ?>" 
                         alt="<?php echo e($member->name); ?>" 
                         class="w-12 h-12 rounded-full">
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-gray-800 truncate"><?php echo e($member->name); ?></p>
                        <p class="text-sm text-gray-500 truncate"><?php echo e($member->email); ?></p>
                    </div>
                    <a href="<?php echo e(route('admin.users.show', $member)); ?>" class="text-blue-600 hover:text-blue-800" title="Xem profile">
                        <i class="fas fa-eye"></i>
                    </a>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="col-span-full text-gray-500 text-center py-8">Chưa có thành viên nào</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Recent Posts -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Bài viết gần đây</h2>
        
        <div class="space-y-4">
            <?php $__empty_1 = true; $__currentLoopData = $community->posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <a href="<?php echo e(route('admin.posts.show', $post)); ?>" class="block p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <div class="flex items-start gap-3">
                        <?php if($post->image): ?>
                            <img src="<?php echo e(asset('storage/' . $post->image)); ?>" alt="<?php echo e($post->title); ?>" class="w-20 h-20 rounded-lg object-cover">
                        <?php endif; ?>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-medium text-gray-800 line-clamp-2 mb-1"><?php echo e($post->title); ?></h3>
                            <div class="flex items-center gap-3 text-sm text-gray-500">
                                <span><i class="fas fa-user mr-1"></i><?php echo e($post->user->name); ?></span>
                                <span><?php echo e($post->created_at->diffForHumans()); ?></span>
                            </div>
                        </div>
                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-gray-500 text-center py-8">Chưa có bài viết nào</p>
            <?php endif; ?>
        </div>

        <?php if($community->posts_count > 10): ?>
            <a href="<?php echo e(route('admin.posts.index')); ?>" class="block mt-4 text-center text-purple-600 hover:text-purple-800">
                Xem tất cả bài viết →
            </a>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\AnimeTalk\resources\views/admin/communities/show.blade.php ENDPATH**/ ?>