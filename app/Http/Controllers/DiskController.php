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
        if($request->has('model')){
            $query->where('model', $request->model);
        }
        if($request->has('weight')){
            $query->where('weight', $request->weight);
        }
        if($request->has('height')){
            $query->where('height', $request->height);
        }
        if($request->has('diametr')){
            $query->where('diametr', $request->diametr);
        }
        if($request->has('season')){
            $query->where('season', $request->season);
        }
        if($request->has('spikes')){
            $query->where('spikes', $request->spikes);
        }
        if($request->has('index_n')){
            $query->where('index_n', $request->index_n);
        }
        if($request->has('index_s')){
            $query->where('index_s', $request->index_s);
        }
        if($request->has('run_flat')){
            $query->where('run_flat', $request->run_flat);
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
