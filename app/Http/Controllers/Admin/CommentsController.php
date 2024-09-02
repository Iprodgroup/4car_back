<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product\Comment;
use App\Http\Controllers\Controller;

class CommentsController extends Controller
{
    public function index()
    {
        $news = Comment::query()->paginate(10);
        return view('admin.comments.index', compact('news'));
    }

    public function destroy($id)
    {
        $new = Comment::findOrFail($id);
        $new->delete();
        return redirect()->route('admin.comments.index');
    }
}
