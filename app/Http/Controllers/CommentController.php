<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Carbon\Carbon;

class CommentController extends Controller
{
    public function deleteComment($id)
    {
        $comment = Comment::find($id);
        $comment->emojis()->delete();
        $comment->delete();
        // return response()->json();
        return response()->json([
            'status' => true,
            'message' => "Your Record has been Deleted!",
            'redirect_to' => route('post.post_list', Carbon::now()->subDays(30)->toDateString() . '~' . Carbon::now()->toDateString()),
        ]);
    }
}