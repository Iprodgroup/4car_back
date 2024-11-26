<?php
namespace App\Services\Product;

use App\Traits\SlugTrait;
use App\Models\Product\Cars;
use Illuminate\Http\Request;
use App\Models\Product\Models;
use App\Models\Product\Product;
use App\Traits\PaginationTrait;
use App\Models\Product\Category;
use Illuminate\Support\Facades\DB;
use App\Models\Product\Manufacturer;
use App\Http\Resources\ProductMinimalResource;

class ProductService
{
    use PaginationTrait, SlugTrait;
    public function tiresFilter(Request $request, int $categoryId)
    {
        $query = Product::query();
        $query->whereHas('categories', function ($q) use ($categoryId) {
            $q->where('category_id', $categoryId)
            ->where('published', '!=', 0);
        });

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

    public function getBestSalesProducts()
    {
        return Product::query()
            ->where('published', '!=', '0')
            ->limit(6)
            ->get();
    }

    public function getAllTires(Request $request, ProductService $productService): array
    {
        $category = Category::where('id', 370)->firstOrFail();
        $filteredProductsQuery = $productService->tiresFilter($request, 370);
        $filteredProductsQuery->where('published', 1);
        $filteredProducts = $filteredProductsQuery->paginate(12);
        $productsForFilter = $productService->filtersAttributes();

        return [
            'category' => [$category->name, $category->id],
            'products' => ProductMinimalResource::collection($filteredProducts),
            'filter' => $productsForFilter,
            'pagination' => $this->paginate($filteredProducts),
        ];
    }

    public function getAllDisks(Request $request, ProductService $productService): array
    {
        $category = Category::where('id', 369)->firstOrFail();
        $filteredProductsQuery = $productService->tiresFilter($request, 369);
        $filteredProductsQuery->where('published', 1);
        $filteredProducts = $filteredProductsQuery->paginate(12);
        $productsForFilter = $productService->filtersAttributes();

        return [
            'category' => ['name' => $category->name, 'id'=>$category->id],
            'products' => ProductMinimalResource::collection($filteredProducts),
            'filter' => $productsForFilter,
            'pagination' => $this->paginate($filteredProducts),

        ];
    }

    public function showProductBySlug($slug)
    {
        $product = Product::with('categories', 'images')
            ->where('manufacturer_part_number', $slug)
            ->firstOrFail();
        return $product;
    }

    private function filtersAttributes(): array
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
            12.50, 13.50, 155, 165, 175,
            185, 195, 205, 215, 225, 235,
            245, 255, 265, 275, 285, 295,
            305, 315, 325, 385
        ];
        $height = [25, 30, 31, 32, 33,
            35, 37, 40, 45, 50, 55,
            60, 65, 70, 75, 80, 85, 90
        ];
        $diameter = [12, 13, 14,
            15, 16, 17, 18,
            19, 20, 21, 22
        ];
        $season = ["Всесезонные", "Летние", "Зимние",];
        $spikes = ['Есть', "Нет"];
        $indeks_nagruzki = ["10", "100", "102-100",
            "104/106", "104-101", "104T X", "108-106",
            "115-112", "116-113", "120-116", "121-118",
            "121-119", "122", "122-119", "125",
            "125/123", "126/124", "128", "129/127",
            "133/131", "135/133", "136/133", "136/134",
            "139/137", "140", "140/137", "141/138", "141/139",
            "143/141", "144", "144/142", "145",
            "146", "146/143", "147", "148/145",
            "149", "149/146", "150/146", "150/147",
            "152/148", "152/149", "153/148", "154",
            "154/149", "154/150", "156", "156/150",
            "156/153", "157", "157/154", "158",
            "160", "160/158", "164", "167",
            "171", "193", "206", "208",];
        $indeks_skorosti = [
            "-", "A", "B", "E",
            "F", "G", "R XL",
            "T XL", "V XL",
            "W XL", "Y XL",
            "Н XL", "Т XL",
            "H", "J", "K", "L",
            "M", "N", "P", "Q",
            "R", "S", "T", "V",
            "W", "Y", "Н", "Т"
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

    public function modelsByBrand(Request $request)
    {
        $brands = [
            'ACURA', 'ALFA ROMEO', 'ASTON MARTIN', 'AUDI', 'BENTLEY', 'BMW', 'BRILLIANCE', 'BYD',
            'CADILLAC', 'CHANGAN', 'CHERY', 'CHEVROLET', 'CHRYSLER', 'CITROEN', 'DAEWOO', 'DAIHATSU',
            'DATSUN', 'DODGE', 'DONGFENG', 'DS', 'DW', 'FAW', 'FERRARI', 'FIAT', 'FORD', 'FOTON',
            'GEELY', 'GENESIS', 'GREAT WALL', 'HAFEI', 'HAIMA', 'HAVAL', 'HAWTAI', 'HONDA', 'HUMMER',
            'HYUNDAI', 'INFINITI', 'IRAN KHODRO', 'ISUZU', 'IVECO', 'JAC', 'JAGUAR', 'JEEP', 'KIA',
            'LADA', 'LAMBORGHINI', 'LAND ROVER', 'LEXUS', 'LIFAN', 'LINCOLN', 'MASERATI', 'MAYBACH',
            'MAZDA', 'MERCEDES', 'MINI', 'MITSUBISHI', 'NISSAN', 'OPEL', 'PEUGEOT', 'PONTIAC', 'PORSCHE',
            'RAVON', 'RENAULT', 'ROLLS-ROYCE', 'ROVER', 'SAAB', 'SEAT', 'SKODA', 'SMART', 'SSANG YONG',
            'SUBARU', 'SUZUKI', 'TagAZ', 'TESLA', 'TOYOTA', 'VOLKSWAGEN', 'VOLVO', 'VORTEX (TagAZ)', 'ZAZ',
            'ZOTYE', 'АЗЛК', 'ГАЗ', 'ОКА', 'УАЗ'
        ];

        if ($request->has('brand')) {
            $brand = $request->input('brand');
            $models = Cars::where('CarMark', $brand)
                ->select('CarModelCode', 'CarModel')
                ->distinct()
                ->get();

            return $models;
        }
        return $brands;
    }

    public function yearsByModel(Request $request)
    {
        if ($request->has('model')) {
            $model = $request->input('model');
            $years = Cars::where('CarModel', $model)
                ->select('CarYear')
                ->distinct()
                ->get();

            return $years;
        }
        return(['error' => 'Модель не выбрана']);
    }

    public function modificationByModelAndYear(Request $request)
    {
        if ($request->has(['model', 'year'])) {
            $model = $request->input('model');
            $year = $request->input('year');

            $modifications = Cars::where('CarModel', $model)
                ->where('CarYear', $year)
                ->select('Kuzov', 'Dvigatel')
                ->distinct()
                ->get();

            return $modifications;
        }
        return (['error' => 'Модель или год не выбраны']);
    }

    public function filterByModification(Request $request)
    {
        if ($request->has('modification')) {
            $modification = $request->input('modification');

            $options = DB::table('disks')
                ->join('cars', 'cars.id', '=', 'disks.item')
                ->where('cars.kuzov', $modification)
                ->select('disks.description', 'disks.shirina', 'disks.dia')
                ->first();

            if (!$options) {
                return (['error' => 'Данные не найдены']);
            }
            return (['options' => $options]);
        }
        return (['error' => 'Модификация не выбрана']);
    }

    public function searchSimilarProducts(Request $request)
    {
        if ($request->has(['shirina', 'dia'])) {
            $shirina = $request->input('shirina');
            $dia = $request->input('dia');

           // $similarProducts = DB::table('products')
            $similarProducts = Product::query()
                ->where('shirina_shin', $shirina)
                ->where('diametr_shin', $dia)
                ->where('published', '=', 1)
                ->whereHas('categories', function ($q) {
                    $q->where('category_id', 369)
                        ->where('published', '!=', 0);
                })
                ->select('products.name', 'products.price', 'products.short_description')
                ->get();

            return response()->json(['similar_products' => $similarProducts], 200);
        }
        return response()->json(['error' => 'Характеристики не выбраны'], 400);
    }

    public function optionsByModificationForTires(Request $request)
    {
        if ($request->has('modification')) {
            $modification = $request->input('modification');

            $options = DB::table('tires')
                ->join('cars', 'cars.id', '=', 'tires.item')
                ->where('cars.kuzov', $modification)
                ->select('tires.description', 'tires.shirina', 'tires.diametr')
                ->first();

            if (!$options)
            {
                return response()->json(['error' => 'Данные не найдены']);
            }

            $similarProducts = DB::table('products')
                ->where('razmer_shiny', $options->description)
                ->select('products.name', 'products.price')
                ->get();

            return [
                'options' => $options,
                'similar_products' => $similarProducts
            ];
        }
        return (['error' => 'Модификация не выбрана']);
    }


//    public function optionsByModificationForTires(Request $request)
//    {
//        if ($request->has('modification')) {
//            $modificationParts = explode(',', $request->input('modification'));
//            $kuzov = $modificationParts[0] ?? null;
//            $dvigatel = $modificationParts[1] ?? null;
//
//            $tires = Product::query()
//                ->where('published', 1)
//                ->whereHas('categories', function ($q) {
//                    $q->where('category_id', 370) // ID категории шин
//                    ->where('published', '!=', 0);
//                })
//                ->where('kuzov', $kuzov) // Предполагается, что у вас есть поле кузов в таблице шин
//                ->where('dvigatel', $dvigatel) // Предполагается, что у вас есть поле двигатель в таблице шин
//                ->select('name', 'price', 'short_description')
//                ->get();
//
//            return $tires;
//        }
//
//        return [];
//    }
}
