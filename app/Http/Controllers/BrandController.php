<?php

namespace App\Http\Controllers;

use App\Http\Resources\BrandResource;
use App\Models\Brand;

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
