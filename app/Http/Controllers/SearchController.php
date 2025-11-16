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
                $postsQuery->where(function ($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('content', 'like', "%{$query}%");
                });
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
}
