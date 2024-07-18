<?php

namespace App\Http\Services;

use App\Models\Comment;
use App\Models\News;
use Illuminate\Support\Facades\Auth;

class CommentService
{
    public function storeComment($newsId, $title, $body)
    {
        $news = News::findOrFail($newsId);

        $comment = new Comment();
        $comment->user_id = Auth::id();
        $comment->news_id = $news->id;
        $comment->title = $title;
        $comment->body = $body;
        $comment->save();

        return $comment;
    }

}
