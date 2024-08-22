<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Product\SearchService;

class SearchController extends Controller
{
    public function search(SearchService $searchService, Request $request)
    {
        $products = $searchService->searchByAllTypes($request);
        return response()->json($products);
    }
}
