<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
                    'image' => $comment->image ? asset('storage/' . $comment->image) : null,
                    'user' => [
                        'name' => $comment->user->name,
                        'profile_photo' => $comment->user->profile_photo ? asset('storage/' . $comment->user->profile_photo) : null,
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
            $path = $request->file('image')->store('comments', 'public');
            $comment->image = $path;
        }

        $comment->save();

        return response()->json([
            'success' => true,
            'message' => 'Comment added successfully!',
        ]);
    }

    // Polymorphic comment store
    public function storePolymorphic(Request $request)
    {
        $validated = $request->validate([
            'post_id' => 'required',
            'model_type' => 'required|in:Post,CommunityPost',
            'content' => 'required|max:1000',
            'image' => 'nullable|image|max:5120', // 5MB max
        ]);

        $modelClass = $validated['model_type'] === 'CommunityPost' ? 'App\Models\CommunityPost' : 'App\Models\Post';

        $comment = new Comment();
        $comment->user_id = Auth::user()->uid;
        $comment->commentable_id = $validated['post_id'];
        $comment->commentable_type = $modelClass;
        $comment->content = $validated['content'];

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('comments', 'public');
            $comment->image = $path;
        }

        $comment->save();

        // Return JSON for AJAX or redirect for form submit
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Comment added successfully!',
                'comment' => [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'image' => $comment->image ? asset('storage/' . $comment->image) : null,
                    'user' => [
                        'name' => Auth::user()->name,
                        'profile_photo' => Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : null,
                    ],
                    'created_at' => $comment->created_at->diffForHumans(),
                ],
            ]);
        }

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

    /**
     * Get comments for modal (polymorphic)
     */
    public function getComments($modelType, $postId)
    {
        // Determine the model class
        $modelClass = $modelType === 'CommunityPost' 
            ? 'App\Models\CommunityPost' 
            : 'App\Models\Post';

        // Get comments using polymorphic relationship
        $comments = Comment::where('commentable_type', $modelClass)
            ->where('commentable_id', $postId)
            ->with('user')
            ->latest()
            ->get()
            ->map(function($comment) {
                return [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'image' => $comment->image,
                    'user' => [
                        'name' => $comment->user->name,
                        'avatar' => $comment->user->profile_photo 
                            ? asset('storage/' . $comment->user->profile_photo) 
                            : asset('images/default-avatar.png'),
                    ],
                    'created_at' => $comment->created_at->diffForHumans(),
                ];
            });

        return response()->json(['comments' => $comments]);
    }
}
