<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function show(Post $post)
    {
        $post->load(['user', 'tags', 'comments.user']);

        // Kiểm tra nếu bài viết bị ẩn
        if ($post->is_hidden) {
            // Chỉ cho phép tác giả và admin xem bài viết bị ẩn
            if (!Auth::check() || 
                (Auth::user()->uid !== $post->user_id && Auth::user()->role !== 'admin')) {
                abort(403, 'Bài viết này đã bị ẩn do vi phạm chính sách cộng đồng.');
            }
        }

        // Increment views
        $post->increment('views');

        return view('posts.show', compact('post'));
    }

    public function create()
    {
        $tags = Tag::all();
        return view('posts.create', compact('tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'background' => 'nullable|string|max:50',
            'categories' => 'nullable|array',
            'categories.*' => 'in:anime,manga,cosplay,discussion,fanart,news,review',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
            'image' => 'nullable|image|max:2048',
            'video' => 'nullable|mimes:mp4,webm,ogg|max:51200',
        ]);

        $slug = Str::slug($validated['title']) . '-' . Str::random(6);

        $post = Post::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'slug' => $slug,
            'category' => isset($validated['categories']) ? implode(',', $validated['categories']) : null,
            'content' => $validated['content'],
            'background' => $validated['background'] ?? null,
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('posts', 'public');
            $post->update(['image' => $path]);
        }

        if ($request->hasFile('video')) {
            $path = $request->file('video')->store('posts/videos', 'public');
            $post->update(['video' => $path]);
        }

        if (isset($validated['tags'])) {
            $post->tags()->sync($validated['tags']);
        }

        return redirect()->route('posts.show', $post->slug)
            ->with('success', 'Post created successfully!');
    }

    public function edit(Post $post)
    {
        // Check if user owns the post
        if (!$post->isOwnedBy(Auth::user())) {
            abort(403, 'Unauthorized action.');
        }

        $tags = Tag::all();
        return view('posts.edit', compact('post', 'tags'));
    }

    public function update(Request $request, Post $post)
    {
        // Check if user owns the post
        if (!$post->isOwnedBy(Auth::user())) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'categories' => 'nullable|array',
            'categories.*' => 'in:anime,manga,cosplay,discussion,fanart,news,review',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
            'image' => 'nullable|image|max:2048',
            'video' => 'nullable|mimes:mp4,webm,ogg|max:51200',
            'remove_image' => 'nullable|boolean',
            'remove_video' => 'nullable|boolean',
        ]);

        // Handle image removal
        if ($request->has('remove_image') && $request->remove_image) {
            $post->image = null;
        }

        // Handle video removal
        if ($request->has('remove_video') && $request->remove_video) {
            $post->video = null;
        }

        // Handle new image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('posts', 'public');
            $post->image = $path;
        }

        // Handle new video upload
        if ($request->hasFile('video')) {
            $path = $request->file('video')->store('posts/videos', 'public');
            $post->video = $path;
        }

        // Update slug if title changed
        if ($post->title !== $validated['title']) {
            $post->slug = Str::slug($validated['title']) . '-' . Str::random(6);
        }

        $post->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'category' => isset($validated['categories']) ? implode(',', $validated['categories']) : null,
        ]);

        if (isset($validated['tags'])) {
            $post->tags()->sync($validated['tags']);
        }

        return redirect()->route('posts.show', $post->slug)
            ->with('success', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        // Check if user owns the post
        if (!$post->isOwnedBy(Auth::user())) {
            abort(403, 'Unauthorized action.');
        }

        // Delete image if exists
        if ($post->image && Storage::disk('public')->exists($post->image)) {
            Storage::disk('public')->delete($post->image);
        }

        // Decrement forum post count if post belongs to a forum
        if ($post->forum) {
            $post->forum->decrement('post_count');
        }

        $post->delete();

        return redirect()->route('home')
            ->with('success', 'Post deleted successfully!');
    }
}
