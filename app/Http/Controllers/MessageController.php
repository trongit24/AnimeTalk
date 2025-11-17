<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Models\Friendship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    // Danh sách cuộc trò chuyện
    public function index()
    {
        $userId = Auth::user()->uid;

        // Lấy danh sách người đã nhắn tin
        $conversations = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->with(['sender', 'receiver'])
            ->latest()
            ->get()
            ->groupBy(function($message) use ($userId) {
                return $message->sender_id === $userId ? $message->receiver_id : $message->sender_id;
            })
            ->map(function($messages) use ($userId) {
                $lastMessage = $messages->first();
                $otherUser = $lastMessage->sender_id === $userId ? $lastMessage->receiver : $lastMessage->sender;
                $unreadCount = $messages->where('receiver_id', $userId)->where('is_read', false)->count();
                
                return [
                    'user' => $otherUser,
                    'last_message' => $lastMessage,
                    'unread_count' => $unreadCount,
                ];
            })
            ->sortByDesc('last_message.created_at');

        return view('messages.index', compact('conversations'));
    }

    // Chi tiết cuộc trò chuyện
    public function show($user)
    {
        $userId = Auth::user()->uid;
        
        // Kiểm tra có phải bạn bè không
        $isFriend = Friendship::where(function($q) use ($userId, $user) {
            $q->where('user_id', $userId)->where('friend_id', $user);
        })->orWhere(function($q) use ($userId, $user) {
            $q->where('user_id', $user)->where('friend_id', $userId);
        })->where('status', 'accepted')->exists();

        if (!$isFriend) {
            return redirect()->route('friends.index')->with('error', 'You can only message friends');
        }

        $friend = User::where('uid', $user)->firstOrFail();

        // Lấy tin nhắn
        $messages = Message::where(function($q) use ($userId, $user) {
            $q->where('sender_id', $userId)->where('receiver_id', $user);
        })->orWhere(function($q) use ($userId, $user) {
            $q->where('sender_id', $user)->where('receiver_id', $userId);
        })
        ->orderBy('created_at', 'asc')
        ->get();

        // Đánh dấu đã đọc
        Message::where('sender_id', $user)
            ->where('receiver_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('messages.show', compact('friend', 'messages'));
    }

    // Gửi tin nhắn
    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required',
            'message' => 'required|string|max:1000',
        ]);

        $userId = Auth::user()->uid;
        $receiverId = $request->receiver_id;

        // Kiểm tra có phải bạn bè không
        $isFriend = Friendship::where(function($q) use ($userId, $receiverId) {
            $q->where('user_id', $userId)->where('friend_id', $receiverId);
        })->orWhere(function($q) use ($userId, $receiverId) {
            $q->where('user_id', $receiverId)->where('friend_id', $userId);
        })->where('status', 'accepted')->exists();

        if (!$isFriend) {
            return response()->json(['error' => 'You can only message friends'], 403);
        }

        $message = Message::create([
            'sender_id' => $userId,
            'receiver_id' => $receiverId,
            'message' => $request->message,
        ]);

        return response()->json([
            'success' => true,
            'message' => $message->load('sender'),
        ]);
    }

    // Lấy tin nhắn mới (polling)
    public function getMessages($user)
    {
        $userId = Auth::user()->uid;
        $lastId = request('last_id', 0);
        
        $messages = Message::where(function($q) use ($userId, $user) {
            $q->where('sender_id', $userId)->where('receiver_id', $user);
        })->orWhere(function($q) use ($userId, $user) {
            $q->where('sender_id', $user)->where('receiver_id', $userId);
        })
        ->where('id', '>', $lastId)
        ->with('sender')
        ->orderBy('created_at', 'asc')
        ->get();

        // Đánh dấu đã đọc
        Message::where('sender_id', $user)
            ->where('receiver_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['messages' => $messages]);
    }
}
