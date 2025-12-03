

<?php $__env->startSection('title', 'Edit Community - AnimeTalk'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/communities.css')); ?>">
<style>
.create-community-page,
.create-community-page *,
.create-community-container,
.create-community-container * {
    opacity: 1 !important;
    visibility: visible !important;
}
div[style*="background: white"] {
    background: white !important;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="create-community-page" style="opacity: 1 !important; visibility: visible !important;">
    <div class="create-community-container">
        <div style="background: white; border-radius: 12px; padding: 2rem; border: 1px solid #e0e0e0;">
            <h1 style="font-size: 1.75rem; font-weight: 700; margin-bottom: 0.5rem;">Edit Community</h1>
            <p style="color: #666; margin-bottom: 2rem;">Update your community information</p>

            <form action="<?php echo e(route('communities.update', $community->slug)); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <!-- Community Name -->
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">
                        Community Name <span style="color: red;">*</span>
                    </label>
                    <input type="text" name="name" value="<?php echo e(old('name', $community->name)); ?>" required
                           placeholder="e.g., One Piece Fans"
                           style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 1rem;">
                    <?php $__errorArgs = ['name'];
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

                <!-- Description -->
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">
                        Description <span style="color: red;">*</span>
                    </label>
                    <textarea name="description" rows="4" required
                              placeholder="Tell people what this community is about..."
                              style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 1rem; resize: vertical;"><?php echo e(old('description', $community->description)); ?></textarea>
                    <?php $__errorArgs = ['description'];
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

                <!-- Category -->
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">
                        Category <span style="color: red;">*</span>
                    </label>
                    <select name="category" required
                            style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 1rem;">
                        <option value="">Select a category</option>
                        <?php $__currentLoopData = ['Anime', 'Manga', 'Action', 'Romance', 'Comedy', 'Drama', 'Fantasy', 'Sci-Fi', 'Horror', 'Slice of Life', 'Sports', 'Mecha', 'Isekai', 'Other']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($cat); ?>" <?php echo e(old('category', $community->category) == $cat ? 'selected' : ''); ?>><?php echo e($cat); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['category'];
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

                <!-- Current Icon -->
                <?php if($community->icon): ?>
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">
                        Current Icon
                    </label>
                    <img src="<?php echo e(asset('storage/' . $community->icon)); ?>" alt="Current icon" 
                         style="width: 100px; height: 100px; object-fit: cover; border-radius: 12px; border: 2px solid #e0e0e0;">
                </div>
                <?php endif; ?>

                <!-- Community Icon -->
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">
                        <?php echo e($community->icon ? 'Change Icon' : 'Community Icon'); ?>

                    </label>
                    <input type="file" name="icon" accept="image/*" id="iconInput"
                           style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #e0e0e0; border-radius: 8px;">
                    <small style="color: #666; font-size: 0.875rem; margin-top: 0.25rem; display: block;">
                        Recommended: Square image, at least 256x256px
                    </small>
                    <div id="iconPreview" style="margin-top: 0.75rem; display: none;">
                        <img id="iconPreviewImg" src="" alt="Icon preview" style="width: 100px; height: 100px; object-fit: cover; border-radius: 12px; border: 2px solid #e0e0e0;">
                    </div>
                    <?php $__errorArgs = ['icon'];
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

                <!-- Current Banner -->
                <?php if($community->banner): ?>
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">
                        Current Banner
                    </label>
                    <img src="<?php echo e(asset('storage/' . $community->banner)); ?>" alt="Current banner" 
                         style="width: 100%; height: 120px; object-fit: cover; border-radius: 8px; border: 2px solid #e0e0e0;">
                </div>
                <?php endif; ?>

                <!-- Community Banner -->
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">
                        <?php echo e($community->banner ? 'Change Banner' : 'Community Banner'); ?>

                    </label>
                    <input type="file" name="banner" accept="image/*" id="bannerInput"
                           style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #e0e0e0; border-radius: 8px;">
                    <small style="color: #666; font-size: 0.875rem; margin-top: 0.25rem; display: block;">
                        Recommended: Wide image, at least 1920x384px
                    </small>
                    <div id="bannerPreview" style="margin-top: 0.75rem; display: none;">
                        <img id="bannerPreviewImg" src="" alt="Banner preview" style="width: 100%; height: 120px; object-fit: cover; border-radius: 8px; border: 2px solid #e0e0e0;">
                    </div>
                    <?php $__errorArgs = ['banner'];
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
                <div class="form-group" style="margin-bottom: 2rem;">
                    <label style="display: flex; align-items: center; gap: 0.75rem; cursor: pointer;">
                        <input type="checkbox" name="is_private" value="1" <?php echo e(old('is_private', $community->is_private) ? 'checked' : ''); ?>

                               style="width: 20px; height: 20px; cursor: pointer;">
                        <div>
                            <div style="font-weight: 600; color: #333;">Private Community</div>
                            <small style="color: #666;">Only approved members can view and post content</small>
                        </div>
                    </label>
                </div>

                <!-- Actions -->
                <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                    <a href="<?php echo e(route('communities.show', $community->slug)); ?>" 
                       style="padding: 0.75rem 1.5rem; background: #f0f0f0; color: #333; border-radius: 8px; text-decoration: none; font-weight: 600;">
                        Cancel
                    </a>
                    <button type="submit" 
                            style="padding: 0.75rem 2rem; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                        Update Community
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Icon preview
document.getElementById('iconInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('iconPreviewImg').src = e.target.result;
            document.getElementById('iconPreview').style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
});

// Banner preview
document.getElementById('bannerInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('bannerPreviewImg').src = e.target.result;
            document.getElementById('bannerPreview').style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\AnimeTalk\resources\views/communities/edit.blade.php ENDPATH**/ ?>