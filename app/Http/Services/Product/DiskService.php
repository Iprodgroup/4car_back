<?php

namespace App\Http\Services\Product;

use App\Models\Product\Disk;
use Illuminate\Http\Request;

class DiskService
{
    public function diskFilter(Request $request)
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
}
