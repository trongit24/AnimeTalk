@extends('layouts.app')

@section('title', 'Create Event - AnimeTalk')

@push('styles')
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
@endpush

@section('content')
<div style="background: #F0F2F5; min-height: calc(100vh - 60px); padding: 2rem 0; opacity: 1 !important; visibility: visible !important;">
    <div style="max-width: 800px; margin: 0 auto; padding: 0 1rem;">
        <div style="background: white; border-radius: 12px; padding: 2rem; border: 1px solid #e0e0e0;">
            <h1 style="font-size: 1.75rem; font-weight: 700; margin-bottom: 0.5rem;">Create Event</h1>
            <p style="color: #666; margin-bottom: 2rem;">Organize an event for your community</p>

            <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Event Title -->
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">
                        Event Title <span style="color: red;">*</span>
                    </label>
                    <input type="text" name="title" value="{{ old('title') }}" required
                           placeholder="e.g., Anime Convention 2025"
                           style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 1rem;">
                    @error('title')
                    <span style="color: red; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Location -->
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">
                        Location
                    </label>
                    <input type="text" name="location" value="{{ old('location') }}"
                           placeholder="e.g., Tokyo Big Sight, Tokyo, Japan"
                           style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 1rem;">
                    @error('location')
                    <span style="color: red; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Date & Time -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">
                            Start Date & Time <span style="color: red;">*</span>
                        </label>
                        <input type="datetime-local" name="start_time" value="{{ old('start_time') }}" required
                               style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 1rem;">
                        @error('start_time')
                        <span style="color: red; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">
                            End Date & Time
                        </label>
                        <input type="datetime-local" name="end_time" value="{{ old('end_time') }}"
                               style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 1rem;">
                        @error('end_time')
                        <span style="color: red; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
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
                    @error('cover_image')
                    <span style="color: red; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Privacy -->
                <div style="margin-bottom: 2rem;">
                    <label style="display: block; font-weight: 600; margin-bottom: 0.75rem; color: #333;">
                        Privacy <span style="color: red;">*</span>
                    </label>
                    <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                        <label style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; border: 1px solid #e0e0e0; border-radius: 8px; cursor: pointer;">
                            <input type="radio" name="privacy" value="public" {{ old('privacy', 'public') == 'public' ? 'checked' : '' }} required
                                   style="width: 18px; height: 18px;">
                            <div>
                                <div style="font-weight: 600;">Public</div>
                                <small style="color: #666;">Anyone can see and join this event</small>
                            </div>
                        </label>
                        <label style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; border: 1px solid #e0e0e0; border-radius: 8px; cursor: pointer;">
                            <input type="radio" name="privacy" value="friends" {{ old('privacy') == 'friends' ? 'checked' : '' }}
                                   style="width: 18px; height: 18px;">
                            <div>
                                <div style="font-weight: 600;">Friends</div>
                                <small style="color: #666;">Only your friends can see this event</small>
                            </div>
                        </label>
                        <label style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; border: 1px solid #e0e0e0; border-radius: 8px; cursor: pointer;">
                            <input type="radio" name="privacy" value="private" {{ old('privacy') == 'private' ? 'checked' : '' }}
                                   style="width: 18px; height: 18px;">
                            <div>
                                <div style="font-weight: 600;">Private</div>
                                <small style="color: #666;">Only invited people can see and join</small>
                            </div>
                        </label>
                    </div>
                    @error('privacy')
                    <span style="color: red; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Actions -->
                <div style="display: flex; gap: 1rem; justify-content: flex-end; padding-top: 1rem; border-top: 1px solid #e0e0e0;">
                    <a href="{{ route('events.index') }}" 
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
@endsection
