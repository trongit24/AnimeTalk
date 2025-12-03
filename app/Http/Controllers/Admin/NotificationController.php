<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::whereNull('user_id') // Thông báo admin
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.notifications.index', compact('notifications'));
    }

    public function create()
    {
        return view('admin.notifications.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:admin_announcement,system_maintenance,new_event,other',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'action_url' => 'nullable|url',
        ]);

        Notification::createNotification(
            $request->type,
            $request->title,
            $request->message,
            null, // null = gửi cho tất cả user
            null,
            $request->action_url
        );

        return redirect()->route('admin.notifications.index')
            ->with('success', 'Đã gửi thông báo đến tất cả người dùng');
    }

    public function destroy($id)
    {
        $notification = Notification::whereNull('user_id')->findOrFail($id);
        $notification->delete();

        return redirect()->route('admin.notifications.index')
            ->with('success', 'Đã xóa thông báo');
    }
}
