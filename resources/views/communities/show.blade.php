@extends('layouts.app')

@section('title', $community->name . ' - AnimeTalk')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/communities.css') }}">
<style>
@media (max-width: 992px) {
    div[style*="grid-template-columns: 1fr 350px"] {
        grid-template-columns: 1fr !important;
    }
    div[style*="grid-template-columns: 1fr 350px"] > div:last-child {
        display: none;
    }
}
</style>
@endpush

@section('content')
<div class="community-detail-page">
    <!-- Banner Section -->
    <div class="community-banner">
        @if($community->banner)
        <img src="{{ asset('storage/' . $community->banner) }}" alt="{{ $community->name }}" style="width: 100%; height: 100%; object-fit: cover;">
        @else
        <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #5BA3D0, #9B7EDE);"></div>
        @endif
    </div>

    <!-- Community Header -->
    <div style="background: white; border-bottom: 1px solid #e0e0e0;">
        <div class="community-header-container">
            <div class="community-header-content">
                <!-- Community Icon -->
                @if($community->icon)
                <img src="{{ asset('storage/' . $community->icon) }}" alt="{{ $community->name }}" class="community-icon">
                @else
                <div class="community-icon-placeholder">
                    {{ strtoupper(substr($community->name, 0, 1)) }}
                </div>
                @endif

                <!-- Community Info -->
                <div style="flex: 1;">
                    <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 0.5rem;">{{ $community->name }}</h1>
                    <div style="display: flex; align-items: center; gap: 1rem; color: #666; font-size: 0.9rem; margin-bottom: 0.75rem;">
                        <span><i class="bi bi-people"></i> {{ $community->members_count }} members</span>
                        <span>•</span>
                        <span style="background: rgba(91, 163, 208, 0.1); color: #5BA3D0; padding: 0.25rem 0.75rem; border-radius: 12px; font-weight: 600;">
                            {{ $community->category }}
                        </span>
                        @if($community->is_private)
                        <span style="background: rgba(155, 126, 222, 0.1); color: #9B7EDE; padding: 0.25rem 0.75rem; border-radius: 12px; font-weight: 600;">
                            <i class="bi bi-lock"></i> Private
                        </span>
                        @endif
                    </div>
                    <p style="color: #555; line-height: 1.6;">{{ $community->description }}</p>
                </div>

                <!-- Action Button -->
                @auth
                    @if($community->isOwner(auth()->user()))
                    <div style="margin-top: 1rem; display: flex; gap: 0.75rem;">
                        <span style="display: inline-block; padding: 0.75rem 1.5rem; background: rgba(91, 163, 208, 0.1); color: #5BA3D0; border-radius: 8px; font-weight: 600;">
                            <i class="bi bi-star-fill"></i> Owner
                        </span>
                        <a href="{{ route('communities.edit', $community->slug) }}" 
                           style="display: inline-block; padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; border-radius: 8px; text-decoration: none; font-weight: 600;">
                            <i class="bi bi-pencil"></i> Edit Community
                        </a>
                    </div>
                    @elseif($community->isMember(auth()->user()))
                    <div style="margin-top: 1rem; display: flex; gap: 0.75rem;">
                        <button onclick="openCameraModal()" 
                                style="display: inline-block; padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; position: relative;">
                            <i class="bi bi-camera"></i> Tạo Kỷ Niệm
                            @if(auth()->check() && auth()->user()->uid === $community->user_id && $pendingMemoriesCount > 0)
                            <span style="position: absolute; top: -8px; right: -8px; background: #ff4444; color: white; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: bold; border: 2px solid white;">
                                {{ $pendingMemoriesCount }}
                            </span>
                            @endif
                        </button>
                        <form action="{{ route('communities.leave', $community) }}" method="POST">
                            @csrf
                            <button type="submit" onclick="return confirm('Are you sure you want to leave this community?')"
                                    style="padding: 0.75rem 1.5rem; background: #f0f0f0; color: #333; border: 1px solid #e0e0e0; border-radius: 8px; font-weight: 600; cursor: pointer;">
                                <i class="bi bi-box-arrow-right"></i> Leave
                            </button>
                        </form>
                    </div>
                    @else
                    <form action="{{ route('communities.join', $community) }}" method="POST" style="margin-top: 1rem;">
                        @csrf
                        <button type="submit" 
                                style="padding: 0.75rem 2rem; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                            <i class="bi bi-plus-circle"></i> Join
                        </button>
                    </form>
                    @endif
                @else
                <a href="{{ route('login') }}" style="display: inline-block; margin-top: 1rem; padding: 0.75rem 2rem; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; border-radius: 8px; text-decoration: none; font-weight: 600;">
                    <i class="bi bi-plus-circle"></i> Join
                </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div style="max-width: 1200px; margin: 0 auto; padding: 2rem;">
        <div style="display: grid; grid-template-columns: 1fr 350px; gap: 2rem;">
            <!-- Left Column - Main Content -->
            <div>
                <!-- Tabs Navigation -->
                <div style="background: white; border-radius: 12px; margin-bottom: 1.5rem; border: 1px solid #e0e0e0; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                    <div style="display: flex; border-bottom: 2px solid #f0f0f0;">
                        <button class="community-tab active" data-tab="memories" style="flex: 1; padding: 1rem; background: none; border: none; border-bottom: 3px solid #5BA3D0; font-weight: 600; cursor: pointer; color: #5BA3D0;">
                            <i class="bi bi-images"></i> Kỷ Niệm
                        </button>
                        @if(auth()->check() && auth()->user()->uid === $community->user_id)
                        <button class="community-tab" data-tab="pending" style="flex: 1; padding: 1rem; background: none; border: none; border-bottom: 3px solid transparent; font-weight: 600; cursor: pointer; color: #666; position: relative;">
                            <i class="bi bi-clock-history"></i> Chờ Duyệt
                            @if(isset($pendingMemoriesCount) && $pendingMemoriesCount > 0)
                            <span style="background: #ff4444; color: white; border-radius: 50%; width: 24px; height: 24px; display: inline-flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: bold; margin-left: 0.5rem;">
                                {{ $pendingMemoriesCount }}
                            </span>
                            @endif
                        </button>
                        @endif
                        <button class="community-tab" data-tab="chat" style="flex: 1; padding: 1rem; background: none; border: none; border-bottom: 3px solid transparent; font-weight: 600; cursor: pointer; color: #666;">
                            <i class="bi bi-chat-dots"></i> Group Chat
                        </button>
                    </div>
                </div>

            <!-- Memories Tab Content -->
            <div class="tab-content" id="memories-tab">
                <div id="community-memories">
                    @forelse($memories as $memory)
                    <div class="memory-card" style="background: white; border-radius: 16px; overflow: hidden; margin-bottom: 1.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        
                        <!-- Memory Image -->
                        <div style="position: relative; width: 100%; aspect-ratio: 4/5; background: #000;">
                            <img src="{{ asset('storage/' . $memory->image) }}" style="width: 100%; height: 100%; object-fit: cover;">
                            
                            <!-- User Info Overlay -->
                            <div style="position: absolute; top: 1rem; left: 1rem; right: 1rem; display: flex; justify-content: space-between; align-items: center;">
                                <div style="display: flex; align-items: center; gap: 0.5rem; background: rgba(0,0,0,0.5); padding: 0.5rem 0.75rem; border-radius: 20px; backdrop-filter: blur(10px);">
                                    <img src="{{ $memory->user->profile_photo ? asset('storage/' . $memory->user->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode($memory->user->name) }}" style="width: 32px; height: 32px; border-radius: 50%; border: 2px solid white;">
                                    <span style="color: white; font-weight: 600; font-size: 0.9rem;">{{ $memory->user->name }}</span>
                                    <span style="color: rgba(255,255,255,0.8); font-size: 0.8rem;">{{ $memory->created_at->diffForHumans() }}</span>
                                </div>
                                
                                @if(auth()->check() && (auth()->user()->uid === $memory->user_id || auth()->user()->uid === $community->user_id))
                                <form method="POST" action="{{ route('memories.destroy', $memory) }}" style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Xóa kỷ niệm này?')" style="background: rgba(255,0,0,0.7); border: none; color: white; padding: 0.5rem; border-radius: 50%; width: 36px; height: 36px; cursor: pointer; backdrop-filter: blur(10px);">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                            
                            <!-- Caption Overlay -->
                            @if($memory->caption)
                            <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.8)); padding: 2rem 1rem 1rem; color: white;">
                                <p style="margin: 0; font-size: 1rem; line-height: 1.5;">{{ $memory->caption }}</p>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Reactions Section -->
                        <div style="padding: 1rem; border-bottom: 1px solid #f0f0f0;">
                            <div style="display: flex; gap: 0.5rem; flex-wrap: wrap; margin-bottom: 0.75rem;">
                                @foreach($memory->reactionCounts as $emoji => $count)
                                <span style="background: #f0f0f0; padding: 0.4rem 0.75rem; border-radius: 20px; font-size: 0.9rem; font-weight: 600;">
                                    {{ $emoji }} {{ $count }}
                                </span>
                                @endforeach
                            </div>
                            
                            @auth
                            <div style="display: flex; gap: 0.5rem;">
                                @foreach(['❤️', '😂', '😍', '🔥', '👏', '😮'] as $emoji)
                                <button onclick="toggleReaction({{ $memory->id }}, '{{ $emoji }}')" style="background: #f8f8f8; border: 1px solid #e0e0e0; padding: 0.5rem 0.75rem; border-radius: 20px; font-size: 1.2rem; cursor: pointer; transition: all 0.2s;">
                                    {{ $emoji }}
                                </button>
                                @endforeach
                            </div>
                            @endauth
                        </div>
                        
                        <!-- Comments Section -->
                        <div style="padding: 1rem;">
                            <div style="margin-bottom: 1rem;">
                                @forelse($memory->comments as $comment)
                                <div style="display: flex; gap: 0.75rem; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #f5f5f5;">
                                    <img src="{{ $comment->user->profile_photo ? asset('storage/' . $comment->user->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name) }}" style="width: 36px; height: 36px; border-radius: 50%; flex-shrink: 0;">
                                    <div style="flex: 1;">
                                        <div style="display: flex; gap: 0.5rem; align-items: center; margin-bottom: 0.25rem;">
                                            <span style="font-weight: 600; font-size: 0.9rem; color: #333;">{{ $comment->user->name }}</span>
                                            <span style="font-size: 0.75rem; color: #999;">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p style="margin: 0; color: #666; font-size: 0.95rem; line-height: 1.5;">{{ $comment->content }}</p>
                                    </div>
                                    @if(auth()->check() && auth()->user()->uid === $comment->user_id)
                                    <form method="POST" action="{{ route('comments.destroy', $comment) }}" style="margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background: none; border: none; color: #999; cursor: pointer; padding: 0.25rem;">
                                            <i class="bi bi-trash" style="font-size: 0.9rem;"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                                @empty
                                <p style="color: #999; font-size: 0.9rem; text-align: center; margin: 1rem 0;">Chưa có bình luận</p>
                                @endforelse
                            </div>
                            
                            <!-- Add Comment Form -->
                            @auth
                            <div style="display: flex; gap: 0.5rem; margin-top: 1rem;">
                                <input type="text" placeholder="Viết bình luận..." style="flex: 1; padding: 0.75rem; border: 1px solid #e0e0e0; border-radius: 20px; font-size: 0.9rem;" disabled>
                                <button type="button" style="background: #ccc; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 20px; font-weight: 600; cursor: not-allowed;" disabled>
                                    Gửi
                                </button>
                            </div>
                            @endauth
                        </div>
                    </div>
                    @empty
                    <div style="background: white; border-radius: 12px; padding: 3rem; text-align: center; color: #999;">
                        <i class="bi bi-images" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                        <p style="margin: 0; font-size: 1.1rem;">Chưa có kỷ niệm nào. Hãy tạo kỷ niệm đầu tiên!</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Pending Memories Tab Content (Owner Only) -->
            @if(auth()->check() && auth()->user()->uid === $community->user_id)
            <div class="tab-content" id="pending-tab" style="display: none;">
                <div style="background: linear-gradient(135deg, #FFA500, #FF8C00); color: white; padding: 1.5rem; border-radius: 12px; margin-bottom: 1.5rem;">
                    <h3 style="margin: 0 0 0.5rem 0; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="bi bi-clock-history"></i> Kỷ Niệm Chờ Duyệt
                    </h3>
                    <p style="margin: 0; opacity: 0.9;">Có {{ $pendingMemoriesCount }} kỷ niệm đang chờ bạn duyệt</p>
                </div>

                <div id="pending-memories">
                    @forelse($pendingMemories as $memory)
                    <div class="memory-card" style="background: white; border-radius: 16px; overflow: hidden; margin-bottom: 1.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border: 2px solid #FFA500;">
                        <!-- Pending Header -->
                        <div style="background: linear-gradient(135deg, #FFA500, #FF8C00); color: white; padding: 1rem; display: flex; align-items: center; justify-content: space-between;">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <img src="{{ $memory->user->profile_photo ? asset('storage/' . $memory->user->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode($memory->user->name) }}" style="width: 40px; height: 40px; border-radius: 50%; border: 2px solid white;">
                                <div>
                                    <div style="font-weight: 600;">{{ $memory->user->name }}</div>
                                    <div style="font-size: 0.85rem; opacity: 0.9;">{{ $memory->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                            <div style="display: flex; gap: 0.5rem;">
                                <form method="POST" action="{{ route('memories.approve', $memory) }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" style="background: #4CAF50; color: white; border: none; padding: 0.75rem 1.25rem; border-radius: 8px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 0.5rem;">
                                        <i class="bi bi-check-circle"></i> Duyệt
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('memories.reject', $memory) }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Từ chối kỷ niệm này?')" style="background: #f44336; color: white; border: none; padding: 0.75rem 1.25rem; border-radius: 8px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 0.5rem;">
                                        <i class="bi bi-x-circle"></i> Từ chối
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Memory Image -->
                        <div style="position: relative; width: 100%; aspect-ratio: 4/5; background: #000;">
                            <img src="{{ asset('storage/' . $memory->image) }}" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>

                        <!-- Caption -->
                        @if($memory->caption)
                        <div style="padding: 1rem; background: #f9fafb;">
                            <p style="margin: 0; color: #333; line-height: 1.6;">{{ $memory->caption }}</p>
                        </div>
                        @endif
                    </div>
                    @empty
                    <div style="text-align: center; padding: 4rem 2rem; background: white; border-radius: 12px;">
                        <i class="bi bi-check-circle" style="font-size: 4rem; color: #4CAF50; margin-bottom: 1rem;"></i>
                        <p style="margin: 0; font-size: 1.1rem; color: #666;">Không có kỷ niệm nào đang chờ duyệt</p>
                    </div>
                    @endforelse
                </div>
            </div>
            @endif

            <!-- Chat Tab Content -->
            <div class="tab-content" id="chat-tab" style="display: none;">
                @auth
                @if($community->isMember(auth()->user()))
                <div style="background: white; border-radius: 12px; border: 1px solid #e0e0e0; overflow: hidden; height: 600px; display: flex; flex-direction: column;">
                    <!-- Chat Header -->
                    <div style="padding: 1rem; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; font-weight: 600;">
                        <i class="bi bi-chat-dots"></i> {{ $community->name }} - Group Chat
                    </div>

                    <!-- Messages Container -->
                    <div id="chat-messages" style="flex: 1; overflow-y: auto; padding: 1rem; background: #f9fafb;">
                        <p style="text-align: center; color: #999;">Loading messages...</p>
                    </div>

                    <!-- Chat Input -->
                    <div style="padding: 1rem; background: white; border-top: 1px solid #e0e0e0;">
                        <form id="chat-form" style="display: flex; gap: 0.75rem;">
                            @csrf
                            <input type="text" id="chat-message-input" placeholder="Type a message..." 
                                   style="flex: 1; padding: 0.75rem; border: 1px solid #e0e0e0; border-radius: 8px; font-family: inherit;">
                            <label for="chat-image-input" style="padding: 0.75rem; background: #f0f0f0; border-radius: 8px; cursor: pointer; display: flex; align-items: center;">
                                <i class="bi bi-image" style="font-size: 1.25rem; color: #666;"></i>
                                <input type="file" id="chat-image-input" accept="image/*" style="display: none;">
                            </label>
                            <button type="submit" style="padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                                <i class="bi bi-send"></i> Send
                            </button>
                        </form>
                        <div id="image-preview-chat" style="margin-top: 0.5rem; display: none;">
                            <div style="position: relative; display: inline-block;">
                                <img id="preview-chat-img" style="max-width: 100px; border-radius: 8px; border: 1px solid #e0e0e0;">
                                <button type="button" onclick="removeChatImage()" style="position: absolute; top: -8px; right: -8px; background: #ff4444; color: white; border: none; border-radius: 50%; width: 24px; height: 24px; cursor: pointer; font-size: 0.8rem;">×</button>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div style="background: white; border-radius: 12px; padding: 3rem; text-align: center; border: 1px solid #e0e0e0;">
                    <i class="bi bi-lock" style="font-size: 3rem; color: #ccc;"></i>
                    <p style="margin-top: 1rem; color: #666;">You need to join this community to access the chat</p>
                </div>
                @endif
                @else
                <div style="background: white; border-radius: 12px; padding: 3rem; text-align: center; border: 1px solid #e0e0e0;">
                    <i class="bi bi-lock" style="font-size: 3rem; color: #ccc;"></i>
                    <p style="margin-top: 1rem; color: #666;">Please login to access the chat</p>
                </div>
                @endauth
            </div>

            <!-- Pending Tab Content (Owner/Moderator only) -->
            @if($community->canManagePosts(auth()->user()))
            <div class="tab-content" id="pending-tab" style="display: none;">
                <div id="pending-posts-container" style="background: white; border-radius: 12px; padding: 1.5rem; border: 1px solid #e0e0e0; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                    <p style="text-align: center; color: #999;">Loading pending posts...</p>
                </div>
            </div>
            @endif
            </div>

            <!-- Right Sidebar -->
            <div>
                <!-- Recent Activities -->
                <div style="background: white; border-radius: 12px; padding: 1.5rem; border: 1px solid #e0e0e0; margin-bottom: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                    <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1rem; color: #333;">
                        <i class="bi bi-activity"></i> Recent Activities
                    </h3>
                    <div style="max-height: 400px; overflow-y: auto;">
                        @forelse($activities as $activity)
                        <div style="display: flex; align-items: start; gap: 0.75rem; padding: 0.75rem 0; border-bottom: 1px solid #f0f0f0;">
                            @if($activity->user && $activity->user->profile_photo)
                            <img src="{{ asset('storage/' . $activity->user->profile_photo) }}" alt="{{ $activity->user->name }}" 
                                 style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; flex-shrink: 0;">
                            @elseif($activity->user)
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.85rem; flex-shrink: 0;">
                                {{ strtoupper(substr($activity->user->name, 0, 1)) }}
                            </div>
                            @else
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: #ccc; flex-shrink: 0;"></div>
                            @endif
                            
                            <div style="flex: 1; min-width: 0;">
                                <div style="font-size: 0.85rem; color: #333; line-height: 1.4;">
                                    @if($activity->type === 'joined')
                                        <strong>{{ $activity->user->name ?? 'User' }}</strong> <span style="color: #28a745;">joined</span> the community
                                    @elseif($activity->type === 'left')
                                        <strong>{{ $activity->user->name ?? 'User' }}</strong> <span style="color: #dc3545;">left</span> the community
                                    @elseif($activity->type === 'created')
                                        <strong>{{ $activity->user->name ?? 'User' }}</strong> <span style="color: #5BA3D0;">created</span> the community
                                    @elseif($activity->type === 'posted')
                                        <strong>{{ $activity->user->name ?? 'User' }}</strong> posted in the community
                                    @else
                                        {{ $activity->description }}
                                    @endif
                                </div>
                                <div style="font-size: 0.75rem; color: #999; margin-top: 0.25rem;">
                                    {{ $activity->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                        @empty
                        <p style="color: #999; text-align: center; padding: 1rem;">No activities yet</p>
                        @endforelse
                    </div>
                </div>

                <!-- About -->
                <div style="background: white; border-radius: 12px; padding: 1.5rem; border: 1px solid #e0e0e0; margin-bottom: 1.5rem;">
                    <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1rem;">About Community</h3>
                    <div style="color: #555; line-height: 1.6; margin-bottom: 1rem;">
                        {{ $community->description }}
                    </div>
                    <div style="padding-top: 1rem; border-top: 1px solid #e0e0e0;">
                        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                            <i class="bi bi-calendar3" style="color: #5BA3D0;"></i>
                            <span style="color: #666; font-size: 0.9rem;">Created {{ $community->created_at->diffForHumans() }}</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <i class="bi bi-people" style="color: #5BA3D0;"></i>
                            <span style="color: #666; font-size: 0.9rem;">{{ $community->members_count }} members</span>
                        </div>
                    </div>
                </div>

                <!-- Members -->
                <div style="background: white; border-radius: 12px; padding: 1.5rem; border: 1px solid #e0e0e0;">
                    <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1rem;">
                        Members ({{ $community->members()->count() }})
                    </h3>
                    <div style="max-height: 400px; overflow-y: auto;">
                        @forelse($community->members()->latest('community_members.created_at')->take(20)->get() as $member)
                        <div style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 0; border-bottom: 1px solid #f0f0f0;">
                            @if($member->profile_photo)
                            <img src="{{ asset('storage/' . $member->profile_photo) }}" alt="{{ $member->name }}" 
                                 style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                            @else
                            <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700;">
                                {{ strtoupper(substr($member->name, 0, 1)) }}
                            </div>
                            @endif
                            
                            <div style="flex: 1; min-width: 0;">
                                <div style="font-weight: 600; font-size: 0.9rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $member->name }}
                                </div>
                                <div style="font-size: 0.8rem; color: #666;">
                                    {{ ucfirst($member->pivot->role) }}
                                </div>
                            </div>

                            @if(auth()->check() && $community->isOwner(auth()->user()) && $member->uid !== auth()->user()->uid)
                            <form action="{{ route('communities.removeMember', [$community, $member->uid]) }}" method="POST" onsubmit="return confirm('Remove this member?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: #ff4444; cursor: pointer; padding: 0.25rem;">
                                    <i class="bi bi-x-circle"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                        @empty
                        <p style="color: #999; text-align: center; padding: 1rem;">No members yet</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Tab switching
document.querySelectorAll('.community-tab').forEach(tab => {
    tab.addEventListener('click', function() {
        // Remove active class from all tabs
        document.querySelectorAll('.community-tab').forEach(t => {
            t.classList.remove('active');
            t.style.borderBottom = '3px solid transparent';
            t.style.color = '#666';
        });
        
        // Add active class to clicked tab
        this.classList.add('active');
        this.style.borderBottom = '3px solid #5BA3D0';
        this.style.color = '#5BA3D0';
        
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(content => {
            content.style.display = 'none';
        });
        
        // Show selected tab content
        const tabName = this.dataset.tab;
        document.getElementById(tabName + '-tab').style.display = 'block';
        
        // Load posts if posts tab
        if (tabName === 'posts' && !window.postsLoaded) {
            loadPosts();
        }
    });
});

// Check if URL has hash to auto-open chat tab
if (window.location.hash === '#chat-tab') {
    document.querySelector('.community-tab[data-tab="chat"]')?.click();
}

// Like/Comment functions
function toggleLike(postId, modelType) {
    fetch('/posts/toggle-like', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            post_id: postId,
            model_type: modelType
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('likes-count-' + postId).textContent = data.likes_count;
            const btn = event.target.closest('button');
            const icon = btn.querySelector('i');
            if (data.liked) {
                icon.classList.remove('bi-heart');
                icon.classList.add('bi-heart-fill');
                btn.style.color = '#ff4444';
            } else {
                icon.classList.remove('bi-heart-fill');
                icon.classList.add('bi-heart');
                btn.style.color = '#666';
            }
        }
    });
}

function toggleComments(postId) {
    const section = document.getElementById('comments-section-' + postId);
    section.style.display = section.style.display === 'none' ? 'block' : 'none';
}

function addComment(postId, modelType) {
    const input = document.getElementById('comment-input-' + postId);
    const content = input.value.trim();
    
    if (!content) return;
    
    fetch('/posts/add-comment', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            post_id: postId,
            content: content,
            model_type: modelType
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            input.value = '';
            document.getElementById('comments-count-' + postId).textContent = data.comments_count;
            location.reload(); // Reload để hiển thị comment mới
        }
    });
}



// Chat functionality
@auth
@if($community->isMember(auth()->user()))
let lastMessageId = 0;
let chatActive = false;

function loadChatMessages() {
    fetch('{{ route('communities.chat.messages', $community->slug) }}?last_id=' + lastMessageId)
        .then(response => response.json())
        .then(data => {
            if (data.messages && data.messages.length > 0) {
                const container = document.getElementById('chat-messages');
                
                // Remove loading message if exists
                if (container.querySelector('p')) {
                    container.innerHTML = '';
                }
                
                data.messages.reverse().forEach(msg => {
                    appendMessage(msg);
                    lastMessageId = Math.max(lastMessageId, msg.id);
                });
                
                // Scroll to bottom
                container.scrollTop = container.scrollHeight;
            }
        })
        .catch(error => console.error('Error loading messages:', error));
}

function appendMessage(msg) {
    const container = document.getElementById('chat-messages');
    const messageDiv = document.createElement('div');
    messageDiv.style.cssText = 'margin-bottom: 1rem; animation: fadeIn 0.3s;';
    
    let avatarHtml = '';
    if (msg.user.profile_photo) {
        avatarHtml = `<img src="/storage/${msg.user.profile_photo}" alt="${msg.user.name}" style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover;">`;
    } else {
        avatarHtml = `<div style="width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700;">${msg.user.name.charAt(0).toUpperCase()}</div>`;
    }
    
    let imageHtml = '';
    if (msg.image) {
        imageHtml = `<div style="margin-top: 0.5rem;"><img src="/storage/${msg.image}" style="max-width: 300px; border-radius: 8px; cursor: pointer;"></div>`;
    }
    
    const timeAgo = new Date(msg.created_at).toLocaleTimeString();
    
    messageDiv.innerHTML = `
        <div style="display: flex; align-items: start; gap: 0.5rem; margin-bottom: 0.5rem;">
            ${avatarHtml}
            <div>
                <span style="font-weight: 600; color: #333;">${msg.user.name}</span>
                <span style="font-size: 0.8rem; color: #999; margin-left: 0.5rem;">${timeAgo}</span>
            </div>
        </div>
        <div style="margin-left: 44px; background: white; padding: 0.75rem; border-radius: 8px; border: 1px solid #e0e0e0; word-wrap: break-word;">
            ${msg.message || ''}
            ${imageHtml}
        </div>
    `;
    
    container.appendChild(messageDiv);
}

// Submit chat message
document.getElementById('chat-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const messageInput = document.getElementById('chat-message-input');
    const imageInput = document.getElementById('chat-image-input');
    const message = messageInput.value.trim();
    
    if (!message && !imageInput.files[0]) return;
    
    const formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    if (message) formData.append('message', message);
    if (imageInput.files[0]) formData.append('image', imageInput.files[0]);
    
    fetch('{{ route('communities.chat.store', $community->slug) }}', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            messageInput.value = '';
            imageInput.value = '';
            removeChatImage();
            appendMessage(data.message);
            document.getElementById('chat-messages').scrollTop = document.getElementById('chat-messages').scrollHeight;
        }
    })
    .catch(error => console.error('Error sending message:', error));
});

// Image preview
document.getElementById('chat-image-input').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-chat-img').src = e.target.result;
            document.getElementById('image-preview-chat').style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});

function removeChatImage() {
    document.getElementById('chat-image-input').value = '';
    document.getElementById('image-preview-chat').style.display = 'none';
}

// Poll for new messages every 3 seconds when chat tab is active
setInterval(() => {
    if (chatActive) {
        loadChatMessages();
    }
}, 3000);

// Load messages when chat tab is opened
document.querySelector('.community-tab[data-tab="chat"]')?.addEventListener('click', function() {
    chatActive = true;
    loadChatMessages();
});

// Stop polling when leaving chat tab
document.querySelectorAll('.community-tab:not([data-tab="chat"])').forEach(tab => {
    tab.addEventListener('click', () => {
        chatActive = false;
    });
});

// Like and Comment Functions
function toggleLike(postId, modelType) {
    console.log('toggleLike called:', postId, modelType);
    
    fetch('/posts/toggle-like', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            post_id: postId,
            model_type: modelType
        })
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            const likeBtn = document.querySelector(`button[onclick*="toggleLike(${postId}"]`);
            const likeIcon = likeBtn.querySelector('i');
            const likeCount = document.getElementById(`likes-count-${postId}`);
            
            if (data.liked) {
                likeIcon.className = 'bi bi-heart-fill';
                likeBtn.style.color = '#ff4444';
            } else {
                likeIcon.className = 'bi bi-heart';
                likeBtn.style.color = '#666';
            }
            
            likeCount.textContent = data.likes_count;
        }
    })
    .catch(error => console.error('Error:', error));
}

function toggleComments(postId) {
    console.log('toggleComments called:', postId);
    const commentsSection = document.getElementById(`comments-section-${postId}`);
    console.log('Comments section element:', commentsSection);
    if (commentsSection.style.display === 'none' || !commentsSection.style.display) {
        commentsSection.style.display = 'block';
    } else {
        commentsSection.style.display = 'none';
    }
}

function addComment(postId, modelType) {
    console.log('addComment called:', postId, modelType);
    const input = document.getElementById(`comment-input-${postId}`);
    const content = input.value.trim();
    
    console.log('Comment content:', content);
    
    if (!content) return;
    
    fetch('/posts/add-comment', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            post_id: postId,
            model_type: modelType,
            content: content
        })
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            // Clear input
            input.value = '';
            
            // Reload page to show new comment
            location.reload();
        }
    })
    .catch(error => console.error('Error:', error));
}

// Emoji Picker Functions
function toggleEmojiPicker(postId) {
    const emojiPicker = document.getElementById(`emoji-picker-${postId}`);
    const gifPicker = document.getElementById(`gif-picker-${postId}`);
    
    // Close GIF picker if open
    if (gifPicker) gifPicker.style.display = 'none';
    
    // Toggle emoji picker
    if (emojiPicker.style.display === 'none' || !emojiPicker.style.display) {
        emojiPicker.style.display = 'block';
    } else {
        emojiPicker.style.display = 'none';
    }
}

function insertEmoji(postId, emoji) {
    const textarea = document.getElementById(`comment-textarea-${postId}`);
    const cursorPos = textarea.selectionStart;
    const textBefore = textarea.value.substring(0, cursorPos);
    const textAfter = textarea.value.substring(cursorPos);
    
    textarea.value = textBefore + emoji + textAfter;
    textarea.focus();
    textarea.selectionStart = textarea.selectionEnd = cursorPos + emoji.length;
    
    // Close emoji picker
    document.getElementById(`emoji-picker-${postId}`).style.display = 'none';
}

// GIF Picker Functions
function toggleGifPicker(postId) {
    const gifPicker = document.getElementById(`gif-picker-${postId}`);
    const emojiPicker = document.getElementById(`emoji-picker-${postId}`);
    
    // Close emoji picker if open
    if (emojiPicker) emojiPicker.style.display = 'none';
    
    // Toggle GIF picker
    if (gifPicker.style.display === 'none' || !gifPicker.style.display) {
        gifPicker.style.display = 'block';
        loadTrendingGifs(postId);
    } else {
        gifPicker.style.display = 'none';
    }
}

function loadTrendingGifs(postId) {
    const gifGrid = document.getElementById(`gif-grid-${postId}`);
    const loading = document.getElementById(`gif-loading-${postId}`);
    
    loading.style.display = 'block';
    gifGrid.innerHTML = '';
    
    // Using Giphy API for anime GIFs
    fetch('https://api.giphy.com/v1/gifs/trending?api_key=YOUR_GIPHY_API_KEY&q=anime&limit=10')
        .then(response => response.json())
        .then(data => {
            loading.style.display = 'none';
            data.data.forEach(gif => {
                const img = document.createElement('img');
                img.src = gif.images.fixed_height_small.url;
                img.style.width = '100%';
                img.style.borderRadius = '4px';
                img.style.cursor = 'pointer';
                img.onclick = () => insertGif(postId, gif.images.original.url);
                gifGrid.appendChild(img);
            });
        })
        .catch(error => {
            loading.style.display = 'none';
            console.error('Error loading GIFs:', error);
        });
}

function insertGif(postId, gifUrl) {
    const textarea = document.getElementById(`comment-textarea-${postId}`);
    textarea.value = gifUrl;
    
    // Close GIF picker
    document.getElementById(`gif-picker-${postId}`).style.display = 'none';
    
    // Show preview
    const preview = document.getElementById(`comment-preview-${postId}`);
    const previewImg = document.getElementById(`preview-img-${postId}`);
    previewImg.src = gifUrl;
    preview.style.display = 'block';
}

// Image Preview Functions
function previewCommentImage(postId, event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById(`comment-preview-${postId}`);
            const previewImg = document.getElementById(`preview-img-${postId}`);
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
}

function removeCommentPreview(postId) {
    document.getElementById(`comment-image-input-${postId}`).value = '';
    document.getElementById(`comment-preview-${postId}`).style.display = 'none';
    document.getElementById(`comment-textarea-${postId}`).value = '';
}

// Reaction Toggle
async function toggleReaction(memoryId, emoji) {
    try {
        const response = await fetch(`/memories/${memoryId}/react`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ reaction: emoji })
        });
        
        if (response.ok) {
            location.reload(); // Reload để cập nhật reactions
        }
    } catch (error) {
        console.error('Error toggling reaction:', error);
    }
}

// Camera Modal
let stream = null;

function openCameraModal() {
    const modal = new bootstrap.Modal(document.getElementById('cameraModal'), {
        backdrop: false, // Tắt backdrop để không bị tối
        keyboard: false
    });
    modal.show();
    startCamera();
}

async function startCamera() {
    try {
        stream = await navigator.mediaDevices.getUserMedia({ 
            video: { facingMode: 'user', width: 720, height: 960 } 
        });
        document.getElementById('cameraStream').srcObject = stream;
        document.getElementById('cameraView').style.display = 'block';
        document.getElementById('photoPreviewView').style.display = 'none';
    } catch (error) {
        alert('Không thể truy cập camera: ' + error.message);
    }
}

function capturePhoto() {
    const video = document.getElementById('cameraStream');
    const canvas = document.getElementById('photoCanvas');
    
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    
    // Lật ảnh ngang để khớp với video preview
    const ctx = canvas.getContext('2d');
    ctx.translate(canvas.width, 0);
    ctx.scale(-1, 1);
    ctx.drawImage(video, 0, 0);
    
    canvas.toBlob(blob => {
        const file = new File([blob], 'memory.jpg', { type: 'image/jpeg' });
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        document.getElementById('memoryImageInput').files = dataTransfer.files;
        
        // Show preview
        document.getElementById('photoPreview').src = URL.createObjectURL(blob);
        document.getElementById('cameraView').style.display = 'none';
        document.getElementById('photoPreviewView').style.display = 'block';
        
        // Stop camera
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
        }
    }, 'image/jpeg', 0.9);
}

function retakePhoto() {
    document.getElementById('memoryImageInput').value = '';
    startCamera();
}

document.getElementById('cameraModal')?.addEventListener('hidden.bs.modal', function () {
    if (stream) {
        stream.getTracks().forEach(track => track.stop());
    }
    document.getElementById('memoryForm').reset();
    document.getElementById('cameraView').style.display = 'block';
    document.getElementById('photoPreviewView').style.display = 'none';
});

@endif
@endauth
</script>
@endpush

<!-- Camera Modal -->
<div class="modal fade" id="cameraModal" tabindex="-1" data-bs-backdrop="false">
    <div class="modal-dialog modal-fullscreen" style="z-index: 9999;">
        <div class="modal-content" style="background: #000; z-index: 9999;">
            <div class="modal-header" style="border: none; background: rgba(0,0,0,0.8); backdrop-filter: blur(10px); position: relative; z-index: 10000;">
                <h5 class="modal-title" style="color: white;">📸 Tạo Kỷ Niệm</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" style="z-index: 10001;"></button>
            </div>
            <div class="modal-body" style="padding: 0; display: flex; flex-direction: column; position: relative; z-index: 9999;">
                <!-- Camera View -->
                <div id="cameraView" style="width: 100%; display: flex; flex-direction: column; position: relative; z-index: 9999;">
                    <div style="flex: 1; display: flex; align-items: center; justify-content: center; background: #000;">
                        <video id="cameraStream" autoplay playsinline style="max-width: 100%; max-height: calc(100vh - 150px); object-fit: contain; z-index: 9999; transform: scaleX(-1);"></video>
                    </div>
                    <div style="padding: 1.5rem; background: #000; display: flex; justify-content: center;">
                        <button onclick="capturePhoto()" type="button" style="width: 70px; height: 70px; border-radius: 50%; background: white; border: 5px solid #5BA3D0; cursor: pointer; font-size: 1.5rem; z-index: 10000;">
                            📷
                        </button>
                    </div>
                </div>
                
                <!-- Photo Preview -->
                <div id="photoPreviewView" style="width: 100%; display: none; flex-direction: column; position: relative; z-index: 9999;">
                    <canvas id="photoCanvas" style="display:none;"></canvas>
                    <div style="flex: 1; display: flex; align-items: center; justify-content: center; background: #000;">
                        <img id="photoPreview" style="max-width: 100%; max-height: calc(100vh - 350px); object-fit: contain;">
                    </div>
                    
                    <form id="memoryForm" method="POST" action="{{ route('communities.memories.store', $community->slug) }}" enctype="multipart/form-data" style="width: 100%; padding: 1.5rem; background: #000; position: relative; z-index: 10000;">
                        @csrf
                        <input type="file" id="memoryImageInput" name="image" required style="display:none;">
                        
                        <textarea name="caption" placeholder="Thêm chú thích cho kỷ niệm..." style="width: 100%; padding: 1rem; border: 1px solid rgba(255,255,255,0.3); border-radius: 12px; background: rgba(255,255,255,0.1); color: white; font-size: 1rem; margin-bottom: 1rem; resize: none;" rows="3"></textarea>
                        
                        <div style="display: flex; gap: 1rem;">
                            <button type="button" onclick="retakePhoto()" style="flex: 1; padding: 1rem; background: rgba(255,255,255,0.2); color: white; border: none; border-radius: 12px; font-weight: 600; cursor: pointer;">
                                🔄 Chụp lại
                            </button>
                            <button type="submit" style="flex: 2; padding: 1rem; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; border: none; border-radius: 12px; font-weight: 600; cursor: pointer;">
                                ✨ Đăng Kỷ Niệm
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
