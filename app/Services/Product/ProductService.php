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

    private function filtersAttributes(): array
    {
        $manufacturers = Manufacturer::all();
        $models = Models::all();

        $manufacturerNames = $manufacturers->pluck('name')->toArray();
        $modelNames = $models->pluck('name')->toArray();

        $manufacturersWithModels = $manufacturers->map(function ($manufacturer) {
            $models = Models::where('brand_name', $manufacturer->name)
                ->pluck('name')
                ->toArray();

            return [$manufacturer->name => $models];
        })->toArray();

        $formattedManufacturers = [];
        foreach ($manufacturersWithModels as $manufacturer) {
            $formattedManufacturers[] = $manufacturer;
        }

        $width = Models::distinct()->pluck('shirina')->toArray();
        $height = Models::distinct()->pluck('visota')->toArray();
        $diameter = Models::distinct()->pluck('diametr')->toArray();
        $season = Models::distinct()->pluck('sezonnost')->toArray();
        $spikes = Models::distinct()->pluck('shipi')->toArray();
        $loadIndex = Models::distinct()->pluck('index_n')->toArray();
        $speedIndex = Models::distinct()->pluck('index_s')->toArray();
        $runFlat = Models::distinct()->pluck('runflat')->toArray();

        return [
            "just_manufacturers" => $manufacturerNames,
            'manufacturers' => $formattedManufacturers,
            'models' => $modelNames,
            'disk_manufacturers_with_models' => $formattedManufacturers, // Обновлено для дисков
            'width' => $width,
            'height' => $height,
            'diameter' => $diameter,
            'season' => $season,
            'spikes' => $spikes,
            'indeks_nagruzki' => $loadIndex,
            'indeks_skorosti' => $speedIndex,
            'run_flat' => $runFlat,
        ];
    }

    public function showProductBySlug($slug)
    {
        $product = Product::with('categories', 'images')
            ->where('manufacturer_part_number', $slug)
            ->firstOrFail();
        return $product;
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

}

//disk_models: [{ }]
//
