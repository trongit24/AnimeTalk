@extends('layouts.app')

@section('title', 'Edit Profile - AnimeTalk')

@section('content')
<div class="container" style="max-width: 800px; margin: 2rem auto; padding: 0 1rem;">
    <div class="card" style="background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 2rem;">
        <h2 style="margin-bottom: 1.5rem; color: #1c1c1c;">Edit Profile</h2>

        @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #c3e6cb;">
            {{ session('success') }}
        </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Cover Photo -->
            <div style="margin-bottom: 2rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #333;">Ảnh bìa</label>
                <div id="coverPhotoContainer" style="position: relative; height: 200px; border-radius: 8px; overflow: hidden; background-size: cover; background-position: center; {{ $user->cover_photo ? 'background-image: url(' . asset('storage/' . $user->cover_photo) . ');' : 'background: linear-gradient(135deg, #5BA3D0, #9B7EDE, #FFB6C1);' }}">
                    <label style="position: absolute; bottom: 1rem; right: 1rem; background: white; padding: 0.5rem 1rem; border-radius: 8px; cursor: pointer; font-weight: 600; box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
                        <i class="bi bi-camera"></i> Đổi ảnh bìa
                        <input type="file" name="cover_photo" accept="image/*" style="display: none;" onchange="previewCover(this)">
                    </label>
                </div>
                @error('cover_photo')
                <div style="color: #dc3545; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Avatar -->
            <div style="margin-bottom: 1.5rem; text-align: center;">
                <div style="margin-bottom: 1rem;">
                    @if($user->profile_photo)
                        <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="{{ $user->name }}" 
                             style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 3px solid #5BA3D0;">
                    @else
                        <div style="width: 120px; height: 120px; border-radius: 50%; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; display: inline-flex; align-items: center; justify-content: center; font-size: 3rem; font-weight: 600;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <label style="display: inline-block; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; padding: 0.5rem 1.5rem; border-radius: 8px; cursor: pointer; font-weight: 600;">
                    <i class="bi bi-camera"></i> Change Avatar
                    <input type="file" name="profile_photo" accept="image/*" style="display: none;" onchange="previewAvatar(this)">
                </label>
                @error('profile_photo')
                <div style="color: #dc3545; font-size: 0.875rem; margin-top: 0.5rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Name -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #333;">Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                       style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px; font-size: 1rem;">
                @error('name')
                <div style="color: #dc3545; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #333;">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                       style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px; font-size: 1rem;">
                @error('email')
                <div style="color: #dc3545; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Bio -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #333;">Bio</label>
                <textarea name="bio" rows="4" placeholder="Tell us about yourself..."
                          style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px; font-size: 1rem; resize: vertical;">{{ old('bio', $user->bio) }}</textarea>
                @error('bio')
                <div style="color: #dc3545; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit Button -->
            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <a href="{{ route('home') }}" style="padding: 0.75rem 1.5rem; border: 1px solid #ddd; border-radius: 8px; text-decoration: none; color: #666; font-weight: 600;">
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
@endsection
