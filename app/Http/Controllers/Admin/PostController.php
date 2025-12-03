<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostReport;
use App\Models\Notification;
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

    public function reported(Request $request)
    {
        $query = Post::with(['user', 'reports' => function($q) {
                $q->where('status', 'pending')->with('user');
            }])
            ->whereHas('reports', function($q) {
                $q->where('status', 'pending');
            })
            ->withCount(['reports' => function($q) {
                $q->where('status', 'pending');
            }]);

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'hidden') {
                $query->where('is_hidden', true);
            } elseif ($request->status === 'pending') {
                $query->where('is_hidden', false);
            }
        }

        $posts = $query->orderBy('reports_count', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.posts.reported', compact('posts'));
    }

    public function unhide(Post $post)
    {
        $post->unhide();

        // Đánh dấu tất cả báo cáo là đã xem xét
        $post->reports()->update(['status' => 'reviewed']);

        // Thông báo cho tác giả
        Notification::create([
            'user_id' => $post->user_id,
            'type' => 'post_unhidden',
            'title' => 'Bài viết đã được hiển thị lại',
            'message' => 'Bài viết "' . \Illuminate\Support\Str::limit($post->title, 50) . '" đã được admin xem xét và hiển thị lại.',
            'action_url' => route('posts.show', $post),
            'data' => json_encode([
                'post_id' => $post->id,
            ])
        ]);

        return back()->with('success', 'Đã hiển thị lại bài viết!');
    }

    public function deleteReported(Post $post)
    {
        // Đánh dấu tất cả báo cáo là dismissed
        $post->reports()->update(['status' => 'dismissed']);

        // Thông báo cho tác giả trước khi xóa
        Notification::create([
            'user_id' => $post->user_id,
            'type' => 'post_deleted',
            'title' => 'Bài viết đã bị xóa',
            'message' => 'Bài viết "' . \Illuminate\Support\Str::limit($post->title, 50) . '" đã bị admin xóa do vi phạm chính sách cộng đồng.',
            'action_url' => null,
            'data' => json_encode([
                'post_id' => $post->id,
                'post_title' => $post->title,
            ])
        ]);

        $post->delete();

        return back()->with('success', 'Đã xóa bài viết vi phạm!');
    }
}

