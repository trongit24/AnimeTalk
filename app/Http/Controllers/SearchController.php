<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');
        $tag = $request->input('tag');

        $posts = collect();

        if ($query || $tag) {
            $postsQuery = Post::with(['user', 'tags', 'comments']);

            if ($query) {
                $postsQuery->where('content', 'like', "%{$query}%");
            }

            if ($tag) {
                $postsQuery->whereHas('tags', function ($q) use ($tag) {
                    $q->where('slug', $tag);
                });
            }

            $posts = $postsQuery->orderBy('created_at', 'desc')->paginate(15);
        }

        $tags = Tag::all();

        return view('search.index', compact('posts', 'tags', 'query', 'tag'));
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
            ->select('id', 'user_id', 'content', 'created_at')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($post) {
                return [
                    'id' => $post->id,
                    'content' => \Illuminate\Support\Str::limit(strip_tags($post->content), 60),
                    'user_name' => $post->user->name ?? 'Unknown',
                    'user_photo' => $post->user->profile_photo ? asset('storage/' . $post->user->profile_photo) : null,
                ];
            });

        return response()->json($suggestions);
    }
}
