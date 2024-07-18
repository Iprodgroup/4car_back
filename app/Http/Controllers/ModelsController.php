<?php

namespace App\Http\Controllers;

use App\Models\Models;
use Illuminate\Http\Request;

class ModelsController extends Controller
{
    public function index()
    {
        $models = Models::query()->paginate(10);
        return response()->json($models);
    }
}
