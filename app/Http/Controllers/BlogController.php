<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Services\BlogService;
use App\Http\Resources\BlogResource;

class BlogController extends Controller
{
    public function showAllBlogPosts(BlogService $blogService)
    {
        $blogPosts = $blogService->getAllBlogPost();
        return BlogResource::collection($blogPosts);
    }

    public function showOneBlogPost($slug)
    {
        $blogPost = Blog::query()->where('slug', $slug)->firstOrFail();
        return response()->json($blogPost);
    }
}
