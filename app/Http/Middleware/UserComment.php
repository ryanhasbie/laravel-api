<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Comment;
use Illuminate\Http\Request;

class UserComment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        $comment = Comment::findOrFail($request->id);

        if ($user->id != $comment->user_id) {
            return response()->json(['message' => 'Not found.'], 404);
        }

        return $next($request);
    }
}
