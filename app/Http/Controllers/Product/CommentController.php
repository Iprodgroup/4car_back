<?php

namespace App\Http\Controllers\Product;

use App\Models\News;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Services\Product\CommentService;

class CommentController extends Controller
{
    protected $commentService;
    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
        $this->middleware('auth:sanctum')->only('store');
    }

    public function getComments($newsId)
    {
        $news = News::findOrFail($newsId);
        $comments = $news->comments()->with('user')->get();
        return response()->json($comments);
    }

    public function store(CommentRequest $request, $newsId)
    {
        $comment = $this->commentService->storeComment($newsId,
            $request->input('body')
        );
        return $this->success('Комментарий успешно создан', $comment);
    }

}
