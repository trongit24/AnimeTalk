

<?php $__env->startSection('title', $community->name . ' - AnimeTalk'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/communities.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="community-detail-page">
    <!-- Banner Section -->
    <div class="community-banner">
        <?php if($community->banner): ?>
        <img src="<?php echo e(asset('storage/' . $community->banner)); ?>" alt="<?php echo e($community->name); ?>" style="width: 100%; height: 100%; object-fit: cover;">
        <?php else: ?>
        <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #5BA3D0, #9B7EDE);"></div>
        <?php endif; ?>
    </div>

    <!-- Community Header -->
    <div style="background: white; border-bottom: 1px solid #e0e0e0;">
        <div class="community-header-container">
            <div class="community-header-content">
                <!-- Community Icon -->
                <?php if($community->icon): ?>
                <img src="<?php echo e(asset('storage/' . $community->icon)); ?>" alt="<?php echo e($community->name); ?>" class="community-icon">
                <?php else: ?>
                <div class="community-icon-placeholder">
                    <?php echo e(strtoupper(substr($community->name, 0, 1))); ?>

                </div>
                <?php endif; ?>

                <!-- Community Info -->
                <div style="flex: 1;">
                    <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 0.5rem;"><?php echo e($community->name); ?></h1>
                    <div style="display: flex; align-items: center; gap: 1rem; color: #666; font-size: 0.9rem; margin-bottom: 0.75rem;">
                        <span><i class="bi bi-people"></i> <?php echo e($community->members_count); ?> members</span>
                        <span>•</span>
                        <span style="background: rgba(91, 163, 208, 0.1); color: #5BA3D0; padding: 0.25rem 0.75rem; border-radius: 12px; font-weight: 600;">
                            <?php echo e($community->category); ?>

                        </span>
                        <?php if($community->is_private): ?>
                        <span style="background: rgba(155, 126, 222, 0.1); color: #9B7EDE; padding: 0.25rem 0.75rem; border-radius: 12px; font-weight: 600;">
                            <i class="bi bi-lock"></i> Private
                        </span>
                        <?php endif; ?>
                    </div>
                    <p style="color: #555; line-height: 1.6;"><?php echo e($community->description); ?></p>
                </div>

                <!-- Action Button -->
                <?php if(auth()->guard()->check()): ?>
                    <?php if($community->isOwner(auth()->user())): ?>
                    <div style="margin-top: 1rem; display: flex; gap: 0.75rem;">
                        <span style="display: inline-block; padding: 0.75rem 1.5rem; background: rgba(91, 163, 208, 0.1); color: #5BA3D0; border-radius: 8px; font-weight: 600;">
                            <i class="bi bi-star-fill"></i> Owner
                        </span>
                        <a href="<?php echo e(route('communities.edit', $community->slug)); ?>" 
                           style="display: inline-block; padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; border-radius: 8px; text-decoration: none; font-weight: 600;">
                            <i class="bi bi-pencil"></i> Edit Community
                        </a>
                    </div>
                    <?php elseif($community->isMember(auth()->user())): ?>
                    <form action="<?php echo e(route('communities.leave', $community)); ?>" method="POST" style="margin-top: 1rem;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" onclick="return confirm('Are you sure you want to leave this community?')"
                                style="padding: 0.75rem 1.5rem; background: #f0f0f0; color: #333; border: 1px solid #e0e0e0; border-radius: 8px; font-weight: 600; cursor: pointer;">
                            <i class="bi bi-box-arrow-right"></i> Leave
                        </button>
                    </form>
                    <?php else: ?>
                    <form action="<?php echo e(route('communities.join', $community)); ?>" method="POST" style="margin-top: 1rem;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" 
                                style="padding: 0.75rem 2rem; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                            <i class="bi bi-plus-circle"></i> Join
                        </button>
                    </form>
                    <?php endif; ?>
                <?php else: ?>
                <a href="<?php echo e(route('login')); ?>" style="display: inline-block; margin-top: 1rem; padding: 0.75rem 2rem; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; border-radius: 8px; text-decoration: none; font-weight: 600;">
                    <i class="bi bi-plus-circle"></i> Join
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="community-main-content">
        <div class="community-content-grid">
            <!-- Posts Section -->
            <div>
                <div style="background: white !important; border-radius: 12px; padding: 1.5rem; border: 1px solid #e0e0e0; margin-bottom: 1.5rem; opacity: 1 !important; visibility: visible !important;">
                    <h2 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1rem; color: #1c1c1c !important;">Posts</h2>
                    <p style="color: #999 !important; text-align: center; padding: 2rem;">
                        Community posts feature coming soon!
                    </p>
                </div>
            </div>

            <!-- Sidebar -->
            <div>
                <!-- Recent Activities -->
                <div style="background: white; border-radius: 12px; padding: 1.5rem; border: 1px solid #e0e0e0; margin-bottom: 1.5rem;">
                    <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1rem;">
                        <i class="bi bi-activity"></i> Recent Activities
                    </h3>
                    <div style="max-height: 400px; overflow-y: auto;">
                        <?php $__empty_1 = true; $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div style="display: flex; align-items: start; gap: 0.75rem; padding: 0.75rem 0; border-bottom: 1px solid #f0f0f0;">
                            <?php if($activity->user && $activity->user->profile_photo): ?>
                            <img src="<?php echo e(asset('storage/' . $activity->user->profile_photo)); ?>" alt="<?php echo e($activity->user->name); ?>" 
                                 style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; flex-shrink: 0;">
                            <?php elseif($activity->user): ?>
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.85rem; flex-shrink: 0;">
                                <?php echo e(strtoupper(substr($activity->user->name, 0, 1))); ?>

                            </div>
                            <?php else: ?>
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: #ccc; flex-shrink: 0;"></div>
                            <?php endif; ?>
                            
                            <div style="flex: 1; min-width: 0;">
                                <div style="font-size: 0.85rem; color: #333; line-height: 1.4;">
                                    <?php if($activity->type === 'joined'): ?>
                                        <strong><?php echo e($activity->user->name ?? 'User'); ?></strong> <span style="color: #28a745;">joined</span> the community
                                    <?php elseif($activity->type === 'left'): ?>
                                        <strong><?php echo e($activity->user->name ?? 'User'); ?></strong> <span style="color: #dc3545;">left</span> the community
                                    <?php elseif($activity->type === 'created'): ?>
                                        <strong><?php echo e($activity->user->name ?? 'User'); ?></strong> <span style="color: #5BA3D0;">created</span> the community
                                    <?php elseif($activity->type === 'posted'): ?>
                                        <strong><?php echo e($activity->user->name ?? 'User'); ?></strong> posted in the community
                                    <?php else: ?>
                                        <?php echo e($activity->description); ?>

                                    <?php endif; ?>
                                </div>
                                <div style="font-size: 0.75rem; color: #999; margin-top: 0.25rem;">
                                    <?php echo e($activity->created_at->diffForHumans()); ?>

                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p style="color: #999; text-align: center; padding: 1rem;">No activities yet</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- About -->
                <div style="background: white; border-radius: 12px; padding: 1.5rem; border: 1px solid #e0e0e0; margin-bottom: 1.5rem;">
                    <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1rem;">About Community</h3>
                    <div style="color: #555; line-height: 1.6; margin-bottom: 1rem;">
                        <?php echo e($community->description); ?>

                    </div>
                    <div style="padding-top: 1rem; border-top: 1px solid #e0e0e0;">
                        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                            <i class="bi bi-calendar3" style="color: #5BA3D0;"></i>
                            <span style="color: #666; font-size: 0.9rem;">Created <?php echo e($community->created_at->diffForHumans()); ?></span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <i class="bi bi-people" style="color: #5BA3D0;"></i>
                            <span style="color: #666; font-size: 0.9rem;"><?php echo e($community->members_count); ?> members</span>
                        </div>
                    </div>
                </div>

                <!-- Members -->
                <div style="background: white; border-radius: 12px; padding: 1.5rem; border: 1px solid #e0e0e0;">
                    <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1rem;">
                        Members (<?php echo e($community->members()->count()); ?>)
                    </h3>
                    <div style="max-height: 400px; overflow-y: auto;">
                        <?php $__empty_1 = true; $__currentLoopData = $community->members()->latest('community_members.created_at')->take(20)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 0; border-bottom: 1px solid #f0f0f0;">
                            <?php if($member->profile_photo): ?>
                            <img src="<?php echo e(asset('storage/' . $member->profile_photo)); ?>" alt="<?php echo e($member->name); ?>" 
                                 style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                            <?php else: ?>
                            <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700;">
                                <?php echo e(strtoupper(substr($member->name, 0, 1))); ?>

                            </div>
                            <?php endif; ?>
                            
                            <div style="flex: 1; min-width: 0;">
                                <div style="font-weight: 600; font-size: 0.9rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    <?php echo e($member->name); ?>

                                </div>
                                <div style="font-size: 0.8rem; color: #666;">
                                    <?php echo e(ucfirst($member->pivot->role)); ?>

                                </div>
                            </div>

                            <?php if(auth()->check() && $community->isOwner(auth()->user()) && $member->uid !== auth()->user()->uid): ?>
                            <form action="<?php echo e(route('communities.removeMember', [$community, $member->uid])); ?>" method="POST" onsubmit="return confirm('Remove this member?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" style="background: none; border: none; color: #ff4444; cursor: pointer; padding: 0.25rem;">
                                    <i class="bi bi-x-circle"></i>
                                </button>
                            </form>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p style="color: #999; text-align: center; padding: 1rem;">No members yet</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\AnimeTalk\resources\views/communities/show.blade.php ENDPATH**/ ?>