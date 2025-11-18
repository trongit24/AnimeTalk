<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use App\Models\Community;
use App\Models\Comment;
use App\Models\PostLike;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Thống kê tổng quan
        $stats = [
            'total_users' => User::count(),
            'total_posts' => Post::count(),
            'total_communities' => Community::count(),
            'total_comments' => Comment::count(),
            'total_likes' => PostLike::count(),
            'new_users_today' => User::whereDate('created_at', today())->count(),
            'new_posts_today' => Post::whereDate('created_at', today())->count(),
            'new_comments_today' => Comment::whereDate('created_at', today())->count(),
        ];

        // Thống kê người dùng mới (7 ngày gần nhất)
        $newUsersChart = User::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Thống kê bài viết (7 ngày gần nhất)
        $newPostsChart = Post::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Top 5 bài viết có nhiều like nhất
        $topPosts = Post::withCount('likes')
            ->with('user')
            ->orderByDesc('likes_count')
            ->take(5)
            ->get();

        // Top 5 cộng đồng có nhiều thành viên nhất
        $topCommunities = Community::withCount('members')
            ->orderByDesc('members_count')
            ->take(5)
            ->get();

        // Người dùng hoạt động gần nhất
        $recentUsers = User::latest()
            ->take(10)
            ->get();

        // Bài viết mới nhất
        $recentPosts = Post::with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'newUsersChart',
            'newPostsChart',
            'topPosts',
            'topCommunities',
            'recentUsers',
            'recentPosts'
        ));
    }
}

