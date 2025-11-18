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
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\CommunityController as AdminCommunityController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/top/posts', [TopController::class, 'posts'])->name('top.posts');

// Communities (new feature)
Route::get('/communities', [CommunitiesController::class, 'index'])->name('communities.index');
Route::get('/communities/{community:slug}', [CommunitiesController::class, 'show'])->name('communities.show');

Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');

// API routes for comments
Route::get('/posts/{post}/comments', [CommentController::class, 'index'])->name('comments.index');

Route::get('/search', [SearchController::class, 'index'])->name('search');

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
    
    // Comment routes
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/comments', [CommentController::class, 'storeOld'])->name('comments.storeOld');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::delete('/posts/{post}/comments', [CommentController::class, 'destroyAll'])->name('comments.destroyAll');
    
    // Communities routes
    Route::get('/communities/create/new', [CommunitiesController::class, 'create'])->name('communities.create');
    Route::post('/communities', [CommunitiesController::class, 'store'])->name('communities.store');
    Route::get('/communities/{slug}/edit', [CommunitiesController::class, 'edit'])->name('communities.edit');
    Route::put('/communities/{slug}', [CommunitiesController::class, 'update'])->name('communities.update');
    Route::post('/communities/{community}/join', [CommunitiesController::class, 'join'])->name('communities.join');
    Route::post('/communities/{community}/leave', [CommunitiesController::class, 'leave'])->name('communities.leave');
    Route::delete('/communities/{community}/members/{userId}', [CommunitiesController::class, 'removeMember'])->name('communities.removeMember');
    
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
    Route::get('/posts/{post}', [AdminPostController::class, 'show'])->name('posts.show');
    Route::delete('/posts/{post}', [AdminPostController::class, 'destroy'])->name('posts.destroy');
    Route::delete('/posts', [AdminPostController::class, 'destroyMultiple'])->name('posts.destroyMultiple');
    
    // Communities Management
    Route::get('/communities', [AdminCommunityController::class, 'index'])->name('communities.index');
    Route::get('/communities/{community}', [AdminCommunityController::class, 'show'])->name('communities.show');
    Route::delete('/communities/{community}', [AdminCommunityController::class, 'destroy'])->name('communities.destroy');
    
    // Events Management
    Route::get('/events', [AdminEventController::class, 'index'])->name('events.index');
    Route::get('/events/{event}', [AdminEventController::class, 'show'])->name('events.show');
    Route::delete('/events/{event}', [AdminEventController::class, 'destroy'])->name('events.destroy');
    Route::delete('/events', [AdminEventController::class, 'destroyMultiple'])->name('events.destroyMultiple');
});

require __DIR__.'/auth.php';

