<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\CommunityPost;
use App\Models\PostLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostLikeController extends Controller
{
    public function toggle(Post $post)
    {
        $user = Auth::user();
        
        $existingLike = PostLike::where('user_id', $user->uid)
            ->where('post_id', $post->id)
            ->first();

        if ($existingLike) {
            $existingLike->delete();
            $liked = false;
        } else {
            PostLike::create([
                'user_id' => $user->uid,
                'post_id' => $post->id,
            ]);
            $liked = true;
        }

        return response()->json([
            'liked' => $liked,
            'likes_count' => $post->likes()->count(),
        ]);
    }

    public function togglePolymorphic(Request $request)
    {
        $user = Auth::user();
        $postId = $request->input('post_id');
        $modelType = $request->input('model_type', 'Post');
        
        // Determine the full model class
        $modelClass = $modelType === 'CommunityPost' ? 'App\Models\CommunityPost' : 'App\Models\Post';
        
        $existingLike = PostLike::where('user_id', $user->uid)
            ->where('likeable_id', $postId)
            ->where('likeable_type', $modelClass)
            ->first();

        if ($existingLike) {
            $existingLike->delete();
            $liked = false;
        } else {
            PostLike::create([
                'user_id' => $user->uid,
                'likeable_id' => $postId,
                'likeable_type' => $modelClass,
            ]);
            $liked = true;
        }

        $likesCount = PostLike::where('likeable_id', $postId)
            ->where('likeable_type', $modelClass)
            ->count();

        return response()->json([
            'success' => true,
            'liked' => $liked,
            'likes_count' => $likesCount,
        ]);
    }
}
