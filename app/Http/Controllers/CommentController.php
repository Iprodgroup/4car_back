<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function store(Request $request, $newsId)
    {
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required|string|max:1000',
        ]);

        $news = News::findOrFail($newsId);

        $comment = new Comment();
        $comment->user_id = Auth::id();
        $comment->news_id = $news->id;
        $comment->title = $request->input('title');
        $comment->body = $request->input('body');
        $comment->save();
        return response()->json($comment, 201);
    }

    public function index($newsId)
    {
        $news = News::findOrFail($newsId);
        $comments = $news->comments()->with('user')->get();

        return response()->json($comments);
    }
}
