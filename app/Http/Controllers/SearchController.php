<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        // Redirect về trang trước hoặc trang chủ
        return redirect()->back()->with('info', 'Vui lòng sử dụng gợi ý tìm kiếm');
    }

    // API endpoint for autocomplete suggestions
    public function autocomplete(Request $request)
    {
        $query = $request->input('q');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $suggestions = Post::where('content', 'like', "%{$query}%")
            ->with('user:uid,name,profile_photo')
            ->select('id', 'user_id', 'content', 'slug', 'created_at')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($post) {
                return [
                    'id' => $post->id,
                    'slug' => $post->slug,
                    'content' => \Illuminate\Support\Str::limit(strip_tags($post->content), 60),
                    'user_name' => $post->user->name ?? 'Unknown',
                    'user_photo' => $post->user->profile_photo ? asset('storage/' . $post->user->profile_photo) : null,
                ];
            });

        return response()->json($suggestions);
    }
}
