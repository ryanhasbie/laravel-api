<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;

class PostController extends Controller
{
    
    public function index() {
        $posts = Post::query()->select('id', 'user_id', 'title', 'description', 'created_at')->get();
        return response()->json([
            'posts' => PostResource::collection($posts),
        ]);
    }

    public function show(Post $post) {
        return response()->json([
            'post' => $post,
        ]);
    }
}
