<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Product\Category;
use App\Services\Product\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::where('published', 1)->get();
        return CategoryResource::collection($categories);
    }

    public function show($slug, Request $request, CategoryService $categoryService)
    {
        $categories = $categoryService->showCategoryBySlug($slug, $request);
        return response()->json($categories);
    }


}
