<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function showAllCategories()
    {
        $categories = Category::query()->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }
}
