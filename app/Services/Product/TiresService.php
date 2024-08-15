<?php

namespace App\Services\Product;

use App\Models\Product\Tires;
use Illuminate\Http\Request;

class TiresService
{
    public function tiresFilter(Request $request)
    {
        $query = Tires::query();
        if($request->has('name')){
            $query->where('name', $request->name);
        }
        if($request->has('brand')){
            $query->where('brand', $request->brand);
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
        if($request->has('radius')){
            $query->where('radius', $request->radius);
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
        if($request->has('country')){
            $query->where('country', $request->country);
        }

        return $query->paginate(8);
    }
}
