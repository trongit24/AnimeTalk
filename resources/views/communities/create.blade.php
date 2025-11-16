@extends('layouts.app')

@section('title', 'Start a Community - AnimeTalk')

@section('content')
<div class="create-community-page" style="background: #DAE0E6; min-height: calc(100vh - 60px); padding: 2rem 0;">
    <div class="container" style="max-width: 700px; margin: 0 auto;">
        <div style="background: white; border-radius: 12px; padding: 2rem; border: 1px solid #e0e0e0;">
            <h1 style="font-size: 1.75rem; font-weight: 700; margin-bottom: 0.5rem;">Start a Community</h1>
            <p style="color: #666; margin-bottom: 2rem;">Create your own anime community and bring fans together!</p>

            <form action="{{ route('communities.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Community Name -->
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">
                        Community Name <span style="color: red;">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           placeholder="e.g., One Piece Fans"
                           style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 1rem;">
                    @error('name')
                    <span style="color: red; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Description -->
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">
                        Description <span style="color: red;">*</span>
                    </label>
                    <textarea name="description" rows="4" required
                              placeholder="Tell people what this community is about..."
                              style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 1rem; resize: vertical;">{{ old('description') }}</textarea>
                    @error('description')
                    <span style="color: red; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Category -->
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">
                        Category <span style="color: red;">*</span>
                    </label>
                    <select name="category" required
                            style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 1rem;">
                        <option value="">Select a category</option>
                        <option value="Anime" {{ old('category') == 'Anime' ? 'selected' : '' }}>Anime</option>
                        <option value="Manga" {{ old('category') == 'Manga' ? 'selected' : '' }}>Manga</option>
                        <option value="Action" {{ old('category') == 'Action' ? 'selected' : '' }}>Action</option>
                        <option value="Romance" {{ old('category') == 'Romance' ? 'selected' : '' }}>Romance</option>
                        <option value="Comedy" {{ old('category') == 'Comedy' ? 'selected' : '' }}>Comedy</option>
                        <option value="Drama" {{ old('category') == 'Drama' ? 'selected' : '' }}>Drama</option>
                        <option value="Fantasy" {{ old('category') == 'Fantasy' ? 'selected' : '' }}>Fantasy</option>
                        <option value="Sci-Fi" {{ old('category') == 'Sci-Fi' ? 'selected' : '' }}>Sci-Fi</option>
                        <option value="Horror" {{ old('category') == 'Horror' ? 'selected' : '' }}>Horror</option>
                        <option value="Slice of Life" {{ old('category') == 'Slice of Life' ? 'selected' : '' }}>Slice of Life</option>
                        <option value="Sports" {{ old('category') == 'Sports' ? 'selected' : '' }}>Sports</option>
                        <option value="Mecha" {{ old('category') == 'Mecha' ? 'selected' : '' }}>Mecha</option>
                        <option value="Isekai" {{ old('category') == 'Isekai' ? 'selected' : '' }}>Isekai</option>
                        <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('category')
                    <span style="color: red; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Community Icon -->
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">
                        Community Icon
                    </label>
                    <input type="file" name="icon" accept="image/*" id="iconInput"
                           style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #e0e0e0; border-radius: 8px;">
                    <small style="color: #666; font-size: 0.875rem; margin-top: 0.25rem; display: block;">
                        Recommended: Square image, at least 256x256px
                    </small>
                    <div id="iconPreview" style="margin-top: 0.75rem; display: none;">
                        <img id="iconPreviewImg" src="" alt="Icon preview" style="width: 100px; height: 100px; object-fit: cover; border-radius: 12px; border: 2px solid #e0e0e0;">
                    </div>
                    @error('icon')
                    <span style="color: red; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Community Banner -->
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">
                        Community Banner
                    </label>
                    <input type="file" name="banner" accept="image/*" id="bannerInput"
                           style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #e0e0e0; border-radius: 8px;">
                    <small style="color: #666; font-size: 0.875rem; margin-top: 0.25rem; display: block;">
                        Recommended: Wide image, at least 1920x384px
                    </small>
                    <div id="bannerPreview" style="margin-top: 0.75rem; display: none;">
                        <img id="bannerPreviewImg" src="" alt="Banner preview" style="width: 100%; height: 120px; object-fit: cover; border-radius: 8px; border: 2px solid #e0e0e0;">
                    </div>
                    @error('banner')
                    <span style="color: red; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Privacy -->
                <div class="form-group" style="margin-bottom: 2rem;">
                    <label style="display: flex; align-items: center; gap: 0.75rem; cursor: pointer;">
                        <input type="checkbox" name="is_private" value="1" {{ old('is_private') ? 'checked' : '' }}
                               style="width: 20px; height: 20px; cursor: pointer;">
                        <div>
                            <div style="font-weight: 600; color: #333;">Private Community</div>
                            <small style="color: #666;">Only approved members can view and post content</small>
                        </div>
                    </label>
                </div>

                <!-- Actions -->
                <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                    <a href="{{ route('communities.index') }}" 
                       style="padding: 0.75rem 1.5rem; background: #f0f0f0; color: #333; border-radius: 8px; text-decoration: none; font-weight: 600;">
                        Cancel
                    </a>
                    <button type="submit" 
                            style="padding: 0.75rem 2rem; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                        Create Community
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
@endsection
