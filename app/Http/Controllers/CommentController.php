<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Services\CommentService;
use App\Models\Comment;
use App\Models\News;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    protected $commentService;
    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
        $this->middleware('auth:sanctum');
    }

    public function index($newsId)
    {
        $news = News::findOrFail($newsId);
        $comments = $news->comments()->with('user')->get();
        return response()->json($comments);
    }

    public function store(CommentRequest $request, $newsId)
    {
        $comment = $this->commentService->storeComment($newsId,
            $request->input('title'),
            $request->input('body')
        );
        return $this->success('Комментарий успешно создан', $comment);
    }


}
