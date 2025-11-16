@extends('layouts.app')

@section('title', 'Create Post - AnimeTalk')

@section('content')
<div class="create-post-page">
    <div class="container">
        <div class="page-header">
            <h1>Create New Post</h1>
            <p>Share your thoughts with the community</p>
        </div>

        <div class="create-post-form">
            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group">
                    <label for="title">Post Title</label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required>
                    @error('title')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="content">Content</label>
                    <textarea id="content" name="content" rows="10" required>{{ old('content') }}</textarea>
                    @error('content')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="category">Category (Optional)</label>
                    <select id="category" name="category" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 8px; font-size: 1rem;">
                        <option value="">-- Select Category --</option>
                        <option value="anime" {{ old('category') == 'anime' ? 'selected' : '' }}>Anime</option>
                        <option value="manga" {{ old('category') == 'manga' ? 'selected' : '' }}>Manga</option>
                        <option value="cosplay" {{ old('category') == 'cosplay' ? 'selected' : '' }}>Cosplay</option>
                        <option value="discussion" {{ old('category') == 'discussion' ? 'selected' : '' }}>Discussion</option>
                    </select>
                    @error('category')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="image">Featured Image (Optional)</label>
                    <input type="file" id="image" name="image" accept="image/*">
                    @error('image')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="video">Video (Optional)</label>
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
                                    {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}>
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
                    <a href="{{ route('home') }}" class="btn-outline">Cancel</a>
                    <button type="submit" class="btn-primary">Publish Post</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
