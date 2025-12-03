<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\EventNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::forUser(Auth::user()->uid)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    public function getUnreadCount()
    {
        $count = Notification::forUser(Auth::user()->uid)
            ->unread()
            ->count();

        return response()->json(['count' => $count]);
    }

    public function markAsRead($id)
    {
        $notification = Notification::where('id', $id)
            ->where(function($q) {
                $q->where('user_id', Auth::user()->uid)
                  ->orWhereNull('user_id');
            })
            ->firstOrFail();

        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        // Đánh dấu thông báo cá nhân
        Notification::where('user_id', Auth::user()->uid)
            ->unread()
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        return redirect()->back()->with('success', 'Đã đánh dấu tất cả là đã đọc');
    }

    public function destroy($id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', Auth::user()->uid)
            ->firstOrFail();

        $notification->delete();

        return response()->json(['success' => true]);
    }
}
