<?php

namespace App\Http\Controllers;

use App\Models\Community;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class CommunitiesController extends Controller
{
    public function index(Request $request)
    {
        $query = Community::with(['owner', 'members'])
            ->withCount('members')
            ->orderBy('members_count', 'desc');

        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $communities = $query->paginate(12);
        $categories = ['Anime', 'Manga', 'Action', 'Romance', 'Comedy', 'Drama', 'Fantasy', 'Sci-Fi', 'Horror', 'Slice of Life', 'Sports', 'Mecha', 'Isekai', 'Other'];

        return view('communities.index', compact('communities', 'categories'));
    }

    public function create()
    {
        return view('communities.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100|unique:communities',
            'description' => 'required|max:500',
            'category' => 'required',
            'icon' => 'nullable|image|max:1024',
            'banner' => 'nullable|image|max:2048',
            'is_private' => 'boolean',
        ]);

        $slug = Str::slug($validated['name']);

        $community = Community::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'],
            'category' => $validated['category'],
            'is_private' => $request->has('is_private'),
        ]);

        if ($request->hasFile('icon')) {
            $path = $request->file('icon')->store('communities/icons', 'public');
            $community->update(['icon' => $path]);
        }

        if ($request->hasFile('banner')) {
            $path = $request->file('banner')->store('communities/banners', 'public');
            $community->update(['banner' => $path]);
        }

        // Add creator as owner
        $community->members()->attach(Auth::id(), ['role' => 'owner']);

        return redirect()->route('communities.show', $community->slug)
            ->with('success', 'Community created successfully!');
    }

    public function show($slug)
    {
        $community = Community::where('slug', $slug)
            ->with(['owner', 'members'])
            ->withCount('members')
            ->firstOrFail();

        $members = $community->members()->paginate(20);

        return view('communities.show', compact('community', 'members'));
    }

    public function join(Community $community)
    {
        if ($community->isMember(Auth::user())) {
            return back()->with('error', 'You are already a member!');
        }

        $community->members()->attach(Auth::id(), ['role' => 'member']);
        $community->update(['members_count' => DB::raw('members_count + 1')]);

        return back()->with('success', 'Joined community successfully!');
    }

    public function leave(Community $community)
    {
        if ($community->isOwner(Auth::user())) {
            return back()->with('error', 'Owner cannot leave the community!');
        }

        $community->members()->detach(Auth::id());
        $community->update(['members_count' => DB::raw('members_count - 1')]);

        return back()->with('success', 'Left community successfully!');
    }

    public function removeMember(Community $community, $userId)
    {
        if (!$community->isOwner(Auth::user())) {
            abort(403, 'Unauthorized');
        }

        if ($community->user_id == $userId) {
            return back()->with('error', 'Cannot remove owner!');
        }

        $community->members()->detach($userId);
        $community->update(['members_count' => DB::raw('members_count - 1')]);

        return back()->with('success', 'Member removed successfully!');
    }
}
