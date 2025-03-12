<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|min:20',
        ]);

        Comment::create([
            'blog_id' => $id,
            'comment' => $request->comment
        ]);

        return redirect()->route('detail_blog',$id)->with('success', 'Comment Berhasil Dibuat');
    }
}
