<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostSingleResource;

class PostController extends Controller
{
    
    public function index() {
        $posts = Post::query()->select('id', 'user_id', 'title', 'description', 'created_at')->get();
        return response()->json([
            'posts' => PostResource::collection($posts),
        ]);
    }

    public function show($id) {
        $post = Post::find($id);
        return response()->json([
            'post' => new PostSingleResource($post),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'min:3'],
            'description' => ['required', 'min:3'],
        ]);

        $posts = $request->user()->posts()->create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return response()->json(['posts' => $posts]);
    }
}
