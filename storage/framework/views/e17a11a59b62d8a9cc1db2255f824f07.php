

<?php $__env->startSection('title', 'Search - AnimeTalk'); ?>

<?php $__env->startPush('styles'); ?>
<style>
.search-page,
.search-page *,
.post-card,
.post-card *,
.search-section,
.search-section * {
    opacity: 1 !important;
    visibility: visible !important;
}
.post-card {
    background: white !important;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="search-page" style="opacity: 1 !important; visibility: visible !important;">
    <div class="container">
        <!-- Search Header -->
        <div class="search-header">
            <h1>Search Results</h1>
            <?php if($query): ?>
                <p>Showing results for: <strong>"<?php echo e($query); ?>"</strong></p>
            <?php endif; ?>
        </div>

        <!-- Search Form -->
        <div class="search-form-advanced">
            <form action="<?php echo e(route('search')); ?>" method="GET">
                <div class="search-inputs">
                    <input type="text" name="q" placeholder="Search posts and forums..." value="<?php echo e($query); ?>">
                    <button type="submit" class="btn-primary">Search</button>
                </div>
            </form>
        </div>

        <!-- Results -->
        <?php if($posts->count() > 0): ?>
            <div class="search-section">
                <h2>Posts (<?php echo e($posts->total()); ?>)</h2>
                <div class="posts-grid">
                    <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <article class="post-card">
                            <div class="post-content">
                                <h3 class="post-title">
                                    <a href="<?php echo e(route('posts.show', $post->slug)); ?>"><?php echo e($post->title); ?></a>
                                </h3>
                                
                                <div class="post-meta">
                                    <div class="post-author">
                                        <div class="author-avatar"><?php echo e(substr($post->user->name, 0, 1)); ?></div>
                                        <span><?php echo e($post->user->name); ?></span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                
                <?php if($posts->hasPages()): ?>
                    <div class="pagination">
                        <?php echo e($posts->appends(request()->except('page'))->links()); ?>

                    </div>
                <?php endif; ?>
            </div>
        <?php elseif($query): ?>
            <div class="empty-state">
                <div style="text-align: center; padding: 3rem 1rem;">
                    <i class="bi bi-search" style="font-size: 4rem; color: #ccc; display: block; margin-bottom: 1rem;"></i>
                    <h3 style="color: #666; margin-bottom: 0.5rem;">Không tìm thấy bài viết</h3>
                    <p style="color: #999;">Thử tìm kiếm với từ khóa khác</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\AnimeTalk\resources\views/search/index.blade.php ENDPATH**/ ?>