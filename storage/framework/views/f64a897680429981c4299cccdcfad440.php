

<?php $__env->startSection('title', 'Quản lý bài viết'); ?>
<?php $__env->startSection('page-title', 'Quản lý bài viết'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form method="GET" action="<?php echo e(route('admin.posts.index')); ?>" class="space-y-4">
            <div class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[250px]">
                    <input type="text" 
                           name="search" 
                           value="<?php echo e(request('search')); ?>" 
                           placeholder="Tìm kiếm theo tiêu đề, nội dung..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>
                <select name="category" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                    <option value="">Tất cả danh mục</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($cat); ?>" <?php echo e(request('category') === $cat ? 'selected' : ''); ?>><?php echo e($cat); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="flex flex-wrap gap-4">
                <input type="date" 
                       name="date_from" 
                       value="<?php echo e(request('date_from')); ?>" 
                       class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                <input type="date" 
                       name="date_to" 
                       value="<?php echo e(request('date_to')); ?>" 
                       class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                
                <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                    <i class="fas fa-search mr-2"></i>Tìm kiếm
                </button>
                <?php if(request()->hasAny(['search', 'category', 'date_from', 'date_to'])): ?>
                    <a href="<?php echo e(route('admin.posts.index')); ?>" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        <i class="fas fa-times mr-2"></i>Xóa bộ lọc
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Posts Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bài viết</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tác giả</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Danh mục</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thống kê</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày tạo</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Hành động</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-start gap-3">
                                    <?php if($post->image): ?>
                                        <img src="<?php echo e(asset('storage/' . $post->image)); ?>" alt="<?php echo e($post->title); ?>" class="w-16 h-16 rounded-lg object-cover flex-shrink-0">
                                    <?php elseif($post->video): ?>
                                        <div class="w-16 h-16 rounded-lg bg-gray-800 flex items-center justify-center flex-shrink-0 relative overflow-hidden">
                                            <i class="fas fa-play text-white text-xl absolute z-10"></i>
                                            <video class="w-full h-full object-cover opacity-60">
                                                <source src="<?php echo e(asset('storage/' . $post->video)); ?>" type="video/mp4">
                                            </video>
                                        </div>
                                    <?php else: ?>
                                        <div class="w-16 h-16 rounded-lg bg-gradient-to-br from-purple-400 to-pink-400 flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-file-alt text-white text-xl"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium text-gray-800 line-clamp-2"><?php echo e($post->title); ?></p>
                                        <p class="text-sm text-gray-500 line-clamp-1 mt-1"><?php echo e(Str::limit(strip_tags($post->content), 100)); ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <img src="<?php echo e($post->user->profile_photo ? asset('storage/' . $post->user->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode($post->user->name)); ?>" 
                                         alt="<?php echo e($post->user->name); ?>" 
                                         class="w-8 h-8 rounded-full">
                                    <span class="text-sm text-gray-700"><?php echo e($post->user->name); ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if($post->category): ?>
                                    <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded-full">
                                        <?php echo e($post->category); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="text-gray-400 text-sm">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <div class="flex items-center gap-3">
                                    <span title="Bình luận"><i class="fas fa-comments text-blue-500"></i> <?php echo e($post->comments_count); ?></span>
                                    <span title="Lượt thích"><i class="fas fa-heart text-red-500"></i> <?php echo e($post->likes_count); ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <?php echo e($post->created_at->format('d/m/Y H:i')); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="<?php echo e(route('admin.posts.show', $post)); ?>" class="text-blue-600 hover:text-blue-900" title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('posts.show', $post->slug)); ?>" target="_blank" class="text-green-600 hover:text-green-900" title="Xem trên trang">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                    <form method="POST" action="<?php echo e(route('admin.posts.destroy', $post)); ?>" class="inline" 
                                          onsubmit="return confirm('Bạn có chắc muốn xóa bài viết này?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="text-red-600 hover:text-red-900" title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-newspaper text-4xl mb-3 text-gray-300"></i>
                                <p>Không tìm thấy bài viết nào</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if($posts->hasPages()): ?>
            <div class="px-6 py-4 border-t border-gray-200">
                <?php echo e($posts->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\AnimeTalk\resources\views/admin/posts/index.blade.php ENDPATH**/ ?>