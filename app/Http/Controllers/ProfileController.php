<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

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
        
        // Get user's friends (using Friendship model)
        $friendIds = \App\Models\Friendship::where('user_id', $user->uid)
            ->where('status', 'accepted')
            ->pluck('friend_id');
        $friends = User::whereIn('uid', $friendIds)->take(12)->get();
        
        // Get user's communities
        $communities = $user->communities()->withCount('members')->take(12)->get();
        
        // Get user's events
        $eventIds = DB::table('event_participants')
            ->where('user_id', $user->uid)
            ->whereIn('status', ['going', 'interested'])
            ->pluck('event_id');
        $events = \App\Models\Event::whereIn('id', $eventIds)
            ->where('start_time', '>=', now())
            ->orderBy('start_time')
            ->take(12)
            ->get();
        
        return view('profile.show', compact('user', 'posts', 'friends', 'communities', 'events'));
    }

    public function edit()
    {
        return view('profile.edit', [
            'user' => Auth::user()
        ]);
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->uid . ',uid',
            'bio' => 'nullable|string|max:500',
            'profile_photo' => 'nullable|image|max:2048',
            'cover_photo' => 'nullable|image|max:5120',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->bio = $validated['bio'] ?? null;

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old profile photo if exists
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            $path = $request->file('profile_photo')->store('profile_photos', 'public');
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

