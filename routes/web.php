<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CommunitiesController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\TopController;
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
    Route::post('/communities/{community}/join', [CommunitiesController::class, 'join'])->name('communities.join');
    Route::post('/communities/{community}/leave', [CommunitiesController::class, 'leave'])->name('communities.leave');
    Route::delete('/communities/{community}/members/{userId}', [CommunitiesController::class, 'removeMember'])->name('communities.removeMember');
});

require __DIR__.'/auth.php';

