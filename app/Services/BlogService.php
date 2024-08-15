<?php

namespace App\Services;

use App\Models\Blog;

class BlogService
{
    public function getAllBlogPost()
    {
        return Blog::query()->paginate(8);
    }
}
