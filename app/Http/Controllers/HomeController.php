<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use App\Models\Community;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['user', 'tags', 'comments'])
            ->withCount(['likes', 'comments'])
            ->visible() // Chỉ lấy bài viết chưa bị ẩn
            ->orderBy('is_pinned', 'desc')
            ->orderBy('created_at', 'desc');

        // Filter by category if provided
        $category = $request->get('category');
        if ($category && $category !== 'all') {
            $query->where(function($q) use ($category) {
                $q->where('category', 'LIKE', '%' . $category . '%')
                  ->orWhere('category', $category);
            });
        }

        // Filter by tag if provided
        if ($request->has('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('slug', $request->tag);
            });
        }

        $posts = $query->paginate(12);
        $tags = Tag::all();
        
        // Top posts by total interactions (likes + comments)
        $topPosts = Post::withCount(['likes', 'comments'])
            ->visible() // Chỉ lấy bài viết chưa bị ẩn
            ->selectRaw('posts.*, ((SELECT COUNT(*) FROM post_likes WHERE post_likes.post_id = posts.id) + (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id)) as interactions_count')
            ->orderByRaw('((SELECT COUNT(*) FROM post_likes WHERE post_likes.post_id = posts.id) + (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id)) DESC')
            ->take(3)
            ->get();
        
        // Top communities by member count
        $topCommunities = Community::withCount('members')
            ->orderBy('members_count', 'desc')
            ->take(5)
            ->get();

        return view('home-new', compact('posts', 'tags', 'topPosts', 'topCommunities', 'category'));
    }
}
