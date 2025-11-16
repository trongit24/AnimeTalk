<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class TopController extends Controller
{
    public function posts()
    {
        $topPosts = Post::with(['user', 'tags'])
            ->withCount(['likes', 'comments'])
            ->selectRaw('posts.*, ((SELECT COUNT(*) FROM post_likes WHERE post_likes.post_id = posts.id) + (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id)) as interactions_count')
            ->orderByRaw('((SELECT COUNT(*) FROM post_likes WHERE post_likes.post_id = posts.id) + (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id)) DESC')
            ->paginate(20);

        return view('top.posts', compact('topPosts'));
    }
}
