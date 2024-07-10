<?php

namespace App\Http\Controllers;

use App\Http\Resources\DiskResource;
use App\Models\Disk;
use Illuminate\Http\Request;

class DiskController extends Controller
{
    public function index(Request $request)
    {
        $query = Disk::query();
        if($request->has('name')){
            $query->where('name', $request->name);
        }
        if($request->has('type')){
            $query->where('type', $request->type);
        }
        if($request->has('size')) {
            $query->where('size', $request->size);
        }
        if($request->has('brand')) {
            $query->where('brand', $request->brand);
        }
        if($request->has('model')){
            $query->where('model', $request->model);
        }
        if($request->has('number_of_holes')){
            $query->where('number_of_holes', $request->number_of_holes);
        }
        if($request->has('size_of_holes')){
            $query->where('size_of_holes', $request->size_of_holes);
        }
        if($request->has('width')) {
            $query->where('width', $request->width);
        }
        if($request->has('diametr')){
            $query->where('diametr', $request->diametr);
        }
        if($request->has('deparute')){
            $query->where('departure', $request->departure);
        }
        if($request->has('tco')){
            $query->where('tco', $request->tco);
        }
        if($request->has('price')){
            $query->where('price', $request->price);
        }

        return $query->paginate(8);
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
