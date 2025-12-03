

<?php $__env->startSection('title', 'Pending Posts - ' . $community->name); ?>

<?php $__env->startSection('content'); ?>
<div style="max-width: 1000px; margin: 2rem auto; padding: 0 1rem;">
    <div style="background: white; border-radius: 12px; padding: 2rem; border: 1px solid #e0e0e0;">
        <div style="margin-bottom: 1.5rem;">
            <h1 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem;">
                <i class="bi bi-clock-history"></i> Pending Approval
            </h1>
            <p style="color: #666;">Posts waiting for your review in <strong><?php echo e($community->name); ?></strong></p>
        </div>

        <?php if($posts->isEmpty()): ?>
        <div style="text-align: center; padding: 3rem; color: #999;">
            <i class="bi bi-check-circle" style="font-size: 3rem; color: #28a745;"></i>
            <p style="margin-top: 1rem;">No pending posts! All posts have been reviewed.</p>
        </div>
        <?php else: ?>
        <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div style="border: 2px solid #5BA3D0; border-radius: 12px; padding: 1.5rem; margin-bottom: 1.5rem; background: #f9fafb;">
            <!-- Author Info -->
            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
                <?php if($post->user->profile_photo): ?>
                <img src="<?php echo e(asset('storage/' . $post->user->profile_photo)); ?>" alt="<?php echo e($post->user->name); ?>" 
                     style="width: 48px; height: 48px; border-radius: 50%; object-fit: cover;">
                <?php else: ?>
                <div style="width: 48px; height: 48px; border-radius: 50%; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.2rem;">
                    <?php echo e(strtoupper(substr($post->user->name, 0, 1))); ?>

                </div>
                <?php endif; ?>
                
                <div>
                    <div style="font-weight: 600;"><?php echo e($post->user->name); ?></div>
                    <div style="font-size: 0.85rem; color: #666;"><?php echo e($post->created_at->diffForHumans()); ?></div>
                </div>
            </div>

            <!-- Content -->
            <div style="margin-bottom: 1rem; padding: 1rem; background: white; border-radius: 8px; border: 1px solid #e0e0e0;">
                <p style="white-space: pre-wrap; line-height: 1.6;"><?php echo e($post->content); ?></p>

                <?php if($post->image): ?>
                <div style="margin-top: 1rem;">
                    <img src="<?php echo e(asset('storage/' . $post->image)); ?>" alt="Post image" 
                         style="max-width: 100%; border-radius: 8px; border: 1px solid #e0e0e0;">
                </div>
                <?php endif; ?>

                <?php if($post->video): ?>
                <div style="margin-top: 1rem;">
                    <video controls style="max-width: 100%; border-radius: 8px; border: 1px solid #e0e0e0;">
                        <source src="<?php echo e(asset('storage/' . $post->video)); ?>" type="video/mp4">
                    </video>
                </div>
                <?php endif; ?>
            </div>

            <!-- Action Buttons -->
            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <!-- Reject Button -->
                <button onclick="showRejectModal(<?php echo e($post->id); ?>)" 
                        style="padding: 0.75rem 1.5rem; background: #ff4444; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                    <i class="bi bi-x-circle"></i> Reject
                </button>

                <!-- Approve Button -->
                <form action="<?php echo e(route('communities.posts.approve', [$community->slug, $post->id])); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button type="submit" 
                            style="padding: 0.75rem 1.5rem; background: #28a745; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                        <i class="bi bi-check-circle"></i> Approve
                    </button>
                </form>
            </div>
        </div>

        <!-- Reject Modal for this post -->
        <div id="reject-modal-<?php echo e($post->id); ?>" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
            <div style="background: white; border-radius: 12px; padding: 2rem; max-width: 500px; width: 90%;" onclick="event.stopPropagation()">
                <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1rem;">Reject Post</h3>
                <form action="<?php echo e(route('communities.posts.reject', [$community->slug, $post->id])); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Reason (optional)</label>
                        <textarea name="reason" rows="4" 
                                  style="width: 100%; padding: 0.75rem; border: 1px solid #e0e0e0; border-radius: 8px; font-family: inherit;"
                                  placeholder="Let the user know why their post was rejected..."></textarea>
                    </div>
                    <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                        <button type="button" onclick="hideRejectModal(<?php echo e($post->id); ?>)"
                                style="padding: 0.75rem 1.5rem; background: #f0f0f0; color: #333; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                            Cancel
                        </button>
                        <button type="submit" 
                                style="padding: 0.75rem 1.5rem; background: #ff4444; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                            Confirm Reject
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <!-- Pagination -->
        <div style="margin-top: 2rem;">
            <?php echo e($posts->links()); ?>

        </div>
        <?php endif; ?>
    </div>
</div>

<script>
function showRejectModal(postId) {
    const modal = document.getElementById('reject-modal-' + postId);
    modal.style.display = 'flex';
    modal.onclick = function() {
        hideRejectModal(postId);
    };
}

function hideRejectModal(postId) {
    document.getElementById('reject-modal-' + postId).style.display = 'none';
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\AnimeTalk\resources\views/communities/posts/pending.blade.php ENDPATH**/ ?>