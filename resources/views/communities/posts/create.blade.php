@extends('layouts.app')

@section('title', 'Create Post - ' . $community->name)

@section('content')
<div style="max-width: 800px; margin: 2rem auto; padding: 0 1rem;">
    <div style="background: white; border-radius: 12px; padding: 2rem; border: 1px solid #e0e0e0;">
        <div style="margin-bottom: 1.5rem;">
            <h1 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem;">Create Post</h1>
            <p style="color: #666;">in <strong>{{ $community->name }}</strong></p>
            <p style="color: #999; font-size: 0.9rem; margin-top: 0.5rem;">
                <i class="bi bi-info-circle"></i> Your post will be reviewed by community moderators before being published
            </p>
        </div>

        <form action="{{ route('communities.posts.store', $community->slug) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Content -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Content <span style="color: red;">*</span></label>
                <textarea name="content" rows="6" 
                          style="width: 100%; padding: 0.75rem; border: 1px solid #e0e0e0; border-radius: 8px; font-family: inherit; resize: vertical;"
                          placeholder="Share your thoughts with the community..."
                          required>{{ old('content') }}</textarea>
                @error('content')
                <span style="color: #ff4444; font-size: 0.9rem;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Image Upload -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Image (optional)</label>
                <input type="file" name="image" accept="image/*"
                       style="width: 100%; padding: 0.75rem; border: 1px solid #e0e0e0; border-radius: 8px;"
                       onchange="previewImage(event)">
                <div id="image-preview" style="margin-top: 1rem; display: none;">
                    <img id="preview-img" style="max-width: 100%; border-radius: 8px; border: 1px solid #e0e0e0;">
                </div>
                @error('image')
                <span style="color: #ff4444; font-size: 0.9rem;">{{ $message }}</span>
                @enderror
                <p style="color: #999; font-size: 0.85rem; margin-top: 0.25rem;">Max file size: 5MB</p>
            </div>

            <!-- Video Upload -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Video (optional)</label>
                <input type="file" name="video" accept="video/*"
                       style="width: 100%; padding: 0.75rem; border: 1px solid #e0e0e0; border-radius: 8px;">
                @error('video')
                <span style="color: #ff4444; font-size: 0.9rem;">{{ $message }}</span>
                @enderror
                <p style="color: #999; font-size: 0.85rem; margin-top: 0.25rem;">Max file size: 50MB (MP4, MOV, AVI)</p>
            </div>

            <!-- Buttons -->
            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <a href="{{ route('communities.show', $community->slug) }}" 
                   style="padding: 0.75rem 1.5rem; background: #f0f0f0; color: #333; border-radius: 8px; text-decoration: none; font-weight: 600;">
                    Cancel
                </a>
                <button type="submit" 
                        style="padding: 0.75rem 2rem; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                    <i class="bi bi-send"></i> Submit for Review
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('image-preview').style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
}
</script>
@endsection
