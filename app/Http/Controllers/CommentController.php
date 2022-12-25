<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CommentResource;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => ['required', 'exists:posts,id'],
            'comment' => ['required'],
        ]);

        $user = Auth::user()->id;
        $comment = Comment::create([
            'user_id' => $user,
            'post_id' => $request->post_id,
            'comment' => $request->comment,
        ]);

        return new CommentResource($comment);
    }
}
