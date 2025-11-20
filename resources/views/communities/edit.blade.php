@extends('layouts.app')

@section('title', 'Edit Community - AnimeTalk')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/communities.css') }}">
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
@endpush

@section('content')
<div class="create-community-page" style="opacity: 1 !important; visibility: visible !important;">
    <div class="create-community-container">
        <div style="background: white; border-radius: 12px; padding: 2rem; border: 1px solid #e0e0e0;">
            <h1 style="font-size: 1.75rem; font-weight: 700; margin-bottom: 0.5rem;">Edit Community</h1>
            <p style="color: #666; margin-bottom: 2rem;">Update your community information</p>

            <form action="{{ route('communities.update', $community->slug) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Community Name -->
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">
                        Community Name <span style="color: red;">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name', $community->name) }}" required
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
                              style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 1rem; resize: vertical;">{{ old('description', $community->description) }}</textarea>
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
                        @foreach(['Anime', 'Manga', 'Action', 'Romance', 'Comedy', 'Drama', 'Fantasy', 'Sci-Fi', 'Horror', 'Slice of Life', 'Sports', 'Mecha', 'Isekai', 'Other'] as $cat)
                        <option value="{{ $cat }}" {{ old('category', $community->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                    @error('category')
                    <span style="color: red; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Current Icon -->
                @if($community->icon)
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">
                        Current Icon
                    </label>
                    <img src="{{ asset('storage/' . $community->icon) }}" alt="Current icon" 
                         style="width: 100px; height: 100px; object-fit: cover; border-radius: 12px; border: 2px solid #e0e0e0;">
                </div>
                @endif

                <!-- Community Icon -->
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">
                        {{ $community->icon ? 'Change Icon' : 'Community Icon' }}
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

                <!-- Current Banner -->
                @if($community->banner)
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">
                        Current Banner
                    </label>
                    <img src="{{ asset('storage/' . $community->banner) }}" alt="Current banner" 
                         style="width: 100%; height: 120px; object-fit: cover; border-radius: 8px; border: 2px solid #e0e0e0;">
                </div>
                @endif

                <!-- Community Banner -->
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">
                        {{ $community->banner ? 'Change Banner' : 'Community Banner' }}
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
                        <input type="checkbox" name="is_private" value="1" {{ old('is_private', $community->is_private) ? 'checked' : '' }}
                               style="width: 20px; height: 20px; cursor: pointer;">
                        <div>
                            <div style="font-weight: 600; color: #333;">Private Community</div>
                            <small style="color: #666;">Only approved members can view and post content</small>
                        </div>
                    </label>
                </div>

                <!-- Actions -->
                <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                    <a href="{{ route('communities.show', $community->slug) }}" 
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
@endsection
