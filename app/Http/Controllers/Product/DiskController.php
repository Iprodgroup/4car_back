<?php

namespace App\Http\Controllers\Product;

use App\Models\Product\Disk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DiskResource;
use App\Services\Product\DiskService;

class DiskController extends Controller
{
    public function index(Request $request, DiskService $diskService)
    {
      $disk = $diskService->diskFilter($request);
      return DiskResource::collection($disk);
    }

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
    public function show(Disk $disk)
    {
        return response(new DiskResource($disk));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Disk $disk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Disk $disk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Disk $disk)
    {
        //
    }
}
