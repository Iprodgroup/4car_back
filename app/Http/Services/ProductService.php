<?php

namespace App\Http\Services;

use App\Models\Manufacturer;
use App\Models\Models;
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
        return $query;
    }

    public function rimsFilter(Request $request)
    {
        return Product::query();

        if($request->has('category_id'))
        {
            $query->whereHas('category_id',function ($q) use($request){
                $q->where('category_id',$request->category_id);
            });
        }

        if($request->has('price_min')){
            $query->where('price', '>=', $request->input('price_min'));
        }
        if($request->has('price_max')){
            $query->where('price', '<=', $request->input('price_max'));
        }
        if($request->has('brendy')){
            $query->where('brendy', $request->input('brendy'));
        }
        if($request->has('modeli')){
            $query->where('modeli', $request->input('modeli'));
        }
        if($request->has('shirina_shin')){
            $query->where('shirina_shin', $request->input('shirina_shin'));
        }
        if($request->has('vysota_shin')){
            $query->where('vysota_shin', $request->input('vysota_shin'));
        }
        if($request->has('diametr_shin')){
            $query->where('diametr_shin', $request->input('diametr_shin'));
        }
        if($request->has('sezony')){
            $query->where('sezony', $request->input('sezony'));
        }
        if($request->has('shipy')){
            $query->where('shipy', $request->input('shipy'));
        }
        if($request->has('indeks_nagruzki')){
            $query->where('indeks_nagruzki', $request->input('indeks_nagruzki'));
        }
        if($request->has('indeks_skorosti')){
            $query->where('indeks_skorosti', $request->input('indeks_skorosti'));
        }
        if($request->has('run_flat')){
            $query->where('run_flat', $request->input('run_flat'));
        }
    }

    public function filtersAttributes()
    {

        $manufacturerNames = [];
        $modelNames = [];

        Manufacturer::query()->chunk(100, function ($manufacturers) use (&$manufacturerNames) {
            $manufacturerNames = array_merge($manufacturerNames, $manufacturers->pluck('name')->toArray());
        });

        Models::query()->chunk(100, function ($models) use (&$modelNames) {
            $modelNames = array_merge($modelNames, $models->pluck('name')->toArray());
        });

        $width = [ 7.00, 7.50, 10.50, 11.50,
            12.50,
            13.50,
            155,
            165,
            175,
            185,
            195,
            205,
            215,
            225,
            235,
            245,
            255,
            265,
            275,
            285,
            295,
            305,
            315,
            325,
            385];
        $height = [25,
            30,
            31,
            32,
            33,
            35,
            37,
            40,
            45,
            50,
            55,
            60,
            65,
            70,
            75,
            80,
            85,
            90];
        $diameter = ["R12",
            "R13",
            "R14",
            "R15",
            "R16",
            "R17",
            "R18",
            "R19",
            "R20",
            "R21",
            "R22"];
        $season = ["Всесезонные", "Летние", "Зимние",];
        $spikes = ['Есть', "Нет"];
        $indeks_nagruzki = [
            "10",
            "#ЗНАЧ!",
            "100",
            "102-100",
            "104/106",
            "104-101",
            "104T X",
            "108-106",
            "115-112",
            "116-113",
            "120-116",
            "121-118",
            "121-119",
            "122",
            "122-119",
            "125",
            "125/123",
            "126/124",
            "128",
            "129/127",
            "133/131",
            "135/133",
            "136/133",
            "136/134",
            "139/137",
            "140",
            "140/137",
            "141/138",
            "141/139",
            "143/141",
            "144",
            "144/142",
            "145",
            "146",
            "146/143",
            "147",
            "148/145",
            "149",
            "149/146",
            "150/146",
            "150/147",
            "152/148",
            "152/149",
            "153/148",
            "154",
            "154/149",
            "154/150",
            "156",
            "156/150",
            "156/153",
            "157",
            "157/154",
            "158",
            "160",
            "160/158",
            "164",
            "167",
            "171",
            "193",
            "206",
            "208",];
        $indeks_skorosti = [
            "-",
            "A",
            "B",
            "E",
            "F",
            "G",
            "R XL",
            "T XL",
            "V XL",
            "W XL",
            "Y XL",
            "Н XL",
            "Т XL",
            "H",
            "J",
            "K",
            "L",
            "M",
            "N",
            "P",
            "Q",
            "R",
            "S",
            "T",
            "V",
            "W",
            "Y",
            "Н",
            "Т"
        ];
        $run_flat = ['нет'];
        return [
           'manufacturers' => $manufacturerNames,
           'models' => $modelNames,
           'width' => $width,
           'height' => $height,
           'diameter' => $diameter,
           'season' => $season,
           'spikes' => $spikes,
           'indeks_nagruzki' => $indeks_nagruzki,
           'indeks_skorosti' => $indeks_skorosti,
           'run_flat' => $run_flat,
        ];
    }

}
