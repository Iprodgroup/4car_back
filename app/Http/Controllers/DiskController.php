<?php

namespace App\Http\Controllers;

use App\Http\Resources\DiskResource;
use App\Models\Disk;
use Illuminate\Http\Request;

class DiskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response(Disk::all());
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
