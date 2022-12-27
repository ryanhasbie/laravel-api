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

        $name = date('dmY');
        $image = $request->file('image');

        $post = $request->user()->posts()->create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $request->hasFile('image') ? $image->storeAs('images/posts', $name .'.'. $image->extension()) : null,
        ]);

        return response()->json(['post' => $post]);
    }

    public function update(Request $request, $id)
    {
        // $this->authorize('update', $post);

        $request->validate([
            'title' => ['required', 'min:3'],
            'description' => ['required', 'min:3'],
        ]);

        $post = Post::findOrFail($id)->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return response()->json(['post' => $post]);

        // $post->update([
        //     'title' => $request->title,
        //     'description' => $request->description,
        // ]);

        // return response()->json("Oke");
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id)->delete();
        return response()->json(['post' => $post]);
        
    }
}
