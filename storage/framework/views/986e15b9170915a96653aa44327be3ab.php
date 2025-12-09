

<?php $__env->startSection('title', 'Create Event - AnimeTalk'); ?>

<?php $__env->startPush('styles'); ?>
<style>
div[style*="background: white"],
div[style*="background: #F0F2F5"] {
    opacity: 1 !important;
    visibility: visible !important;
}
div[style*="background: white"] * {
    opacity: 1 !important;
    visibility: visible !important;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div style="background: #F0F2F5; min-height: calc(100vh - 60px); padding: 2rem 0; opacity: 1 !important; visibility: visible !important;">
    <div style="max-width: 800px; margin: 0 auto; padding: 0 1rem;">
        <div style="background: white; border-radius: 12px; padding: 2rem; border: 1px solid #e0e0e0;">
            <h1 style="font-size: 1.75rem; font-weight: 700; margin-bottom: 0.5rem;">Create Event</h1>
            <p style="color: #666; margin-bottom: 2rem;">Organize an event for your community</p>

            <form action="<?php echo e(route('events.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                <!-- Event Title -->
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">
                        Event Title <span style="color: red;">*</span>
                    </label>
                    <input type="text" name="title" value="<?php echo e(old('title')); ?>" required
                           placeholder="e.g., Anime Convention 2025"
                           style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 1rem;">
                    <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span style="color: red; font-size: 0.875rem; margin-top: 0.25rem; display: block;"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Location -->
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">
                        Location
                    </label>
                    <input type="text" name="location" value="<?php echo e(old('location')); ?>"
                           placeholder="e.g., Tokyo Big Sight, Tokyo, Japan"
                           style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 1rem;">
                    <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span style="color: red; font-size: 0.875rem; margin-top: 0.25rem; display: block;"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Date & Time -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">
                            Start Date & Time <span style="color: red;">*</span>
                        </label>
                        <input type="datetime-local" name="start_time" value="<?php echo e(old('start_time')); ?>" required
                               style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 1rem;">
                        <?php $__errorArgs = ['start_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span style="color: red; font-size: 0.875rem; margin-top: 0.25rem; display: block;"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">
                            End Date & Time
                        </label>
                        <input type="datetime-local" name="end_time" value="<?php echo e(old('end_time')); ?>"
                               style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 1rem;">
                        <?php $__errorArgs = ['end_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span style="color: red; font-size: 0.875rem; margin-top: 0.25rem; display: block;"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <!-- Cover Image -->
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">
                        Cover Image
                    </label>
                    <input type="file" name="cover_image" accept="image/*" id="coverInput"
                           style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #e0e0e0; border-radius: 8px;">
                    <small style="color: #666; font-size: 0.875rem; margin-top: 0.25rem; display: block;">
                        Recommended: 1200x628px or 16:9 ratio
                    </small>
                    <div id="coverPreview" style="margin-top: 0.75rem; display: none;">
                        <img id="coverPreviewImg" src="" alt="Cover preview" style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px; border: 2px solid #e0e0e0;">
                    </div>
                    <?php $__errorArgs = ['cover_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span style="color: red; font-size: 0.875rem; margin-top: 0.25rem; display: block;"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Privacy -->
                <div style="margin-bottom: 2rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.75rem; color: #333;">
                        Privacy <span style="color: red;">*</span>
                    </label>
                    <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                        <label style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; border: 1px solid #e0e0e0; border-radius: 8px; cursor: pointer;">
                            <input type="radio" name="privacy" value="public" <?php echo e(old('privacy', 'public') == 'public' ? 'checked' : ''); ?> required
                                   style="width: 18px; height: 18px;">
                            <div>
                                <div style="font-weight: 600;">Public</div>
                                <small style="color: #666;">Anyone can see and join this event</small>
                            </div>
                        </label>
                        <label style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; border: 1px solid #e0e0e0; border-radius: 8px; cursor: pointer;">
                            <input type="radio" name="privacy" value="friends" <?php echo e(old('privacy') == 'friends' ? 'checked' : ''); ?>

                                   style="width: 18px; height: 18px;">
                            <div>
                                <div style="font-weight: 600;">Friends</div>
                                <small style="color: #666;">Only your friends can see this event</small>
                            </div>
                        </label>
                        <label style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; border: 1px solid #e0e0e0; border-radius: 8px; cursor: pointer;">
                            <input type="radio" name="privacy" value="private" <?php echo e(old('privacy') == 'private' ? 'checked' : ''); ?>

                                   style="width: 18px; height: 18px;">
                            <div>
                                <div style="font-weight: 600;">Private</div>
                                <small style="color: #666;">Only invited people can see and join</small>
                            </div>
                        </label>
                    </div>
                    <?php $__errorArgs = ['privacy'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span style="color: red; font-size: 0.875rem; margin-top: 0.25rem; display: block;"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Actions -->
                <div style="display: flex; gap: 1rem; justify-content: flex-end; padding-top: 1rem; border-top: 1px solid #e0e0e0;">
                    <a href="<?php echo e(route('events.index')); ?>" 
                       style="padding: 0.75rem 1.5rem; background: #f0f0f0; color: #333; border-radius: 8px; text-decoration: none; font-weight: 600;">
                        Cancel
                    </a>
                    <button type="submit" 
                            style="padding: 0.75rem 2rem; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                        Create Event
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Cover image preview
document.getElementById('coverInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('coverPreviewImg').src = e.target.result;
            document.getElementById('coverPreview').style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\AnimeTalk\resources\views/events/create.blade.php ENDPATH**/ ?>