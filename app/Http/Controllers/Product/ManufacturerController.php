<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\Product\ManufacturerService;

class ManufacturerController extends Controller
{
    public function index(ManufacturerService $manufacturerService)
    {
        $manufacturers = $manufacturerService->getManufacturers();
        return response()->json($manufacturers, 200);
    }

    public function show($slug, ManufacturerService $service):JsonResponse
    {
        $manufacturer = $service->showManufacturerWithProductAndPagination($slug);
        return response()->json($manufacturer);
    }

}
