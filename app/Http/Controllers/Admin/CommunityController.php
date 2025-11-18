<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Community;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    public function index(Request $request)
    {
        $query = Community::query();

        // Tìm kiếm
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $communities = $query->withCount(['members', 'posts'])
            ->latest()
            ->paginate(20);

        return view('admin.communities.index', compact('communities'));
    }

    public function show(Community $community)
    {
        $community->load(['creator', 'members', 'posts' => function($query) {
            $query->latest()->take(10);
        }]);

        $community->loadCount(['members', 'posts']);

        return view('admin.communities.show', compact('community'));
    }

    public function destroy(Community $community)
    {
        $community->delete();

        return redirect()->route('admin.communities.index')
            ->with('success', 'Đã xóa cộng đồng thành công!');
    }
}

