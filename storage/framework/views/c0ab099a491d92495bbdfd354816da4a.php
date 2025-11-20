<?php $__env->startSection('title', 'Edit Profile - AnimeTalk'); ?>

<?php $__env->startPush('styles'); ?>
<style>
.container,
.container *,
.card,
.card * {
    opacity: 1 !important;
    visibility: visible !important;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container" style="max-width: 800px; margin: 2rem auto; padding: 0 1rem; opacity: 1 !important; visibility: visible !important;">
    <div class="card" style="background: white !important; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 2rem; opacity: 1 !important; visibility: visible !important;">
        <h2 style="margin-bottom: 1.5rem; color: #1c1c1c !important;">Edit Profile</h2>

        <?php if(session('success')): ?>
        <div style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #c3e6cb;">
            <?php echo e(session('success')); ?>

        </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('profile.update')); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <!-- Cover Photo -->
            <div style="margin-bottom: 2rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #333;">Ảnh bìa</label>
                <div id="coverPhotoContainer" style="position: relative; height: 200px; border-radius: 8px; overflow: hidden; background-size: cover; background-position: center; <?php echo e($user->cover_photo ? 'background-image: url(' . asset('storage/' . $user->cover_photo) . ');' : 'background: linear-gradient(135deg, #5BA3D0, #9B7EDE, #FFB6C1);'); ?>">
                    <label style="position: absolute; bottom: 1rem; right: 1rem; background: white; padding: 0.5rem 1rem; border-radius: 8px; cursor: pointer; font-weight: 600; box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
                        <i class="bi bi-camera"></i> Đổi ảnh bìa
                        <input type="file" name="cover_photo" accept="image/*" style="display: none;" onchange="previewCover(this)">
                    </label>
                </div>
                <?php $__errorArgs = ['cover_photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div style="color: #dc3545; font-size: 0.875rem; margin-top: 0.5rem;"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Avatar -->
            <div style="margin-bottom: 1.5rem; text-align: center;">
                <div style="margin-bottom: 1rem;">
                    <?php if($user->profile_photo): ?>
                        <img src="<?php echo e(asset('storage/' . $user->profile_photo)); ?>" alt="<?php echo e($user->name); ?>" 
                             style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 3px solid #5BA3D0;">
                    <?php else: ?>
                        <div style="width: 120px; height: 120px; border-radius: 50%; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; display: inline-flex; align-items: center; justify-content: center; font-size: 3rem; font-weight: 600;">
                            <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

                        </div>
                    <?php endif; ?>
                </div>
                <label style="display: inline-block; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; padding: 0.5rem 1.5rem; border-radius: 8px; cursor: pointer; font-weight: 600;">
                    <i class="bi bi-camera"></i> Change Avatar
                    <input type="file" name="profile_photo" accept="image/*" style="display: none;" onchange="previewAvatar(this)">
                </label>
                <?php $__errorArgs = ['profile_photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div style="color: #dc3545; font-size: 0.875rem; margin-top: 0.5rem;"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Name -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #333;">Name</label>
                <input type="text" name="name" value="<?php echo e(old('name', $user->name)); ?>" required
                       style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px; font-size: 1rem;">
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div style="color: #dc3545; font-size: 0.875rem; margin-top: 0.25rem;"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Email -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #333;">Email</label>
                <input type="email" name="email" value="<?php echo e(old('email', $user->email)); ?>" required
                       style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px; font-size: 1rem;">
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div style="color: #dc3545; font-size: 0.875rem; margin-top: 0.25rem;"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Bio -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #333;">Bio</label>
                <textarea name="bio" rows="4" placeholder="Tell us about yourself..."
                          style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px; font-size: 1rem; resize: vertical;"><?php echo e(old('bio', $user->bio)); ?></textarea>
                <?php $__errorArgs = ['bio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div style="color: #dc3545; font-size: 0.875rem; margin-top: 0.25rem;"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Submit Button -->
            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <a href="<?php echo e(route('home')); ?>" style="padding: 0.75rem 1.5rem; border: 1px solid #ddd; border-radius: 8px; text-decoration: none; color: #666; font-weight: 600;">
                    Cancel
                </a>
                <button type="submit" style="background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; border: none; padding: 0.75rem 2rem; border-radius: 8px; font-weight: 600; cursor: pointer;">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewCover(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const container = document.getElementById('coverPhotoContainer');
            container.style.backgroundImage = `url(${e.target.result})`;
            container.style.backgroundSize = 'cover';
            container.style.backgroundPosition = 'center';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = input.closest('div').querySelector('img, div[style*="border-radius: 50%"]');
            if (img.tagName === 'IMG') {
                img.src = e.target.result;
            } else {
                const newImg = document.createElement('img');
                newImg.src = e.target.result;
                newImg.style.cssText = 'width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 3px solid #5BA3D0;';
                img.replaceWith(newImg);
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\AnimeTalk\resources\views/profile/edit.blade.php ENDPATH**/ ?>