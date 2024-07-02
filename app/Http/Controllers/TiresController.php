<?php

namespace App\Http\Controllers;

use App\Models\Tires;
use Illuminate\Http\Request;
use App\Http\Resources\TiresResource;
use Doctrine\DBAL\Query;

class TiresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // return $this->response(Tires::all());

        $query = Tires::query();
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
