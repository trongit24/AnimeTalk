

<?php $__env->startSection('title', 'Quản lý cộng đồng'); ?>
<?php $__env->startSection('page-title', 'Quản lý cộng đồng'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form method="GET" action="<?php echo e(route('admin.communities.index')); ?>" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[250px]">
                <input type="text" 
                       name="search" 
                       value="<?php echo e(request('search')); ?>" 
                       placeholder="Tìm kiếm theo tên, mô tả..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>
            <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                <i class="fas fa-search mr-2"></i>Tìm kiếm
            </button>
            <?php if(request('search')): ?>
                <a href="<?php echo e(route('admin.communities.index')); ?>" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                    <i class="fas fa-times mr-2"></i>Xóa bộ lọc
                </a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Communities Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php $__empty_1 = true; $__currentLoopData = $communities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $community): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-lg transition">
                <?php if($community->banner): ?>
                    <img src="<?php echo e(asset('storage/' . $community->banner)); ?>" alt="<?php echo e($community->name); ?>" class="w-full h-48 object-cover">
                <?php elseif($community->icon): ?>
                    <div class="w-full h-48 bg-gray-100 flex items-center justify-center">
                        <img src="<?php echo e(asset('storage/' . $community->icon)); ?>" alt="<?php echo e($community->name); ?>" class="w-32 h-32 object-contain">
                    </div>
                <?php else: ?>
                    <div class="w-full h-48 bg-gradient-to-br from-purple-400 to-pink-400 flex items-center justify-center">
                        <span class="text-6xl text-white font-bold"><?php echo e(strtoupper(substr($community->name, 0, 2))); ?></span>
                    </div>
                <?php endif; ?>

                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2"><?php echo e($community->name); ?></h3>
                    
                    <?php if($community->description): ?>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2"><?php echo e($community->description); ?></p>
                    <?php endif; ?>

                    <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                        <span><i class="fas fa-users text-blue-500 mr-1"></i><?php echo e($community->members_count); ?> thành viên</span>
                        <span><i class="fas fa-newspaper text-purple-500 mr-1"></i><?php echo e($community->posts_count); ?> bài viết</span>
                    </div>

                    <div class="flex items-center gap-2 pt-4 border-t">
                        <a href="<?php echo e(route('admin.communities.show', $community)); ?>" class="flex-1 px-4 py-2 bg-blue-500 text-white text-center rounded-lg hover:bg-blue-600 transition">
                            <i class="fas fa-eye mr-2"></i>Xem
                        </a>
                        <a href="<?php echo e(route('communities.show', $community->slug)); ?>" target="_blank" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition" title="Xem trên trang">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                        <form method="POST" action="<?php echo e(route('admin.communities.destroy', $community)); ?>" class="inline" 
                              onsubmit="return confirm('Bạn có chắc muốn xóa cộng đồng này?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition" title="Xóa">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-full">
                <div class="bg-white rounded-xl shadow-sm p-12 text-center text-gray-500">
                    <i class="fas fa-users-rectangle text-6xl mb-4 text-gray-300"></i>
                    <p class="text-xl">Không tìm thấy cộng đồng nào</p>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if($communities->hasPages()): ?>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <?php echo e($communities->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\AnimeTalk\resources\views/admin/communities/index.blade.php ENDPATH**/ ?>