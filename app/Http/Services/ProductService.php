<?php

namespace App\Http\Services;


use App\Models\Product;
use Illuminate\Http\Request;

class ProductService
{
    public function tiresFilter(Request $request)
    {
        $query = Product::query();

        if ($request->has('category_id')) {
            $query->whereHas('category_id',function ($q) use($request){
                $q->where('category_id',$request->category_id);
            });
        }

        if ($request->has('price_min')) {
            $query->where('price', '>=', $request->input('price_min'));
        }

        if ($request->has('price_max')) {
            $query->where('price', '<=', $request->input('price_max'));
        }

        if ($request->has('brendy')) {
            $query->where('brendy', $request->input('brendy'));
        }

        if ($request->has('modeli')) {
            $query->where('modeli', $request->input('modeli'));
        }

        if ($request->has('shirina_shin')) {
            $query->where('shirina_shin', $request->input('shirina_shin'));
        }

        if ($request->has('vysota_shin')) {
            $query->where('vysota_shin', $request->input('vysota_shin'));
        }
        if ($request->has('diametr_shin')) {
            $query->where('diametr_shin', $request->input('diametr_shin'));
        }

        if($request->has('sezony')){
            $query->where('sezony', $request->input('sezony'));
        }
        if ($request->has('shipy')) {
            $query->where('shipy', $request->input('shipy'));
        }
        if ($request->has('indeks_nagruzki')) {
            $query->where('indeks_nagruzki', $request->input('indeks_nagruzki'));
        }
        if ($request->has('indeks_skorosti')) {
            $query->where('indeks_skorosti', $request->input('indeks_skorosti'));
        }
        if($request->has('run_flat')){
            $query->where('run_flat', $request->input('run_flat'));
        }
        return $query->paginate(16);

    }

    public function rimsFilter(Request $request)
    {

    }
}
