<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendshipController extends Controller
{
    // Tìm kiếm người dùng
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        if (!$query) {
            return response()->json([]);
        }

        $users = User::where('name', 'LIKE', '%' . $query . '%')
            ->where('uid', '!=', Auth::user()->uid)
            ->take(10)
            ->get(['uid', 'name', 'profile_photo', 'email']);

        return response()->json($users);
    }

    // Gửi lời mời kết bạn
    public function sendRequest(Request $request)
    {
        $friendId = $request->friend_id;
        $userId = Auth::user()->uid;

        // Kiểm tra đã gửi lời mời chưa
        $existing = Friendship::where(function($q) use ($userId, $friendId) {
            $q->where('user_id', $userId)->where('friend_id', $friendId);
        })->orWhere(function($q) use ($userId, $friendId) {
            $q->where('user_id', $friendId)->where('friend_id', $userId);
        })->first();

        if ($existing) {
            return response()->json(['message' => 'Friend request already exists'], 400);
        }

        Friendship::create([
            'user_id' => $userId,
            'friend_id' => $friendId,
            'status' => 'pending',
        ]);

        return response()->json(['message' => 'Friend request sent successfully']);
    }

    // Chấp nhận lời mời
    public function acceptRequest($id)
    {
        $friendship = Friendship::findOrFail($id);
        
        if ($friendship->friend_id !== Auth::user()->uid) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $friendship->update(['status' => 'accepted']);

        return response()->json(['message' => 'Friend request accepted']);
    }

    // Từ chối lời mời
    public function rejectRequest($id)
    {
        $friendship = Friendship::findOrFail($id);
        
        if ($friendship->friend_id !== Auth::user()->uid) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $friendship->delete();

        return response()->json(['message' => 'Friend request rejected']);
    }

    // Danh sách bạn bè
    public function index()
    {
        $userId = Auth::user()->uid;

        $friends = Friendship::where(function($q) use ($userId) {
            $q->where('user_id', $userId)->orWhere('friend_id', $userId);
        })
        ->where('status', 'accepted')
        ->with(['user', 'friend'])
        ->get()
        ->map(function($friendship) use ($userId) {
            return $friendship->user_id === $userId ? $friendship->friend : $friendship->user;
        });

        // Lời mời chờ
        $pendingRequests = Friendship::where('friend_id', $userId)
            ->where('status', 'pending')
            ->with('user')
            ->get();

        return view('friends.index', compact('friends', 'pendingRequests'));
    }

    // Hủy kết bạn
    public function unfriend($friendId)
    {
        $userId = Auth::user()->uid;

        Friendship::where(function($q) use ($userId, $friendId) {
            $q->where('user_id', $userId)->where('friend_id', $friendId);
        })->orWhere(function($q) use ($userId, $friendId) {
            $q->where('user_id', $friendId)->where('friend_id', $userId);
        })->delete();

        return back()->with('success', 'Unfriended successfully');
    }
}
