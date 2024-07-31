<?php

namespace App\Http\Controllers\Product;

use App\Models\Product\Brand;
use App\Http\Controllers\Controller;
use App\Http\Resources\BrandResource;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::query()->paginate(10);
        return response()->json($brands);
    }

    public function show($slug)
    {
        $brands = Brand::where('name', $slug)->firstOrFail();
        return new BrandResource($brands);
    }
}
