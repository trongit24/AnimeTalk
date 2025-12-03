<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\CommunityPost;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CommunityPostController extends Controller
{
    // Hiển thị danh sách bài viết đã duyệt
    public function index(Community $community)
    {
        $posts = $community->communityPosts()
            ->with('user')
            ->approved()
            ->latest()
            ->paginate(10);

        return view('communities.posts.index', compact('community', 'posts'));
    }

    // Form tạo bài viết
    public function create(Community $community)
    {
        // Kiểm tra quyền
        if (!$community->canPost(Auth::user())) {
            return redirect()->route('communities.show', $community->slug)
                ->with('error', 'Bạn phải là thành viên để đăng bài');
        }

        return view('communities.posts.create', compact('community'));
    }

    // Lưu bài viết mới
    public function store(Request $request, Community $community)
    {
        if (!$community->canPost(Auth::user())) {
            return back()->with('error', 'Bạn không có quyền đăng bài');
        }

        $request->validate([
            'content' => 'required|string',
            'image' => 'nullable|image|max:5120',
            'video' => 'nullable|mimes:mp4,mov,avi|max:51200',
        ]);

        $data = [
            'community_id' => $community->id,
            'user_id' => Auth::user()->uid,
            'content' => $request->content,
            'status' => 'pending', // Mặc định chờ duyệt
        ];

        // Upload image
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('community-posts', 'public');
        }

        // Upload video
        if ($request->hasFile('video')) {
            $data['video'] = $request->file('video')->store('community-posts/videos', 'public');
        }

        $post = CommunityPost::create($data);

        // Thông báo cho chủ cộng đồng
        Notification::createNotification(
            'community_post_pending',
            'Bài viết mới cần duyệt',
            Auth::user()->name . ' đã đăng bài viết mới trong cộng đồng "' . $community->name . '"',
            $community->user_id,
            ['community_id' => $community->id, 'post_id' => $post->id],
            route('communities.posts.pending', $community->slug)
        );

        return redirect()->route('communities.show', $community->slug)
            ->with('success', 'Bài viết của bạn đang chờ được duyệt');
    }

    // Danh sách bài viết chờ duyệt (chỉ owner/moderator)
    public function pending(Community $community)
    {
        if (!$community->canManagePosts(Auth::user())) {
            return redirect()->route('communities.show', $community->slug)
                ->with('error', 'Bạn không có quyền truy cập');
        }

        $posts = $community->communityPosts()
            ->with('user')
            ->pending()
            ->latest()
            ->paginate(20);

        return view('communities.posts.pending', compact('community', 'posts'));
    }

    // Phê duyệt bài viết
    public function approve(Community $community, CommunityPost $post)
    {
        if (!$community->canManagePosts(Auth::user())) {
            return back()->with('error', 'Bạn không có quyền duyệt bài');
        }

        $post->approve(Auth::user()->uid);

        // Thông báo cho tác giả
        Notification::createNotification(
            'community_post_approved',
            'Bài viết đã được duyệt',
            'Bài viết của bạn trong cộng đồng "' . $community->name . '" đã được duyệt',
            $post->user_id,
            ['community_id' => $community->id, 'post_id' => $post->id],
            route('communities.show', $community->slug)
        );

        return back()->with('success', 'Đã duyệt bài viết');
    }

    // Từ chối bài viết
    public function reject(Request $request, Community $community, CommunityPost $post)
    {
        if (!$community->canManagePosts(Auth::user())) {
            return back()->with('error', 'Bạn không có quyền từ chối bài');
        }

        $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        $post->reject($request->reason);

        // Thông báo cho tác giả
        $message = 'Bài viết của bạn trong cộng đồng "' . $community->name . '" đã bị từ chối';
        if ($request->reason) {
            $message .= '. Lý do: ' . $request->reason;
        }

        Notification::createNotification(
            'community_post_rejected',
            'Bài viết bị từ chối',
            $message,
            $post->user_id,
            ['community_id' => $community->id, 'post_id' => $post->id],
            null
        );

        return back()->with('success', 'Đã từ chối bài viết');
    }

    // Xóa bài viết
    public function destroy(Community $community, CommunityPost $post)
    {
        if (!$community->canManagePosts(Auth::user()) && $post->user_id !== Auth::user()->uid) {
            return back()->with('error', 'Bạn không có quyền xóa bài viết này');
        }

        // Xóa file
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }
        if ($post->video) {
            Storage::disk('public')->delete($post->video);
        }

        $post->delete();

        return back()->with('success', 'Đã xóa bài viết');
    }
}
