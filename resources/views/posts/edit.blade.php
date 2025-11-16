@extends('layouts.app')

@section('title', 'Edit Post - AnimeTalk')

@section('content')
<div class="create-post-page">
    <div class="container">
        <div class="page-header">
            <h1>Edit Post</h1>
            <p>Update your post</p>
        </div>

        <div class="create-post-form">
            <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="title">Post Title</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}" required>
                    @error('title')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="content">Content</label>
                    <textarea id="content" name="content" rows="10" required>{{ old('content', $post->content) }}</textarea>
                    @error('content')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="category">Category (Optional)</label>
                    <select id="category" name="category" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px; font-size: 1rem;">
                        <option value="">-- Select Category --</option>
                        <option value="anime" {{ old('category', $post->category) == 'anime' ? 'selected' : '' }}>Anime</option>
                        <option value="manga" {{ old('category', $post->category) == 'manga' ? 'selected' : '' }}>Manga</option>
                        <option value="cosplay" {{ old('category', $post->category) == 'cosplay' ? 'selected' : '' }}>Cosplay</option>
                        <option value="discussion" {{ old('category', $post->category) == 'discussion' ? 'selected' : '' }}>Discussion</option>
                    </select>
                    @error('category')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="image">Featured Image (Optional)</label>
                    @if($post->image)
                        <div class="current-image mb-3">
                            <img src="{{ asset('storage/' . $post->image) }}" alt="Current image" style="max-width: 300px; border-radius: 8px;">
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" name="remove_image" id="remove_image" value="1">
                                <label class="form-check-label" for="remove_image">
                                    Remove current image
                                </label>
                            </div>
                        </div>
                    @endif
                    <input type="file" id="image" name="image" accept="image/*">
                    @error('image')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="video">Video (Optional)</label>
                    @if($post->video)
                        <div class="current-video mb-3">
                            <video controls style="max-width: 100%; max-height: 300px; border-radius: 8px;">
                                <source src="{{ asset('storage/' . $post->video) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" name="remove_video" id="remove_video" value="1">
                                <label class="form-check-label" for="remove_video">
                                    Remove current video
                                </label>
                            </div>
                        </div>
                    @endif
                    <input type="file" id="video" name="video" accept="video/*">
                    <small style="color: #666; font-size: 0.875rem; display: block; margin-top: 0.5rem;">Supported formats: MP4, WebM, OGG (Max 50MB)</small>
                    @error('video')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Tags</label>
                    <div class="tags-checkbox-group">
                        @foreach($tags as $tag)
                            <label class="tag-checkbox">
                                <input type="checkbox" name="tags[]" value="{{ $tag->id }}" 
                                    {{ in_array($tag->id, old('tags', $post->tags->pluck('id')->toArray())) ? 'checked' : '' }}>
                                <span style="background-color: {{ $tag->color }}20; color: {{ $tag->color }}">
                                    {{ $tag->name }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                    @error('tags')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-actions">
                    <a href="{{ route('posts.show', $post->slug) }}" class="btn-outline">Cancel</a>
                    <button type="submit" class="btn-primary">Update Post</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.create-post-page {
    padding: 3rem 0;
    min-height: calc(100vh - 200px);
}

.page-header {
    text-align: center;
    margin-bottom: 3rem;
}

.page-header h1 {
    font-size: 2.5rem;
    font-weight: 800;
    background: linear-gradient(135deg, #5BA3D0, #9B7EDE);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 0.5rem;
}

.page-header p {
    color: #666;
    font-size: 1.1rem;
}

.create-post-form {
    max-width: 800px;
    margin: 0 auto;
    background: white;
    padding: 2rem;
    border-radius: 15px;
    box-shadow: 0 5px 30px rgba(91, 163, 208, 0.15);
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #333;
}

.form-group input[type="text"],
.form-group select,
.form-group textarea,
.form-group input[type="file"] {
    width: 100%;
    padding: 0.75rem;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-group input[type="text"]:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #5BA3D0;
    box-shadow: 0 0 0 3px rgba(91, 163, 208, 0.1);
}

.form-group textarea {
    resize: vertical;
    font-family: inherit;
}

.tags-checkbox-group {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.tag-checkbox {
    cursor: pointer;
}

.tag-checkbox input[type="checkbox"] {
    display: none;
}

.tag-checkbox span {
    display: inline-block;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 500;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.tag-checkbox input[type="checkbox"]:checked + span {
    border-color: currentColor;
    transform: scale(1.05);
}

.error {
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 0.25rem;
    display: block;
}

.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    margin-top: 2rem;
}

.btn-primary,
.btn-outline {
    padding: 0.75rem 2rem;
    border-radius: 25px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.3s ease;
    border: none;
    font-size: 1rem;
}

.btn-primary {
    background: linear-gradient(135deg, #5BA3D0, #9B7EDE);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 20px rgba(91, 163, 208, 0.4);
}

.btn-outline {
    background: transparent;
    color: #5BA3D0;
    border: 2px solid #5BA3D0;
}

.btn-outline:hover {
    background: #5BA3D0;
    color: white;
}

.current-image {
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 8px;
}
</style>
@endsection
