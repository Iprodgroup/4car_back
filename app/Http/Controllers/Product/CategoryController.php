<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Models\Product\Category;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Services\Product\CategoryService;

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
