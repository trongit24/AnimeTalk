<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show($uid = null)
    {
        // If no UID provided, show current user's profile
        $user = $uid ? User::where('uid', $uid)->firstOrFail() : Auth::user();
        
        // Get user's posts
        $posts = $user->posts()
            ->with(['tags', 'comments', 'likes'])
            ->latest()
            ->paginate(10);
        
        return view('profile.show', compact('user', 'posts'));
    }

    public function edit()
    {
        return view('profile.edit', [
            'user' => Auth::user()
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->uid . ',uid',
            'bio' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|max:2048',
            'cover_photo' => 'nullable|image|max:5120',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->bio = $validated['bio'] ?? null;

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $user->profile_photo = $path;
        }

        // Handle cover photo upload
        if ($request->hasFile('cover_photo')) {
            // Delete old cover photo if exists
            if ($user->cover_photo) {
                Storage::disk('public')->delete($user->cover_photo);
            }

            $path = $request->file('cover_photo')->store('covers', 'public');
            $user->cover_photo = $path;
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }
}

