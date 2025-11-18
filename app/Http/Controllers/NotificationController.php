<?php

namespace App\Http\Controllers;

use App\Models\EventNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = EventNotification::with('event')
            ->where('user_id', auth()->user()->uid)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    public function getUnreadCount()
    {
        $count = EventNotification::where('user_id', auth()->user()->uid)
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count]);
    }

    public function markAsRead($id)
    {
        $notification = EventNotification::where('id', $id)
            ->where('user_id', auth()->user()->uid)
            ->firstOrFail();

        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        EventNotification::where('user_id', auth()->user()->uid)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return redirect()->back()->with('success', 'Đã đánh dấu tất cả là đã đọc');
    }
}
