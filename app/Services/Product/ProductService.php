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
        return [
            'manufacturers' => $this->getManufacturers(),
            'models' => $this->getModels(),
            'disk_data' => $this->getDiskData(),
            'tire_characteristics' => $this->getTireCharacteristics()
        ];
    }

    private function getManufacturers(): array
    {
        $manufacturerNames = Manufacturer::pluck('name')->toArray();

        $manufacturersWithModels = Manufacturer::with(['models' => function($query) {
            $query->select('brand_id', 'name');
        }])->get()->mapWithKeys(function ($manufacturer) {
            return [$manufacturer->name => $manufacturer->models->pluck('name')->toArray()];
        })->toArray();

        return [
            'names' => $manufacturerNames,
            'with_models' => $manufacturersWithModels
        ];
    }

    private function getModels(): array
    {
        return Models::pluck('name')->toArray();
    }

    private function getDiskData(): array
    {
        return [
            'manufacturers' => [
                "AED", "ALUTEC", "ATS", "CR", "DN",
                "F-POWER", "FR", "FUEL", "LENSO",
                "MOTO METAL", "MR", "NICHE", "RIAL",
                "XD SERIES", "ENKEI", "RAYS", "BBS",
                "WORK", "VOLK RACING", "FORGED",
                "ROTIFORM", "HRE", "VORSTEINER"
            ],
            'models_by_manufacturer' => [
                "AED" => ["AMG55 (tw)", "ADX.01", "ADX.02"],
                "ALUTEC" => ["AU-5131", "AU-5456", "AU-832"],
                "ATS" => ["Competition 2", "Racing", "Dynamik"],
                "CR" => ["D-5459", "D712 Rage", "D718 Heater"],
                "DN" => ["HU-485", "M204 Vosso", "DN-617"],
                "F-POWER" => ["MB-962 AMG", "Passion", "Sport"],
                "FR" => ["RX-281", "RX-XH273", "Tormenta"],
                "FUEL" => ["XD133 Fusion", "XD135 Grenade", "Assault"],
                "LENSO" => ["XD847 Outbreak", "XD856 Omega", "BSX"],
                "MOTO METAL" => ["MO970", "MO977 LINK", "MO962"],
                "MR" => ["Murago", "OSLO", "PADUA"],
                "NICHE" => ["MILANO", "MIZAR", "SURGE"],
                "RIAL" => ["CATANIA", "Como", "CROSSLIGHT"],
                "XD SERIES" => ["XD140 RECON", "XD827 ROCKSTAR III", "ZAMORA"],
                "ENKEI" => ["RPF1", "NT03", "Kojin"],
                "RAYS" => ["Volk Racing", "TE37", "CE28"],
                "BBS" => ["CH-R", "SR", "FI-R"],
                "WORK" => ["Emotion", "Meister", "Schwert"],
                "VOLK RACING" => ["TE37", "G25", "ZE40"],
                "FORGED" => ["Monoblock", "Multispoke", "Concave"],
                "ROTIFORM" => ["BLQ", "KPS", "OZR"],
                "HRE" => ["FF15", "P101", "P107"],
                "VORSTEINER" => ["V-FF", "Racing", "Flow Forged"]
            ],
            'models' => [
                // Плоский список всех моделей
                "AMG55 (tw)", "ADX.01", "ADX.02",
                "AU-5131", "AU-5456", "AU-832",
                "Competition 2", "Racing", "Dynamik",
                "D-5459", "D712 Rage", "D718 Heater",
                "HU-485", "M204 Vosso", "DN-617",
                "MB-962 AMG", "Passion", "Sport",
                "RX-281", "RX-XH273", "Tormenta",
                "XD133 Fusion", "XD135 Grenade", "Assault",
                "XD847 Outbreak", "XD856 Omega", "BSX",
                "MO970", "MO977 LINK", "MO962",
                "Murago", "OSLO", "PADUA",
                "MILANO", "MIZAR", "SURGE",
                "CATANIA", "Como", "CROSSLIGHT",
                "XD140 RECON", "XD827 ROCKSTAR III", "ZAMORA",
                "RPF1", "NT03", "Kojin",
                "Volk Racing", "TE37", "CE28",
                "CH-R", "SR", "FI-R",
                "Emotion", "Meister", "Schwert",
                "TE37", "G25", "ZE40",
                "Monoblock", "Multispoke", "Concave",
                "BLQ", "KPS", "OZR",
                "FF15", "P101", "P107",
                "V-FF", "Racing", "Flow Forged"
            ]
        ];
    }

    private function getTireCharacteristics(): array
    {
        return [
            'width' => [ 7.00, 7.50, 10.50, 11.50, 155, 165, 175, 185, 195, 205, 215, 225, 235, 245, 255, 265, 275, 285, 295, 305, 315, 325, 385 ],
            'height' => [25, 30, 31, 32, 33, 35, 37, 40, 45, 50, 55, 60, 65, 70, 75, 80, 85, 90],
            'diameter' => [12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22],
            'season' => ["Всесезонные", "Летние", "Зимние"],
            'spikes' => ['Есть', "Нет"],
            'load_index' => ["10", "100", "102-100", "104/106" /* и т.д. */],
            'speed_index' => ["-", "A", "B", "E", "F", "G" /* и т.д. */],
            'run_flat' => ['нет']
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
