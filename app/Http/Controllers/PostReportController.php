<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostReport;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PostReportController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        // Kiểm tra đã báo cáo chưa
        if ($post->reportedBy(Auth::user())) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn đã báo cáo bài viết này rồi'
            ], 400);
        }

        // Tạo báo cáo
        PostReport::create([
            'post_id' => $post->id,
            'user_id' => Auth::user()->uid,
            'reason' => $request->reason,
        ]);

        // Đếm số báo cáo
        $reportCount = $post->reports()->count();

        // Nếu đủ 3 báo cáo -> ẩn bài viết
        if ($reportCount >= 3 && !$post->is_hidden) {
            $post->hide('Bài viết bị ẩn do nhận ' . $reportCount . ' báo cáo vi phạm');

            // Thông báo cho tác giả bài viết
            Notification::create([
                'user_id' => $post->user_id,
                'type' => 'post_hidden',
                'title' => 'Bài viết của bạn đã bị ẩn',
                'message' => 'Bài viết "' . \Illuminate\Support\Str::limit($post->title, 50) . '" đã bị ẩn do nhận nhiều báo cáo vi phạm. Admin sẽ xem xét và xử lý.',
                'action_url' => route('posts.show', $post),
                'data' => json_encode([
                    'post_id' => $post->id,
                    'report_count' => $reportCount,
                ])
            ]);

            // Thông báo cho admin
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                Notification::create([
                    'user_id' => $admin->uid,
                    'type' => 'post_auto_hidden',
                    'title' => 'Bài viết bị ẩn tự động',
                    'message' => 'Bài viết "' . \Illuminate\Support\Str::limit($post->title, 50) . '" đã bị ẩn tự động do nhận ' . $reportCount . ' báo cáo vi phạm.',
                    'action_url' => route('admin.posts.reported'),
                    'data' => json_encode([
                        'post_id' => $post->id,
                        'report_count' => $reportCount,
                    ])
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Đã gửi báo cáo vi phạm. Cảm ơn bạn đã giúp giữ cộng đồng trong sạch!',
            'report_count' => $reportCount
        ]);
    }
}
