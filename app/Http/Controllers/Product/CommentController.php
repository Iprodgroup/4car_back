<?php

namespace App\Http\Controllers\Product;

use App\Models\News;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Services\Product\CommentService;

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
