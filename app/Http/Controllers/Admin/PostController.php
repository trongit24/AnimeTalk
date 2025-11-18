<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with('user');

        // Tìm kiếm
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Lọc theo category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Lọc theo ngày
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $posts = $query->withCount(['comments', 'likes'])
            ->latest()
            ->paginate(20);

        $categories = Post::select('category')
            ->distinct()
            ->whereNotNull('category')
            ->pluck('category');

        return view('admin.posts.index', compact('posts', 'categories'));
    }

    public function show(Post $post)
    {
        $post->load(['user', 'comments.user', 'tags', 'community']);
        $post->loadCount(['comments', 'likes']);

        return view('admin.posts.show', compact('post'));
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Đã xóa bài viết thành công!');
    }

    public function destroyMultiple(Request $request)
    {
        $request->validate([
            'posts' => 'required|array',
            'posts.*' => 'exists:posts,id',
        ]);

        Post::whereIn('id', $request->posts)->delete();

        return back()->with('success', 'Đã xóa ' . count($request->posts) . ' bài viết!');
    }
}

