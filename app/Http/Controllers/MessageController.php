<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Models\Friendship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{
    // Danh sách cuộc trò chuyện
    public function index()
    {
        $userId = Auth::user()->uid;

        // Lấy tất cả bạn bè (đã accepted)
        $friendIds = Friendship::where(function($q) use ($userId) {
            $q->where('user_id', $userId)->orWhere('friend_id', $userId);
        })
        ->where('status', 'accepted')
        ->get()
        ->map(function($friendship) use ($userId) {
            return $friendship->user_id === $userId ? $friendship->friend_id : $friendship->user_id;
        });

        $friends = User::whereIn('uid', $friendIds)->get();

        // Lấy tin nhắn cuối cùng với mỗi bạn
        $lastMessages = [];
        $unreadCounts = [];
        
        foreach ($friends as $friend) {
            $lastMessage = Message::where(function($q) use ($userId, $friend) {
                $q->where('sender_id', $userId)->where('receiver_id', $friend->uid);
            })->orWhere(function($q) use ($userId, $friend) {
                $q->where('sender_id', $friend->uid)->where('receiver_id', $userId);
            })
            ->latest()
            ->first();
            
            $lastMessages[$friend->uid] = $lastMessage;
            
            // Đếm tin nhắn chưa đọc
            $unreadCounts[$friend->uid] = Message::where('sender_id', $friend->uid)
                ->where('receiver_id', $userId)
                ->where('is_read', false)
                ->count();
        }

        return view('messages.index', compact('friends', 'lastMessages', 'unreadCounts'));
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

        // Lấy tất cả bạn bè cho sidebar
        $friendIds = Friendship::where(function($q) use ($userId) {
            $q->where('user_id', $userId)->orWhere('friend_id', $userId);
        })
        ->where('status', 'accepted')
        ->get()
        ->map(function($friendship) use ($userId) {
            return $friendship->user_id === $userId ? $friendship->friend_id : $friendship->user_id;
        });

        $allFriends = User::whereIn('uid', $friendIds)->get();

        // Lấy tin nhắn cuối cùng với mỗi bạn
        $lastMessages = [];
        $unreadCounts = [];
        
        foreach ($allFriends as $friendItem) {
            $lastMessage = Message::where(function($q) use ($userId, $friendItem) {
                $q->where('sender_id', $userId)->where('receiver_id', $friendItem->uid);
            })->orWhere(function($q) use ($userId, $friendItem) {
                $q->where('sender_id', $friendItem->uid)->where('receiver_id', $userId);
            })
            ->latest()
            ->first();
            
            $lastMessages[$friendItem->uid] = $lastMessage;
            
            // Đếm tin nhắn chưa đọc
            $unreadCounts[$friendItem->uid] = Message::where('sender_id', $friendItem->uid)
                ->where('receiver_id', $userId)
                ->where('is_read', false)
                ->count();
        }

        return view('messages.show', compact('friend', 'messages', 'allFriends', 'lastMessages', 'unreadCounts'));
    }

    // Gửi tin nhắn
    public function store(Request $request)
    {
        try {
            $request->validate([
                'receiver_id' => 'required',
                'message' => 'nullable|string|max:1000',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,heic|max:10240', // max 10MB
                'message_type' => 'nullable|string|in:text,image,gif',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Message validation failed: ' . json_encode($e->errors()));
            return response()->json(['errors' => $e->errors()], 422);
        }

        // Validate that at least message or image is provided
        if (!$request->message && !$request->hasFile('image') && $request->message_type !== 'gif') {
            return response()->json(['error' => 'Please provide a message or image'], 422);
        }

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

        $messageData = [
            'sender_id' => $userId,
            'receiver_id' => $receiverId,
            'message' => $request->message,
            'message_type' => $request->input('message_type', 'text'),
        ];

        // Xử lý upload ảnh/gif file
        if ($request->hasFile('image')) {
            try {
                $path = $request->file('image')->store('messages', 'public');
                $messageData['image'] = $path;
                $messageData['message_type'] = 'image';
            } catch (\Exception $e) {
                Log::error('Image upload failed: ' . $e->getMessage());
                return response()->json(['error' => 'Failed to upload image: ' . $e->getMessage()], 500);
            }
        }
        
        // Nếu là GIF URL (từ Giphy)
        if ($request->input('message_type') === 'gif') {
            $messageData['message_type'] = 'gif';
        }

        try {
            $message = Message::create($messageData);

            return response()->json([
                'success' => true,
                'message' => $message->load('sender'),
            ]);
        } catch (\Exception $e) {
            Log::error('Message creation failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to create message: ' . $e->getMessage()], 500);
        }
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
