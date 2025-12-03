

<?php $__env->startSection('title', $user->name . ' - AnimeTalk'); ?>

<?php $__env->startPush('styles'); ?>
<style>
/* Shinkai-style Profile Page */
.yn-profile-page {
    min-height: 100vh;
}

.yn-cover-photo {
    height: 350px;
    background: linear-gradient(180deg, #667eea 0%, #764ba2 50%, #FF6B9D 100%);
    background-size: cover;
    background-position: center;
    position: relative;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
    overflow: visible;
}

.yn-cover-photo::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at 30% 50%, rgba(255,255,255,0.2) 0%, transparent 70%);
    animation: lightMove 20s ease-in-out infinite;
}

@keyframes lightMove {
    0%, 100% { transform: translateX(0); }
    50% { transform: translateX(100px); }
}

.yn-avatar-container {
    position: absolute;
    bottom: -80px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 1000;
}

.yn-profile-avatar {
    width: 160px;
    height: 160px;
    border-radius: 50%;
    border: 6px solid white;
    box-shadow: 0 12px 48px rgba(0, 0, 0, 0.2);
    object-fit: cover;
    background: linear-gradient(135deg, #4A90E2, #9B59B6);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3.5rem;
    font-weight: 700;
    color: white;
}

.yn-profile-header {
    text-align: center;
    padding: 100px 0 30px 0;
}

.yn-profile-header h1 {
    font-size: 2.5rem;
    font-weight: 800;
    background: linear-gradient(135deg, #4A90E2, #9B59B6);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 1rem;
}

.yn-bio {
    font-size: 1.1rem;
    color: #2C3E50;
    max-width: 600px;
    margin: 0 auto 2rem auto;
    line-height: 1.6;
}

.yn-profile-actions {
    margin-top: 1.5rem;
}

.yn-profile-actions .btn {
    background: linear-gradient(135deg, #4A90E2, #9B59B6);
    border: none;
    padding: 12px 30px;
    border-radius: 50px;
    font-weight: 600;
    box-shadow: 0 4px 15px rgba(74, 144, 226, 0.4);
    transition: all 0.3s ease;
}

.yn-profile-actions .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(74, 144, 226, 0.6);
}

.yn-tabs {
    display: flex;
    gap: 1rem;
    padding: 1rem;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.yn-tab {
    background: transparent;
    border: none;
    padding: 12px 24px;
    border-radius: 12px;
    font-weight: 600;
    color: #2C3E50;
    cursor: pointer;
    transition: all 0.3s ease;
}

.yn-tab.active {
    background: linear-gradient(135deg, #4A90E2, #9B59B6);
    color: white;
    box-shadow: 0 4px 15px rgba(74, 144, 226, 0.4);
}

.yn-posts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-top: 0;
    max-width: 100%;
}

.yn-post-item {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.6);
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.yn-post-item:hover {
    background: rgba(255, 255, 255, 0.95);
    box-shadow: 0 12px 48px rgba(0, 0, 0, 0.15);
    transform: translateY(-5px);
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="yn-profile-page" style="opacity: 1 !important; visibility: visible !important;">
    <!-- Cover Photo -->
    <div class="yn-cover-photo" <?php if($user->cover_photo): ?> style="background-image: url('<?php echo e(asset('storage/' . $user->cover_photo)); ?>');" <?php endif; ?>>
        <div class="yn-avatar-container">
            <?php if($user->profile_photo): ?>
                <img src="<?php echo e(asset('storage/' . $user->profile_photo)); ?>" alt="<?php echo e($user->name); ?>" class="yn-profile-avatar">
            <?php else: ?>
                <div class="yn-profile-avatar yn-avatar-placeholder">
                    <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Profile Info -->
    <div class="container" style="max-width: 940px; margin: 0 auto; padding: 0 1rem; position: relative; z-index: 100; opacity: 1 !important; visibility: visible !important;">
        <div class="yn-profile-header">
            <h1><?php echo e($user->name); ?></h1>
            <?php if($user->bio): ?>
                <p class="yn-bio"><?php echo e($user->bio); ?></p>
            <?php endif; ?>
            
            <?php if(Auth::user()->uid === $user->uid): ?>
                <div class="yn-profile-actions">
                    <a href="<?php echo e(route('profile.edit')); ?>" class="btn btn-primary">
                        <i class="bi bi-pencil"></i> Chỉnh sửa trang cá nhân
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Navigation Tabs -->
        <div class="card mb-3" style="background: white !important; box-shadow: 0 2px 8px rgba(0,0,0,0.1) !important;">
            <div class="card-body p-0">
                <div class="yn-tabs">
                    <button class="yn-tab active" onclick="showTab('posts')">
                        <i class="bi bi-file-text"></i> Bài viết
                    </button>
                    <button class="yn-tab" onclick="showTab('friends')">
                        <i class="bi bi-people"></i> Bạn bè
                    </button>
                    <button class="yn-tab" onclick="showTab('communities')">
                        <i class="bi bi-grid-3x3"></i> Cộng đồng
                    </button>
                    <button class="yn-tab" onclick="showTab('events')">
                        <i class="bi bi-calendar-event"></i> Sự kiện
                    </button>
                </div>
            </div>
        </div>

        <script>
        function showTab(tab) {
            // Update active tab
            document.querySelectorAll('.yn-tab').forEach(btn => btn.classList.remove('active'));
            event.target.closest('.yn-tab').classList.add('active');
            
            // Hide all content
            document.querySelectorAll('.tab-content').forEach(content => content.style.display = 'none');
            
            // Show selected content
            document.getElementById(tab + '-content').style.display = 'block';
        }
        </script>

        <!-- Posts Grid -->
        <div id="posts-content" class="tab-content" style="margin-top: 1.5rem !important; display: block;">
            <div class="yn-posts-grid">
            <?php $__empty_1 = true; $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <article class="card" style="background: white !important; padding: 1.5rem !important; border-radius: 16px !important; box-shadow: 0 2px 12px rgba(0,0,0,0.08) !important; transition: all 0.3s !important; border: 1px solid rgba(0,0,0,0.05) !important;">
                <!-- Post Header -->
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
                    <?php if($user->profile_photo): ?>
                        <img src="<?php echo e(asset('storage/' . $user->profile_photo)); ?>" alt="<?php echo e($user->name); ?>" 
                             style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                    <?php else: ?>
                        <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; display: flex; align-items: center; justify-content: center; font-weight: 600;">
                            <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

                        </div>
                    <?php endif; ?>
                    <div style="flex: 1;">
                        <div style="font-weight: 600; color: #1c1c1c;"><?php echo e($user->name); ?></div>
                        <div style="color: #666; font-size: 0.875rem;"><?php echo e($post->created_at->diffForHumans()); ?></div>
                    </div>
                </div>

                <!-- Post Content -->
                <a href="<?php echo e(route('posts.show', $post->slug)); ?>" style="text-decoration: none; color: inherit; display: block;">
                    <?php if($post->title && $post->title != $post->content): ?>
                    <h3 style="font-size: 1.25rem; margin-bottom: 0.75rem; color: #1c1c1c !important; font-weight: 700;"><?php echo e($post->title); ?></h3>
                    <?php endif; ?>
                    <p style="color: #333 !important; line-height: 1.6; margin-bottom: 1rem; font-size: 1rem;"><?php echo e(Str::limit($post->content, 300)); ?></p>
                    
                    <?php if($post->image): ?>
                        <img src="<?php echo e(asset('storage/' . $post->image)); ?>" alt="<?php echo e($post->title); ?>" 
                             style="width: 100%; height: auto; object-fit: contain; border-radius: 12px; margin-bottom: 1rem;">
                    <?php endif; ?>

                    <?php if($post->video): ?>
                        <video controls style="width: 100%; max-height: 400px; border-radius: 8px; margin-bottom: 1rem;">
                            <source src="<?php echo e(asset('storage/' . $post->video)); ?>" type="video/mp4">
                        </video>
                    <?php endif; ?>
                </a>

                <!-- Tags -->
                <?php if($post->tags->count() > 0): ?>
                <div style="display: flex; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 1rem;">
                    <?php $__currentLoopData = $post->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <span style="background: <?php echo e($tag->color); ?>15; color: <?php echo e($tag->color); ?>; padding: 0.25rem 0.75rem; border-radius: 12px; font-size: 0.875rem;">
                        <?php echo e($tag->name); ?>

                    </span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>

                <!-- Tags -->
                <?php if($post->tags->count() > 0): ?>
                <div style="display: flex; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 1rem;">
                    <?php $__currentLoopData = $post->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <span style="background: <?php echo e($tag->color); ?>20; color: <?php echo e($tag->color); ?>; padding: 0.25rem 0.75rem; border-radius: 12px; font-size: 0.875rem; font-weight: 600;">
                        #<?php echo e($tag->name); ?>

                    </span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>

                <!-- Post Stats -->
                <div style="display: flex; gap: 1.5rem; padding-top: 0.75rem; border-top: 1px solid #e4e6eb; color: #666; font-size: 0.9rem;">
                    <span><i class="bi bi-heart-fill" style="color: #FF6B6B;"></i> <?php echo e($post->likes()->count()); ?> Likes</span>
                    <span><i class="bi bi-chat-fill" style="color: #5BA3D0;"></i> <?php echo e($post->comments()->count()); ?> Comments</span>
                </div>
            </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div style="background: white; border-radius: 8px; box-shadow: 0 1px 2px rgba(0,0,0,0.1); padding: 3rem; text-align: center;">
                <i class="bi bi-inbox" style="font-size: 3rem; color: #999; display: block; margin-bottom: 1rem;"></i>
                <p style="color: #666;">Chưa có bài viết nào</p>
            </div>
            <?php endif; ?>
            </div>

            <!-- Pagination -->
            <?php if($posts->hasPages()): ?>
            <div style="margin-top: 2rem;">
                <?php echo e($posts->links()); ?>

            </div>
            <?php endif; ?>
        </div>

        <!-- Friends Tab Content -->
        <div id="friends-content" class="tab-content" style="display: none; margin-top: 1.5rem;">
            <?php if($friends->count() > 0): ?>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem;">
                <?php $__currentLoopData = $friends; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $friend): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('profile.show', $friend->uid)); ?>" style="text-decoration: none; color: inherit;">
                    <div style="background: white; border-radius: 12px; padding: 1.5rem; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: all 0.3s; height: 100%; display: flex; flex-direction: column; align-items: center; min-height: 180px;">
                        <?php if($friend->profile_photo): ?>
                        <img src="<?php echo e(asset('storage/' . $friend->profile_photo)); ?>" alt="<?php echo e($friend->name); ?>" 
                             style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; margin-bottom: 1rem; flex-shrink: 0;">
                        <?php else: ?>
                        <div style="width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 2rem; margin-bottom: 1rem; flex-shrink: 0;">
                            <?php echo e(strtoupper(substr($friend->name, 0, 1))); ?>

                        </div>
                        <?php endif; ?>
                        <h4 style="font-size: 1rem; font-weight: 600; color: #1c1c1c; margin-bottom: 0.25rem;"><?php echo e($friend->name); ?></h4>
                        <?php if($friend->bio): ?>
                        <p style="font-size: 0.875rem; color: #666; line-height: 1.4; word-break: break-word; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;"><?php echo e($friend->bio); ?></p>
                        <?php endif; ?>
                    </div>
                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php else: ?>
            <div style="background: white; border-radius: 16px; padding: 3rem; text-align: center; box-shadow: 0 2px 12px rgba(0,0,0,0.08);">
                <i class="bi bi-people" style="font-size: 3rem; color: #999; display: block; margin-bottom: 1rem;"></i>
                <p style="color: #666;">Chưa có bạn bè</p>
            </div>
            <?php endif; ?>
        </div>

        <!-- Communities Tab Content -->
        <div id="communities-content" class="tab-content" style="display: none; margin-top: 1.5rem;">
            <?php if($communities->count() > 0): ?>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;">
                <?php $__currentLoopData = $communities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $community): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('communities.show', $community->slug)); ?>" style="text-decoration: none; color: inherit;">
                    <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: all 0.3s;">
                        <?php if($community->banner): ?>
                        <div style="width: 100%; height: 100px; background: url('<?php echo e(asset('storage/' . $community->banner)); ?>') center/cover;"></div>
                        <?php else: ?>
                        <div style="width: 100%; height: 100px; background: linear-gradient(135deg, #5BA3D0, #9B7EDE);"></div>
                        <?php endif; ?>
                        <div style="padding: 1rem;">
                            <h4 style="font-size: 1.1rem; font-weight: 700; color: #1c1c1c; margin-bottom: 0.5rem;"><?php echo e($community->name); ?></h4>
                            <p style="font-size: 0.875rem; color: #666; margin-bottom: 0.5rem;"><?php echo e(Str::limit($community->description, 80)); ?></p>
                            <div style="display: flex; align-items: center; gap: 0.5rem; color: #5BA3D0; font-size: 0.875rem;">
                                <i class="bi bi-people-fill"></i>
                                <span><?php echo e($community->members_count); ?> thành viên</span>
                            </div>
                        </div>
                    </div>
                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php else: ?>
            <div style="background: white; border-radius: 16px; padding: 3rem; text-align: center; box-shadow: 0 2px 12px rgba(0,0,0,0.08);">
                <i class="bi bi-grid-3x3" style="font-size: 3rem; color: #999; display: block; margin-bottom: 1rem;"></i>
                <p style="color: #666;">Chưa tham gia cộng đồng nào</p>
            </div>
            <?php endif; ?>
        </div>

        <!-- Events Tab Content -->
        <div id="events-content" class="tab-content" style="display: none; margin-top: 1.5rem;">
            <?php if($events->count() > 0): ?>
            <div style="display: grid; grid-template-columns: 1fr; gap: 1rem;">
                <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('events.show', $event->slug)); ?>" style="text-decoration: none; color: inherit;">
                    <div style="background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.08); display: flex; gap: 1.5rem; transition: all 0.3s;">
                        <div style="flex-shrink: 0; text-align: center; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; border-radius: 12px; padding: 1rem; width: 80px;">
                            <div style="font-size: 1.5rem; font-weight: 700;"><?php echo e($event->start_date->format('d')); ?></div>
                            <div style="font-size: 0.875rem;"><?php echo e($event->start_date->format('M')); ?></div>
                        </div>
                        <div style="flex: 1;">
                            <h4 style="font-size: 1.1rem; font-weight: 700; color: #1c1c1c; margin-bottom: 0.5rem;"><?php echo e($event->title); ?></h4>
                            <p style="font-size: 0.875rem; color: #666; margin-bottom: 0.5rem;"><?php echo e(Str::limit($event->description, 150)); ?></p>
                            <div style="display: flex; gap: 1rem; font-size: 0.875rem; color: #666;">
                                <span><i class="bi bi-clock"></i> <?php echo e($event->start_date->format('H:i')); ?></span>
                                <span><i class="bi bi-geo-alt"></i> <?php echo e($event->location); ?></span>
                            </div>
                        </div>
                    </div>
                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php else: ?>
            <div style="background: white; border-radius: 16px; padding: 3rem; text-align: center; box-shadow: 0 2px 12px rgba(0,0,0,0.08);">
                <i class="bi bi-calendar-event" style="font-size: 3rem; color: #999; display: block; margin-bottom: 1rem;"></i>
                <p style="color: #666;">Chưa tham gia sự kiện nào</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\AnimeTalk\resources\views/profile/show.blade.php ENDPATH**/ ?>