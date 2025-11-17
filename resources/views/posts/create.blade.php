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
                
                <!-- User Avatar Section -->
                <div class="post-creator-header" style="display: flex; align-items: center; gap: 12px; margin-bottom: 20px; padding: 15px; background: #f8f9fa; border-radius: 12px;">
                    @if(Auth::user()->profile_photo)
                        <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" 
                             alt="{{ Auth::user()->name }}" 
                             style="width: 48px; height: 48px; border-radius: 50%; object-fit: cover; border: 2px solid #007bff;">
                    @elseif(Auth::user()->avatar)
                        <img src="{{ Auth::user()->avatar }}" 
                             alt="{{ Auth::user()->name }}" 
                             style="width: 48px; height: 48px; border-radius: 50%; object-fit: cover; border: 2px solid #007bff;">
                    @else
                        <div style="width: 48px; height: 48px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 20px; border: 2px solid #007bff;">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    @endif
                    <div style="flex: 1;">
                        <h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">{{ Auth::user()->name }}</h3>
                        <p style="margin: 0; font-size: 14px; color: #666;">What's your favorite anime?</p>
                    </div>
                </div>
                
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
