<?php

namespace App\Http\Controllers\Product;

use App\Models\Product\Models;
use App\Http\Controllers\Controller;

class ModelsController extends Controller
{
    public function index()
    {
        $models = Models::query()->paginate(10);
        return response()->json($models);
    }
}
