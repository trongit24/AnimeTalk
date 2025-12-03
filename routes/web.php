<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CommunitiesController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\TopController;
use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\CommunityPostController;
use App\Http\Controllers\CommunityMessageController;
use App\Http\Controllers\CommunityMemoryController;
use App\Http\Controllers\PostReportController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\CommunityController as AdminCommunityController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/top/posts', [TopController::class, 'posts'])->name('top.posts');

// Communities (new feature)
Route::get('/communities', [CommunitiesController::class, 'index'])->name('communities.index');
Route::get('/communities/{community:slug}', [CommunitiesController::class, 'show'])->name('communities.show');

Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

// API routes for comments
Route::get('/posts/{post}/comments', [CommentController::class, 'index'])->name('comments.index');

Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/search/autocomplete', [SearchController::class, 'autocomplete'])->name('search.autocomplete');

// Events (public routes)
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

// Protected routes (require authentication)
Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile/{uid?}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit/settings', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Post routes
    Route::get('/posts/create/new', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    
    // Post likes
    Route::post('/posts/{post}/like', [PostLikeController::class, 'toggle'])->name('posts.like');
    Route::post('/posts/toggle-like', [PostLikeController::class, 'togglePolymorphic'])->name('posts.toggle-like');
    
    // Post reports
    Route::post('/posts/{post}/report', [PostReportController::class, 'store'])->name('posts.report');
    
    // Comment routes
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/posts/add-comment', [CommentController::class, 'storePolymorphic'])->name('posts.add-comment');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::delete('/posts/{post}/comments', [CommentController::class, 'destroyAll'])->name('comments.destroyAll');
    
    // API route for loading comments in modal
    Route::get('/api/comments/{modelType}/{postId}', [CommentController::class, 'getComments'])->name('api.comments');
    
    // Communities routes
    Route::get('/communities/create/new', [CommunitiesController::class, 'create'])->name('communities.create');
    Route::post('/communities', [CommunitiesController::class, 'store'])->name('communities.store');
    Route::get('/communities/{slug}/edit', [CommunitiesController::class, 'edit'])->name('communities.edit');
    Route::put('/communities/{slug}', [CommunitiesController::class, 'update'])->name('communities.update');
    Route::post('/communities/{community}/join', [CommunitiesController::class, 'join'])->name('communities.join');
    Route::post('/communities/{community}/leave', [CommunitiesController::class, 'leave'])->name('communities.leave');
    Route::delete('/communities/{community}/members/{userId}', [CommunitiesController::class, 'removeMember'])->name('communities.removeMember');
    
    // Community Posts routes
    Route::get('/communities/{community:slug}/posts', [CommunityPostController::class, 'index'])->name('communities.posts.index');
    Route::get('/communities/{community:slug}/posts/create', [CommunityPostController::class, 'create'])->name('communities.posts.create');
    Route::post('/communities/{community:slug}/posts', [CommunityPostController::class, 'store'])->name('communities.posts.store');
    Route::get('/communities/{community:slug}/posts/pending', [CommunityPostController::class, 'pending'])->name('communities.posts.pending');
    Route::post('/communities/{community:slug}/posts/{post}/approve', [CommunityPostController::class, 'approve'])->name('communities.posts.approve');
    Route::post('/communities/{community:slug}/posts/{post}/reject', [CommunityPostController::class, 'reject'])->name('communities.posts.reject');
    Route::delete('/communities/{community:slug}/posts/{post}', [CommunityPostController::class, 'destroy'])->name('communities.posts.destroy');
    
    // Community Memories routes (Locket-style)
    Route::post('/communities/{community:slug}/memories', [CommunityMemoryController::class, 'store'])->name('communities.memories.store');
    Route::delete('/memories/{memory}', [CommunityMemoryController::class, 'destroy'])->name('memories.destroy');
    Route::post('/memories/{memory}/react', [CommunityMemoryController::class, 'toggleReaction'])->name('memories.react');
    Route::post('/memories/{memory}/approve', [CommunityMemoryController::class, 'approve'])->name('memories.approve');
    Route::post('/memories/{memory}/reject', [CommunityMemoryController::class, 'reject'])->name('memories.reject');
    
    // Community Chat routes
    Route::get('/communities/{community:slug}/chat', [CommunityMessageController::class, 'index'])->name('communities.chat');
    Route::post('/communities/{community:slug}/chat', [CommunityMessageController::class, 'store'])->name('communities.chat.store');
    Route::get('/communities/{community:slug}/chat/messages', [CommunityMessageController::class, 'getMessages'])->name('communities.chat.messages');
    Route::post('/communities/{community:slug}/chat/{message}/pin', [CommunityMessageController::class, 'pin'])->name('communities.chat.pin');
    Route::delete('/communities/{community:slug}/chat/{message}/pin', [CommunityMessageController::class, 'unpin'])->name('communities.chat.unpin');
    Route::delete('/communities/{community:slug}/chat/{message}', [CommunityMessageController::class, 'destroy'])->name('communities.chat.destroy');
    
    // Friends routes
    Route::get('/friends', [FriendshipController::class, 'index'])->name('friends.index');
    Route::get('/friends/search', [FriendshipController::class, 'search'])->name('friends.search');
    Route::post('/friends/request', [FriendshipController::class, 'sendRequest'])->name('friends.request');
    Route::post('/friends/accept/{id}', [FriendshipController::class, 'acceptRequest'])->name('friends.accept');
    Route::post('/friends/reject/{id}', [FriendshipController::class, 'rejectRequest'])->name('friends.reject');
    Route::delete('/friends/unfriend/{friendId}', [FriendshipController::class, 'unfriend'])->name('friends.unfriend');
    
    // Messages routes
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{user}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
    Route::get('/messages/{user}/new', [MessageController::class, 'getMessages'])->name('messages.getMessages');
    
    // Notifications routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.delete');
    
    // Events routes
    Route::get('/events/create/new', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    Route::post('/events/{event}/respond', [EventController::class, 'respond'])->name('events.respond');
    Route::post('/events/{event}/invite', [EventController::class, 'invite'])->name('events.invite');
});

// Admin routes (require admin role)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Users Management
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{user}/toggle-role', [AdminUserController::class, 'toggleRole'])->name('users.toggleRole');
    
    // Posts Management
    Route::get('/posts', [AdminPostController::class, 'index'])->name('posts.index');
    Route::get('/posts/reported', [AdminPostController::class, 'reported'])->name('posts.reported');
    Route::get('/posts/{post}', [AdminPostController::class, 'show'])->name('posts.detail');
    Route::delete('/posts/{post}', [AdminPostController::class, 'destroy'])->name('posts.destroy');
    Route::delete('/posts', [AdminPostController::class, 'destroyMultiple'])->name('posts.destroyMultiple');
    Route::post('/posts/{post}/unhide', [AdminPostController::class, 'unhide'])->name('posts.unhide');
    Route::delete('/posts/{post}/delete-reported', [AdminPostController::class, 'deleteReported'])->name('posts.deleteReported');
    
    // Communities Management
    Route::get('/communities', [AdminCommunityController::class, 'index'])->name('communities.index');
    Route::get('/communities/{community}', [AdminCommunityController::class, 'show'])->name('communities.show');
    Route::delete('/communities/{community}', [AdminCommunityController::class, 'destroy'])->name('communities.destroy');
    
    // Events Management
    Route::get('/events', [AdminEventController::class, 'index'])->name('events.index');
    Route::get('/events/{event}', [AdminEventController::class, 'show'])->name('events.show');
    Route::delete('/events/{event}', [AdminEventController::class, 'destroy'])->name('events.destroy');
    Route::delete('/events', [AdminEventController::class, 'destroyMultiple'])->name('events.destroyMultiple');
    
    // Notifications Management
    Route::get('/notifications', [AdminNotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/create', [AdminNotificationController::class, 'create'])->name('notifications.create');
    Route::post('/notifications', [AdminNotificationController::class, 'store'])->name('notifications.store');
    Route::delete('/notifications/{id}', [AdminNotificationController::class, 'destroy'])->name('notifications.destroy');
});

require __DIR__.'/auth.php';

