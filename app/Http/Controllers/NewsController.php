<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Traits\SlugTrait;
use Illuminate\Http\Request;
use App\Http\Resources\NewsResource;

class NewsController extends Controller
{
    use SlugTrait;
    public function showAllNews(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $news = News::paginate($perPage);
        return NewsResource::collection($news);
    }

    public function showNewsBySLug($slug)
    {
        $news = News::all()->first(function($newsItem) use ($slug) {
            return $this->generateSlug($newsItem->title) === $slug;
        });

        if (!$news) {
            abort(404, 'News not found');
        }

        return response(new NewsResource($news));
    }


}
