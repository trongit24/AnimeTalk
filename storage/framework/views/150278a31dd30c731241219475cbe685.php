

<?php $__env->startSection('title', 'Communities - AnimeTalk'); ?>

<?php $__env->startPush('styles'); ?>
<style>
.communities-page {
    min-height: 100vh;
}

.page-header h1 {
    font-size: 2.5rem;
    font-weight: 800;
    background: linear-gradient(135deg, #4A90E2, #9B59B6);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.card {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.6);
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.card:hover {
    background: rgba(255, 255, 255, 0.95);
    box-shadow: 0 12px 48px rgba(0, 0, 0, 0.15);
    transform: translateY(-3px);
}

.btn-primary {
    background: linear-gradient(135deg, #4A90E2, #9B59B6);
    border: none;
    border-radius: 50px;
    padding: 12px 24px;
    font-weight: 600;
    box-shadow: 0 4px 15px rgba(74, 144, 226, 0.4);
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(74, 144, 226, 0.6);
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="communities-page" style="opacity: 1 !important; visibility: visible !important;">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 2rem; position: relative; z-index: 100; opacity: 1 !important; visibility: visible !important;">
        <!-- Header -->
        <div class="page-header mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1>Communities</h1>
                    <p class="text-secondary">Discover and join anime communities</p>
                </div>
                <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('communities.create')); ?>" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Start a Community
                </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Search & Filter -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="<?php echo e(route('communities.index')); ?>" method="GET">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="text" name="search" placeholder="Search communities..." value="<?php echo e(request('search')); ?>" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <select name="category" class="form-select">
                                <option value="all">All Categories</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($cat); ?>" <?php echo e(request('category') == $cat ? 'selected' : ''); ?>><?php echo e($cat); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Communities Grid -->
        <div class="row g-4">
            <?php $__empty_1 = true; $__currentLoopData = $communities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $community): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-md-6 col-lg-4">
                <a href="<?php echo e(route('communities.show', $community->slug)); ?>" style="text-decoration: none; color: inherit; display: block;">
                    <div class="card" style="background: white !important; border-radius: 12px !important; overflow: hidden !important; box-shadow: 0 2px 8px rgba(0,0,0,0.1) !important; transition: all 0.3s !important;">
                        <!-- Banner -->
                        <?php if($community->banner): ?>
                        <div style="width: 100%; height: 120px; overflow: hidden;">
                            <img src="<?php echo e(asset('storage/' . $community->banner)); ?>" alt="<?php echo e($community->name); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <?php else: ?>
                        <div style="width: 100%; height: 120px; background: linear-gradient(135deg, #5BA3D0, #9B7EDE);"></div>
                        <?php endif; ?>

                        <div style="padding: 1.25rem;">
                            <!-- Icon & Name -->
                            <div style="display: flex; align-items: flex-start; gap: 1rem; margin-bottom: 1rem;">
                                <?php if($community->icon): ?>
                                <img src="<?php echo e(asset('storage/' . $community->icon)); ?>" alt="<?php echo e($community->name); ?>" 
                                     style="width: 60px; height: 60px; border-radius: 12px; border: 3px solid white; margin-top: -50px; background: white; object-fit: cover;">
                                <?php else: ?>
                                <div style="width: 60px; height: 60px; border-radius: 12px; border: 3px solid white; margin-top: -50px; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.5rem;">
                                    <?php echo e(strtoupper(substr($community->name, 0, 1))); ?>

                                </div>
                                <?php endif; ?>
                                
                                <div style="flex: 1;">
                                    <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0.25rem; color: #1c1c1c !important;">
                                        <?php echo e($community->name); ?>

                                    </h3>
                                    <p style="font-size: 0.875rem; color: #666 !important; margin-bottom: 0;"><?php echo e($community->members_count); ?> members</p>
                                </div>
                            </div>

                            <!-- Description -->
                            <p style="color: #555 !important; font-size: 0.9rem; line-height: 1.5; margin-bottom: 1rem;">
                                <?php echo e(Str::limit($community->description, 100)); ?>

                            </p>

                            <!-- Category Badge -->
                            <div style="margin-bottom: 1rem;">
                                <span style="background: rgba(91, 163, 208, 0.1); color: #5BA3D0; padding: 0.25rem 0.75rem; border-radius: 12px; font-size: 0.85rem; font-weight: 600;">
                                    <?php echo e($community->category); ?>

                                </span>
                            </div>

                            <!-- Action Button -->
                            <?php if(auth()->guard()->check()): ?>
                                <?php if($community->isMember(auth()->user())): ?>
                                <div style="display: block; text-align: center; padding: 0.625rem; background: #f0f0f0; color: #333; border-radius: 8px; font-weight: 600; font-size: 0.9rem;">
                                    <i class="bi bi-check-circle"></i> Joined
                                </div>
                                <?php else: ?>
                                <div onclick="event.preventDefault(); event.stopPropagation(); this.querySelector('form').submit();" style="display: block;">
                                    <form action="<?php echo e(route('communities.join', $community)); ?>" method="POST" style="margin: 0;">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" style="width: 100%; padding: 0.625rem; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 0.9rem;">
                                            <i class="bi bi-plus-circle"></i> Join
                                        </button>
                                    </form>
                                </div>
                                <?php endif; ?>
                            <?php else: ?>
                            <div style="display: block; text-align: center; padding: 0.625rem; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; border-radius: 8px; font-weight: 600; font-size: 0.9rem;">
                                <i class="bi bi-plus-circle"></i> Join
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div style="grid-column: 1 / -1; text-align: center; padding: 3rem; color: #999;">
                <i class="bi bi-people" style="font-size: 3rem; display: block; margin-bottom: 1rem;"></i>
                <p>No communities found</p>
                <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('communities.create')); ?>" style="color: #5BA3D0; text-decoration: underline;">Create the first one!</a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <div style="margin-top: 2rem;">
            <?php echo e($communities->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\AnimeTalk\resources\views/communities/index.blade.php ENDPATH**/ ?>