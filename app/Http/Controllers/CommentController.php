<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CommentController extends Controller
{
    // Get comments for a post (API)
    public function index(Post $post)
    {
        $currentUser = Auth::user();
        $comments = $post->comments()
            ->with('user')
            ->latest()
            ->get()
            ->map(function($comment) use ($currentUser, $post) {
                return [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'image' => $comment->image ? Storage::url($comment->image) : null,
                    'user' => [
                        'name' => $comment->user->name,
                        'profile_photo' => $comment->user->profile_photo,
                    ],
                    'created_at' => $comment->created_at->diffForHumans(),
                    'can_delete' => $currentUser && ($comment->user_id === $currentUser->uid || $post->user_id === $currentUser->uid),
                ];
            });

        return response()->json(['comments' => $comments]);
    }

    // Store comment with image support (API)
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
            'image' => 'nullable|image|max:5120', // 5MB max
        ]);

        $comment = new Comment();
        $comment->user_id = Auth::user()->uid;
        $comment->post_id = $post->id;
        $comment->content = $validated['content'];

        if ($request->hasFile('image')) {
            $comment->image = $request->file('image')->store('comments/images', 'public');
        }

        $comment->save();

        return response()->json([
            'success' => true,
            'message' => 'Comment added successfully!',
        ]);
    }

    // Old store method for backward compatibility
    public function storeOld(Request $request)
    {
        $validated = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'content' => 'required|max:1000',
        ]);

        Comment::create([
            'user_id' => Auth::user()->uid,
            'post_id' => $validated['post_id'],
            'content' => $validated['content'],
        ]);

        return back()->with('success', 'Comment added successfully!');
    }

    public function update(Request $request, Comment $comment)
    {
        // Check if user owns the comment
        if (!$comment->isOwnedBy(Auth::user())) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment->update($validated);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Comment updated successfully!']);
        }

        return back()->with('success', 'Comment updated successfully!');
    }

    public function destroy(Comment $comment)
    {
        $post = $comment->post;
        
        // Check if user owns the comment OR owns the post
        if (!$comment->isOwnedBy(Auth::user()) && !$post->isOwnedBy(Auth::user())) {
            abort(403, 'Unauthorized action.');
        }

        $comment->delete();

        return back()->with('success', 'Comment deleted successfully!');
    }

    public function destroyAll(Post $post)
    {
        // Check if user owns the post
        if (!$post->isOwnedBy(Auth::user())) {
            abort(403, 'Unauthorized action.');
        }

        $post->comments()->delete();

        return back()->with('success', 'All comments deleted successfully!');
    }
}
