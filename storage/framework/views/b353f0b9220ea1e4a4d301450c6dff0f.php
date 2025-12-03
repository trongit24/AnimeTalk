

<?php $__env->startSection('title', 'Chi tiết bài viết'); ?>
<?php $__env->startSection('page-title', 'Chi tiết bài viết'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Back Button -->
    <a href="<?php echo e(route('admin.posts.index')); ?>" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800">
        <i class="fas fa-arrow-left"></i>
        <span>Quay lại danh sách</span>
    </a>

    <!-- Post Content -->
    <div class="bg-white rounded-xl shadow-sm p-8">
        <div class="flex items-start justify-between mb-6">
            <div class="flex-1">
                <h1 class="text-3xl font-bold text-gray-800 mb-4"><?php echo e($post->title); ?></h1>
                
                <div class="flex items-center gap-4 text-sm text-gray-600">
                    <div class="flex items-center gap-2">
                        <img src="<?php echo e($post->user->profile_photo ? asset('storage/' . $post->user->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode($post->user->name)); ?>" 
                             alt="<?php echo e($post->user->name); ?>" 
                             class="w-8 h-8 rounded-full">
                        <span><?php echo e($post->user->name); ?></span>
                    </div>
                    <span>•</span>
                    <span><?php echo e($post->created_at->format('d/m/Y H:i')); ?></span>
                    <?php if($post->category): ?>
                        <span>•</span>
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded-full">
                            <?php echo e($post->category); ?>

                        </span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="<?php echo e(route('posts.show', $post->slug)); ?>" target="_blank" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                    <i class="fas fa-external-link-alt mr-2"></i>Xem trên trang
                </a>
                <form method="POST" action="<?php echo e(route('admin.posts.destroy', $post)); ?>" 
                      onsubmit="return confirm('Bạn có chắc muốn xóa bài viết này?')">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                        <i class="fas fa-trash mr-2"></i>Xóa
                    </button>
                </form>
            </div>
        </div>

        <?php if($post->image): ?>
            <img src="<?php echo e(asset('storage/' . $post->image)); ?>" alt="<?php echo e($post->title); ?>" class="w-full rounded-lg mb-6">
        <?php endif; ?>

        <div class="prose max-w-none">
            <?php echo nl2br(e($post->content)); ?>

        </div>

        <?php if($post->tags && $post->tags->count() > 0): ?>
            <div class="flex flex-wrap gap-2 mt-6 pt-6 border-t">
                <?php $__currentLoopData = $post->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <span class="px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-full">
                        #<?php echo e($tag->name); ?>

                    </span>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>

        <div class="flex items-center gap-6 mt-6 pt-6 border-t text-gray-600">
            <span><i class="fas fa-heart text-red-500 mr-2"></i><?php echo e($post->likes_count); ?> lượt thích</span>
            <span><i class="fas fa-comments text-blue-500 mr-2"></i><?php echo e($post->comments_count); ?> bình luận</span>
        </div>
    </div>

    <!-- Comments -->
    <?php if($post->comments && $post->comments->count() > 0): ?>
        <div class="bg-white rounded-xl shadow-sm p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Bình luận (<?php echo e($post->comments_count); ?>)</h2>
            
            <div class="space-y-4">
                <?php $__currentLoopData = $post->comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="border-l-2 border-gray-200 pl-4 py-2">
                        <div class="flex items-start gap-3">
                            <img src="<?php echo e($comment->user->profile_photo ? asset('storage/' . $comment->user->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name)); ?>" 
                                 alt="<?php echo e($comment->user->name); ?>" 
                                 class="w-10 h-10 rounded-full">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="font-medium text-gray-800"><?php echo e($comment->user->name); ?></span>
                                    <span class="text-sm text-gray-500"><?php echo e($comment->created_at->diffForHumans()); ?></span>
                                </div>
                                <?php
                                    $content = $comment->content;
                                    $isImageUrl = preg_match('/^https?:\/\/.*(giphy\.com|\.gif|\.jpg|\.jpeg|\.png|\.webp)/i', $content);
                                ?>
                                
                                <?php if($isImageUrl): ?>
                                    <img src="<?php echo e($content); ?>" alt="GIF" class="mt-2 max-w-sm rounded-lg">
                                <?php else: ?>
                                    <p class="text-gray-700"><?php echo e($content); ?></p>
                                <?php endif; ?>
                                
                                <?php if($comment->image): ?>
                                    <img src="<?php echo e(asset('storage/' . $comment->image)); ?>" alt="Comment image" class="mt-2 max-w-sm rounded-lg">
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\AnimeTalk\resources\views/admin/posts/show.blade.php ENDPATH**/ ?>