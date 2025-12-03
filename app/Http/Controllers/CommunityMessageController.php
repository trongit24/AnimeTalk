<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\CommunityMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CommunityMessageController extends Controller
{
    // Hiển thị chat - redirect về community page
    public function index(Community $community)
    {
        // Redirect về trang community với tab chat
        return redirect()->route('communities.show', $community->slug) . '#chat-tab';
    }

    // Gửi tin nhắn
    public function store(Request $request, Community $community)
    {
        // Kiểm tra quyền
        if (!$community->members()->where('user_id', Auth::user()->uid)->exists()) {
            return response()->json(['error' => 'Bạn không có quyền gửi tin nhắn'], 403);
        }

        $request->validate([
            'message' => 'required_without:image|string|max:2000',
            'image' => 'nullable|image|max:5120',
        ]);

        $data = [
            'community_id' => $community->id,
            'user_id' => Auth::user()->uid,
            'message' => $request->message,
        ];

        // Upload image
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('community-chat', 'public');
        }

        $message = CommunityMessage::create($data);
        $message->load('user');

        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }

    // Lấy tin nhắn mới (AJAX)
    public function getMessages(Community $community, Request $request)
    {
        // Kiểm tra quyền
        if (!$community->members()->where('user_id', Auth::user()->uid)->exists()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $lastId = $request->query('last_id', 0);

        $messages = $community->messages()
            ->with('user')
            ->where('id', '>', $lastId)
            ->latest()
            ->get();

        return response()->json([
            'messages' => $messages,
        ]);
    }

    // Ghim tin nhắn
    public function pin(Community $community, CommunityMessage $message)
    {
        if (!$community->canManagePosts(Auth::user())) {
            return back()->with('error', 'Chỉ chủ cộng đồng mới có thể ghim tin nhắn');
        }

        $message->pin();

        return back()->with('success', 'Đã ghim tin nhắn');
    }

    // Bỏ ghim
    public function unpin(Community $community, CommunityMessage $message)
    {
        if (!$community->canManagePosts(Auth::user())) {
            return back()->with('error', 'Chỉ chủ cộng đồng mới có thể bỏ ghim');
        }

        $message->unpin();

        return back()->with('success', 'Đã bỏ ghim tin nhắn');
    }

    // Xóa tin nhắn
    public function destroy(Community $community, CommunityMessage $message)
    {
        // Chỉ chủ tin nhắn hoặc chủ cộng đồng mới xóa được
        if ($message->user_id !== Auth::user()->uid && !$community->canManagePosts(Auth::user())) {
            return back()->with('error', 'Bạn không có quyền xóa tin nhắn này');
        }

        // Xóa ảnh nếu có
        if ($message->image) {
            Storage::disk('public')->delete($message->image);
        }

        $message->delete();

        return back()->with('success', 'Đã xóa tin nhắn');
    }
}
