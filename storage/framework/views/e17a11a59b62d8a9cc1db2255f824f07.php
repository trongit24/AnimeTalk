

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
                    <select name="type">
                        <option value="all" <?php echo e($type == 'all' ? 'selected' : ''); ?>>All</option>
                        <option value="posts" <?php echo e($type == 'posts' ? 'selected' : ''); ?>>Posts</option>
                        <option value="forums" <?php echo e($type == 'forums' ? 'selected' : ''); ?>>Forums</option>
                    </select>
                    <button type="submit" class="btn-primary">Search</button>
                </div>
                
                <div class="search-tags">
                    <label>Filter by tag:</label>
                    <div class="tags-filter">
                        <a href="<?php echo e(route('search', array_filter(['q' => $query, 'type' => $type]))); ?>" 
                           class="filter-tag <?php echo e(!$tag ? 'active' : ''); ?>">All</a>
                        <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('search', array_filter(['q' => $query, 'type' => $type, 'tag' => $t->slug]))); ?>" 
                               class="filter-tag <?php echo e($tag == $t->slug ? 'active' : ''); ?>"
                               style="--tag-color: <?php echo e($t->color); ?>">
                                <?php echo e($t->name); ?>

                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </form>
        </div>

        <!-- Results -->
        <?php if($type === 'posts' || $type === 'all'): ?>
            <?php if($posts->count() > 0): ?>
                <div class="search-section">
                    <h2>Posts (<?php echo e($posts->total()); ?>)</h2>
                    <div class="posts-grid">
                        <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <article class="post-card">
                                <?php if($post->image): ?>
                                    <div class="post-image">
                                        <img src="<?php echo e(asset('storage/' . $post->image)); ?>" alt="<?php echo e($post->title); ?>">
                                    </div>
                                <?php else: ?>
                                    <div class="post-image-placeholder">
                                        <img src="https://placehold.co/400x300/E8D8F8/8B7FD8?text=Post" alt="<?php echo e($post->title); ?>">
                                    </div>
                                <?php endif; ?>
                                
                                <div class="post-content">
                                    <div class="post-tags">
                                        <?php $__currentLoopData = $post->tags->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $postTag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="tag-badge" style="background-color: <?php echo e($postTag->color); ?>20; color: <?php echo e($postTag->color); ?>">
                                                <?php echo e($postTag->name); ?>

                                            </span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                    
                                    <h3 class="post-title">
                                        <a href="<?php echo e(route('posts.show', $post->slug)); ?>"><?php echo e($post->title); ?></a>
                                    </h3>
                                    
                                    <div class="post-meta">
                                        <div class="post-author">
                                            <div class="author-avatar"><?php echo e(substr($post->user->name, 0, 1)); ?></div>
                                            <span><?php echo e($post->user->name); ?></span>
                                        </div>
                                        <div class="post-stats">
                                            <span>👁️ <?php echo e($post->views); ?></span>
                                            <span>💬 <?php echo e($post->comments->count()); ?></span>
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
            <?php endif; ?>
        <?php endif; ?>

        <?php if($type === 'forums' || $type === 'all'): ?>
            <?php if($forums->count() > 0): ?>
                <div class="search-section">
                    <h2>Forums (<?php echo e($forums->count()); ?>)</h2>
                    <div class="forums-grid">
                        <?php $__currentLoopData = $forums; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $forum): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('community.show', $forum->slug)); ?>" class="forum-card">
                                <div class="forum-icon"><?php echo e($forum->icon ?? '💬'); ?></div>
                                <div class="forum-info">
                                    <h3><?php echo e($forum->name); ?></h3>
                                    <p><?php echo e($forum->description); ?></p>
                                    <div class="forum-tags">
                                        <?php $__currentLoopData = $forum->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $forumTag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="tag-badge" style="background-color: <?php echo e($forumTag->color); ?>20; color: <?php echo e($forumTag->color); ?>">
                                                <?php echo e($forumTag->name); ?>

                                            </span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                                <div class="forum-stats">
                                    <div class="stat">
                                        <span class="stat-value"><?php echo e($forum->posts_count); ?></span>
                                        <span class="stat-label">Posts</span>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <?php if(($type === 'posts' && $posts->count() === 0) || ($type === 'forums' && $forums->count() === 0) || ($type === 'all' && $posts->count() === 0 && $forums->count() === 0)): ?>
            <div class="empty-state">
                <p>No results found. Try different keywords or tags.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\AnimeTalk\resources\views/search/index.blade.php ENDPATH**/ ?>