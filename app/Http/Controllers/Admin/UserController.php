<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Tìm kiếm
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('uid', 'like', "%{$search}%");
            });
        }

        // Lọc theo role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->withCount(['posts', 'comments'])
            ->latest()
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load(['posts' => function($query) {
            $query->latest()->take(10);
        }, 'comments' => function($query) {
            $query->latest()->take(10);
        }]);

        $user->loadCount(['posts', 'comments', 'communities']);

        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->uid . ',uid',
            'role' => 'required|in:user,admin',
            'bio' => 'nullable|string|max:500',
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        $user->bio = $validated['bio'] ?? $user->bio;

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'Cập nhật thông tin người dùng thành công!');
    }

    public function destroy(User $user)
    {
        if ($user->uid === Auth::user()->uid) {
            return back()->with('error', 'Bạn không thể xóa chính mình!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Đã xóa người dùng thành công!');
    }

    public function toggleRole(User $user)
    {
        if ($user->uid === Auth::user()->uid) {
            return back()->with('error', 'Bạn không thể thay đổi quyền của chính mình!');
        }

        $user->role = $user->role === 'admin' ? 'user' : 'admin';
        $user->save();

        return back()->with('success', 'Đã cập nhật quyền người dùng!');
    }
}

