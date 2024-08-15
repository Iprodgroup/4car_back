<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\TiresResource;
use App\Models\Product\Tires;
use App\Services\Product\TiresService;
use Illuminate\Http\Request;

class TiresController extends Controller
{
    public function index(Request $request, TiresService $service)
    {
        $tires = $service->tiresFilter($request);
        return TiresResource::collection($tires);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Tires $tires)
    {
        return response(new TiresResource($tires));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tires $tires)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tires $tires)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tires $tires)
    {
        //
    }
}
