<?php

namespace App\Http\Controllers;

use App\Http\Resources\ManufacturerResource;
use App\Http\Services\ManufacturerService;
use App\Models\Manufacturer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ManufacturerController extends Controller
{
    public function index()
    {
        $query = Manufacturer::query()->paginate(10);
        return response()->json(ManufacturerResource::collection($query));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($slug, ManufacturerService $service):JsonResponse
    {
        $manufacturer = $service->showManufacturerWithProductAndPagination($slug);
        return response()->json($manufacturer);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Manufacturer $manufacturer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Manufacturer $manufacturer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Manufacturer $manufacturer)
    {
        //
    }
}
