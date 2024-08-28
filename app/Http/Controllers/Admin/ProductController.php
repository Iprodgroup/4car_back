<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product\Product;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function showAllProducts()
    {
        $products = Product::query()->paginate(15);
        return view('admin.products.index', compact('products'));
    }
}
