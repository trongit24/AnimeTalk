@extends('layouts.app')

@section('title', 'Create Post - AnimeTalk')

@push('styles')
<style>
.fb-create-post {
    max-width: 680px;
    margin: 2rem auto;
    padding: 0 1rem;
}

.fb-post-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    padding: 1rem;
}

.fb-post-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 1rem;
}

.fb-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

.fb-avatar-placeholder {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #5BA3D0, #9B7EDE);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 18px;
}

.fb-user-info h3 {
    margin: 0;
    font-size: 15px;
    font-weight: 600;
    color: #050505;
}

.fb-privacy {
    display: flex;
    align-items: center;
    gap: 4px;
    margin-top: 2px;
    font-size: 13px;
    color: #65676b;
}

.fb-content-area {
    position: relative;
    margin-bottom: 1rem;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s;
}

.fb-textarea {
    width: 100%;
    border: none;
    outline: none;
    font-size: 24px;
    font-family: inherit;
    resize: none;
    min-height: 120px;
    padding: 16px;
    color: #050505;
    background: transparent;
    position: relative;
    z-index: 1;
}

.fb-textarea.has-media {
    font-size: 15px;
    min-height: 80px;
}

.fb-textarea.has-background {
    color: white;
    font-size: 28px;
    font-weight: 600;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 200px;
    text-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

.fb-textarea::placeholder {
    color: #b0b3b8;
}

.fb-textarea.has-background::placeholder {
    color: rgba(255,255,255,0.8);
}

.background-selector {
    display: none;
    margin-bottom: 1rem;
}

.background-selector.active {
    display: block;
}

.bg-options {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
    gap: 8px;
    margin-top: 8px;
}

.bg-option {
    aspect-ratio: 1;
    border-radius: 8px;
    cursor: pointer;
    border: 3px solid transparent;
    transition: all 0.2s;
    position: relative;
}

.bg-option.selected {
    border-color: #5BA3D0;
    transform: scale(1.05);
}

.bg-option input {
    display: none;
}

.bg-none { background: white; border: 2px solid #e4e6eb; }
.bg-gradient-1 { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
.bg-gradient-2 { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
.bg-gradient-3 { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
.bg-gradient-4 { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }
.bg-gradient-5 { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); }
.bg-gradient-6 { background: linear-gradient(135deg, #30cfd0 0%, #330867 100%); }
.bg-gradient-7 { background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); }
.bg-gradient-8 { background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%); }

.media-preview {
    margin-bottom: 1rem;
    border-radius: 8px;
    overflow: hidden;
    position: relative;
}

.media-preview img,
.media-preview video {
    width: 100%;
    max-height: 400px;
    object-fit: cover;
}

.remove-media {
    position: absolute;
    top: 8px;
    right: 8px;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: rgba(255,255,255,0.9);
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    color: #050505;
}

.fb-actions {
    border: 1px solid #e4e6eb;
    border-radius: 8px;
    padding: 8px 12px;
    margin-bottom: 1rem;
}

.actions-title {
    font-size: 15px;
    font-weight: 600;
    color: #050505;
    margin-bottom: 8px;
}

.action-buttons {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.action-btn {
    flex: 1;
    min-width: 120px;
    padding: 8px 12px;
    border: 1px solid #e4e6eb;
    border-radius: 8px;
    background: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-size: 15px;
    font-weight: 500;
    transition: background 0.2s;
}

.action-btn:hover {
    background: #f2f3f5;
}

.action-btn i {
    font-size: 24px;
}

.categories-section {
    margin-bottom: 1rem;
}

.categories-title {
    font-size: 15px;
    font-weight: 600;
    color: #050505;
    margin-bottom: 8px;
}

.categories-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.category-tag {
    display: none;
}

.category-label {
    padding: 8px 16px;
    border-radius: 20px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s;
    border: 2px solid transparent;
}

.category-tag:checked + .category-label {
    border-color: currentColor;
    transform: scale(1.05);
}

.tags-section {
    margin-bottom: 1rem;
}

.tags-title {
    font-size: 15px;
    font-weight: 600;
    color: #050505;
    margin-bottom: 8px;
}

.submit-btn {
    width: 100%;
    padding: 12px;
    background: #5BA3D0;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s;
}

.submit-btn:hover {
    background: #4a92bf;
}

.submit-btn:disabled {
    background: #e4e6eb;
    color: #bcc0c4;
    cursor: not-allowed;
}

@media (max-width: 768px) {
    .fb-textarea {
        font-size: 20px;
    }
    
    .action-btn {
        min-width: 100px;
        font-size: 14px;
    }
}
</style>
@endpush

@section('content')
<div class="fb-create-post">
    <div class="fb-post-card">
        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" id="postForm">
            @csrf
            
            <div class="fb-post-header">
                @if(Auth::user()->profile_photo)
                    <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" 
                         alt="{{ Auth::user()->name }}" 
                         class="fb-avatar">
                @else
                    <div class="fb-avatar-placeholder">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif
                <div class="fb-user-info">
                    <h3>{{ Auth::user()->name }}</h3>
                    <div class="fb-privacy">
                        <i class="bi bi-globe"></i>
                        <span>Public</span>
                    </div>
                </div>
            </div>

            <div class="fb-content-area">
                <textarea 
                    id="contentArea" 
                    name="content" 
                    class="fb-textarea" 
                    placeholder="Bạn đang nghĩ gì?"
                    required>{{ old('content') }}</textarea>
                
                <!-- Hidden title field - will be auto-generated from content -->
                <input type="hidden" name="title" id="titleField" value="{{ old('title') }}">
                
                <!-- Background input -->
                <input type="hidden" name="background" id="backgroundField" value="">
            </div>

            <!-- Background Selector (only show when no media) -->
            <div class="background-selector" id="backgroundSelector">
                <div class="actions-title">Chọn màu nền</div>
                <div class="bg-options">
                    <label class="bg-option bg-none selected">
                        <input type="radio" name="bg" value="" checked>
                    </label>
                    <label class="bg-option bg-gradient-1">
                        <input type="radio" name="bg" value="gradient-1">
                    </label>
                    <label class="bg-option bg-gradient-2">
                        <input type="radio" name="bg" value="gradient-2">
                    </label>
                    <label class="bg-option bg-gradient-3">
                        <input type="radio" name="bg" value="gradient-3">
                    </label>
                    <label class="bg-option bg-gradient-4">
                        <input type="radio" name="bg" value="gradient-4">
                    </label>
                    <label class="bg-option bg-gradient-5">
                        <input type="radio" name="bg" value="gradient-5">
                    </label>
                    <label class="bg-option bg-gradient-6">
                        <input type="radio" name="bg" value="gradient-6">
                    </label>
                    <label class="bg-option bg-gradient-7">
                        <input type="radio" name="bg" value="gradient-7">
                    </label>
                    <label class="bg-option bg-gradient-8">
                        <input type="radio" name="bg" value="gradient-8">
                    </label>
                </div>
            </div>

            <!-- Media Preview -->
            <div class="media-preview" id="imagePreview" style="display: none;">
                <img id="imagePreviewImg" src="" alt="Preview">
                <button type="button" class="remove-media" onclick="removeImage()">×</button>
            </div>

            <div class="media-preview" id="videoPreview" style="display: none;">
                <video id="videoPreviewVideo" controls></video>
                <button type="button" class="remove-media" onclick="removeVideo()">×</button>
            </div>

            <div class="fb-actions">
                <div class="actions-title">Thêm vào bài viết</div>
                <div class="action-buttons">
                    <label class="action-btn" for="imageInput">
                        <i class="bi bi-image" style="color: #45bd62;"></i>
                        <span>Ảnh</span>
                        <input type="file" id="imageInput" name="image" accept="image/*" style="display: none;">
                    </label>
                    <label class="action-btn" for="videoInput">
                        <i class="bi bi-camera-video" style="color: #f3425f;"></i>
                        <span>Video</span>
                        <input type="file" id="videoInput" name="video" accept="video/*" style="display: none;">
                    </label>
                    <button type="button" class="action-btn" onclick="toggleBackground()">
                        <i class="bi bi-palette" style="color: #5BA3D0;"></i>
                        <span>Màu nền</span>
                    </button>
                </div>
            </div>

            <div class="categories-section">
                <div class="categories-title">Tag</div>
                <div class="categories-grid">
                    <label>
                        <input type="checkbox" name="categories[]" value="anime" class="category-tag">
                        <span class="category-label" style="background-color: #FF6B6B20; color: #FF6B6B;">
                            🎌 Anime
                        </span>
                    </label>
                    <label>
                        <input type="checkbox" name="categories[]" value="manga" class="category-tag">
                        <span class="category-label" style="background-color: #A8E6CF20; color: #4ECDC4;">
                            📚 Manga
                        </span>
                    </label>
                    <label>
                        <input type="checkbox" name="categories[]" value="cosplay" class="category-tag">
                        <span class="category-label" style="background-color: #FFD3B620; color: #FF6B9D;">
                            🎭 Cosplay
                        </span>
                    </label>
                    <label>
                        <input type="checkbox" name="categories[]" value="discussion" class="category-tag">
                        <span class="category-label" style="background-color: #C7B3FF20; color: #9B7EDE;">
                            💬 Discussion
                        </span>
                    </label>
                </div>
            </div>

            <button type="submit" class="submit-btn" id="submitBtn">Đăng bài</button>
        </form>
    </div>
</div>

<script>
// Elements
const contentArea = document.getElementById('contentArea');
const titleField = document.getElementById('titleField');
const backgroundField = document.getElementById('backgroundField');
const backgroundSelector = document.getElementById('backgroundSelector');
const imageInput = document.getElementById('imageInput');
const videoInput = document.getElementById('videoInput');
const imagePreview = document.getElementById('imagePreview');
const videoPreview = document.getElementById('videoPreview');
const imagePreviewImg = document.getElementById('imagePreviewImg');
const videoPreviewVideo = document.getElementById('videoPreviewVideo');
const submitBtn = document.getElementById('submitBtn');
const postForm = document.getElementById('postForm');

let hasImage = false;
let hasVideo = false;

// Update placeholder based on media
function updatePlaceholder() {
    if (hasImage) {
        contentArea.placeholder = 'Bạn nghĩ gì về bức ảnh này?';
        contentArea.classList.add('has-media');
        backgroundSelector.classList.remove('active');
    } else if (hasVideo) {
        contentArea.placeholder = 'Bạn nghĩ gì về video này?';
        contentArea.classList.add('has-media');
        backgroundSelector.classList.remove('active');
    } else {
        contentArea.placeholder = 'Bạn đang nghĩ gì?';
        contentArea.classList.remove('has-media');
    }
}

// Auto-generate title from content
contentArea.addEventListener('input', function() {
    const text = this.value.trim();
    const title = text.substring(0, 100) || 'Untitled Post';
    titleField.value = title;
});

// Image upload
imageInput.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            imagePreviewImg.src = e.target.result;
            imagePreview.style.display = 'block';
            hasImage = true;
            hasVideo = false;
            videoPreview.style.display = 'none';
            videoInput.value = '';
            updatePlaceholder();
        };
        reader.readAsDataURL(file);
    }
});

// Video upload
videoInput.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            videoPreviewVideo.src = e.target.result;
            videoPreview.style.display = 'block';
            hasVideo = true;
            hasImage = false;
            imagePreview.style.display = 'none';
            imageInput.value = '';
            updatePlaceholder();
        };
        reader.readAsDataURL(file);
    }
});

// Remove image
function removeImage() {
    imageInput.value = '';
    imagePreview.style.display = 'none';
    hasImage = false;
    updatePlaceholder();
}

// Remove video
function removeVideo() {
    videoInput.value = '';
    videoPreview.style.display = 'none';
    hasVideo = false;
    updatePlaceholder();
}

// Toggle background selector
function toggleBackground() {
    if (!hasImage && !hasVideo) {
        backgroundSelector.classList.toggle('active');
    }
}

// Background selection
document.querySelectorAll('.bg-option').forEach(option => {
    option.addEventListener('click', function() {
        document.querySelectorAll('.bg-option').forEach(opt => opt.classList.remove('selected'));
        this.classList.add('selected');
        const bgValue = this.querySelector('input').value;
        backgroundField.value = bgValue;
        
        // Apply background to content area
        const contentAreaWrapper = document.querySelector('.fb-content-area');
        const textarea = document.getElementById('contentArea');
        
        if (bgValue) {
            // Remove existing background classes
            contentAreaWrapper.className = 'fb-content-area';
            contentAreaWrapper.classList.add('bg-' + bgValue);
            textarea.classList.add('has-background');
            
            // Apply gradient
            const gradients = {
                'gradient-1': 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                'gradient-2': 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
                'gradient-3': 'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)',
                'gradient-4': 'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)',
                'gradient-5': 'linear-gradient(135deg, #fa709a 0%, #fee140 100%)',
                'gradient-6': 'linear-gradient(135deg, #30cfd0 0%, #330867 100%)',
                'gradient-7': 'linear-gradient(135deg, #a8edea 0%, #fed6e3 100%)',
                'gradient-8': 'linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%)'
            };
            contentAreaWrapper.style.background = gradients[bgValue];
        } else {
            // Reset to default
            contentAreaWrapper.className = 'fb-content-area';
            contentAreaWrapper.style.background = '';
            textarea.classList.remove('has-background');
        }
    });
});

// Form validation
postForm.addEventListener('submit', function(e) {
    const content = contentArea.value.trim();
    if (!content) {
        e.preventDefault();
        alert('Vui lòng nhập nội dung bài viết');
        return false;
    }
    
    // Auto-generate title if empty
    if (!titleField.value) {
        titleField.value = content.substring(0, 100) || 'Untitled Post';
    }
});
</script>
@endsection