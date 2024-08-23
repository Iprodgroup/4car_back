<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\Product\ManufacturerService;

class ManufacturerController extends Controller
{
    protected ManufacturerService $manufacturerService;
    public function __construct(ManufacturerService $manufacturerService)
    {
        $this->manufacturerService = $manufacturerService;
    }
    public function getAllManufacturers()
    {
        $manufacturers = $this->manufacturerService->getManufacturers();
        return response()->json($manufacturers, 200);
    }

    public function showManufacturerBySlug($slug):JsonResponse
    {
        $manufacturer = $this->manufacturerService->showManufacturerWithProductAndPagination($slug);
        return response()->json($manufacturer);
    }

    public function getPartManufacturersInMainPage()
    {
        $manufacturers = $this->manufacturerService->getMainPageManufacturers();
        return response()->json($manufacturers, 200);
    }

}
