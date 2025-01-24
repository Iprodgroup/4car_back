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
        $modelNames = [];
        $manufacturers = Manufacturer::query()->get();
        $manufacturerNames = [];

        Manufacturer::query()->chunk(100, function ($manufacturers) use (&$manufacturerNames) {
            $manufacturerNames = array_merge($manufacturerNames, $manufacturers->pluck('name')->toArray());
        });

        $manufacturersWithModels = $manufacturers->map(function ($manufacturer) {
            $models = Models::where('brand_id', $manufacturer->id)
                ->pluck('name')
                ->toArray();

            return [$manufacturer->name => $models];
        })->toArray();

        Models::query()->chunk(100, function ($models) use (&$modelNames) {
            $modelNames = array_merge($modelNames, $models->pluck('name')->toArray());
        });
        $formattedManufacturers = [];
        foreach ($manufacturersWithModels as $manufacturer) {
            $formattedManufacturers[] = $manufacturer;
        }

        $disk_models_by_manufacturer = [
            "AED" => ["AMG55 (tw)", "ADX.01", "ADX.02"],
            "ALUTEC" => ["AU-5131", "AU-5456", "AU-832"],
            "ATS" => ["Competition 2", "Conquista-Karizma"],
            "CR" => ["D-5459", "D712 Rage", "D718 Heater"],
            "DN" => ["HU-485", "M204 Vosso"],
            "F-POWER" => ["MB-962 AMG", "Passion"],
            "FR" => ["RX-281", "RX-XH273", "Tormenta"],
            "FUEL" => ["XD133 Fusion Off-Road", "XD135 Grenade Off-Road"],
            "LENSO" => ["XD847 Outbreak", "XD856 Omega"],
            "MOTO METAL" => ["MO970", "MO977 LINK"],
            "MR" => ["Murago", "OSLO", "PADUA"],
            "NICHE" => ["MILANO", "MIZAR"],
            "RIAL" => ["CATANIA", "Como", "CROSSLIGHT"],
            "XD SERIES" => ["XD140 RECON", "XD827 ROCKSTAR III", "ZAMORA"]
        ];
        $disk_manufacturers_with_models = [];
        foreach ($disk_models_by_manufacturer as $manufacturer => $models) {
            $disk_manufacturers_with_models[] = [$manufacturer => $models];
        }
        $json_output = json_encode( ["manufacturers" => $disk_manufacturers_with_models], JSON_PRETTY_PRINT);
        $disk_models = [
            "AMG55 (tw)","ADX.01", "ADX.02","Tormenta","DRIVE X","IKENU","GRIP","DYNAMITE","MONSTR", "POISON CUP", "POISON", "RAPTR","SHARK","Singa", "TITAN", "W10","W10X",
            "Competition 2","Passion", "CROSSLIGHT","MIZAR", "Grid","PERFEKTION","RACELIGHT","RADIAL", "Temperament","MB-962 AMG", "RX-XH273","TY-FC1734 (300)", "TY-RH5001 (200)",
            "QC1151","AU-5131", "AU-5436", "D-5459", "HU-485","TRD-1380", "TY-R2027", "TY-P6067","D712 Rage", "D720 Heater", "D718 Heater",
            "MO977 LINK", "MO977","TY-1905 (300)","M204 Vosso","CATANIA", "Como", "Davos", "DH", "KIBO","LUCCA","LUGANO","M10","M10X","MILANO", "Murago", "OSLO", "PADUA","QUINTO", "Torino",
            "Transporter", "ZAMORA","XD133 Fusion Off-Road", "XD135 Grenade Off-Road", "XD847 Outbreak", "XD856 Omega", "XD140 RECON", "XD827 ROCKSTAR III"
        ];
        $disk_manufacturers = [
            "AED", "ALUTEC", "ATS", "CR", "DN", "F-POWER", "FR", "FUEL", "LENSO", "MOTO METAL", "MR", "NICHE", "RIAL", "XD SERIES"
        ];
        $width = [ 5.00, 5.50, 6.00, 6.50,
            7.00, 7.50, 10.50, 11.50,
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
            "just_manufacturers" => $manufacturerNames,
            'manufacturers' => $formattedManufacturers,
            'models' => $modelNames,
            'disk_manufacturers_with_models' => $disk_manufacturers_with_models,
            'disk_manufacturers' => $disk_manufacturers,
            'disk_models' => $disk_models,
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

//    private function filtersAttributes(): array
//    {
//        $manufacturers = Manufacturer::all();
//        $models = Models::all();
//
//        $manufacturerNames = $manufacturers->pluck('name')->toArray();
//        $modelNames = $models->pluck('name')->toArray();
//
//        $manufacturersWithModels = $manufacturers->map(function ($manufacturer) {
//            $models = Models::where('brand_name', $manufacturer->name)
//                ->pluck('name')
//                ->toArray();
//
//            return [$manufacturer->name => $models];
//        })->toArray();
//
//        $formattedManufacturers = [];
//        foreach ($manufacturersWithModels as $manufacturer) {
//            $formattedManufacturers[] = $manufacturer;
//        }
//
//        $width = Models::distinct()->pluck('shirina')->toArray();
//        $height = Models::distinct()->pluck('visota')->toArray();
//        $diameter = Models::distinct()->pluck('diametr')->toArray();
//        $season = Models::distinct()->pluck('sezonnost')->toArray();
//        $spikes = Models::distinct()->pluck('shipi')->toArray();
//        $loadIndex = Models::distinct()->pluck('index_n')->toArray();
//        $speedIndex = Models::distinct()->pluck('index_s')->toArray();
//        $runFlat = Models::distinct()->pluck('runflat')->toArray();
//
//        return [
//            "just_manufacturers" => $manufacturerNames,
//            'manufacturers' => $formattedManufacturers,
//            'models' => $modelNames,
//            'disk_manufacturers_with_models' => $formattedManufacturers, // Обновлено для дисков
//            'width' => $width,
//            'height' => $height,
//            'diameter' => $diameter,
//            'season' => $season,
//            'spikes' => $spikes,
//            'indeks_nagruzki' => $loadIndex,
//            'indeks_skorosti' => $speedIndex,
//            'run_flat' => $runFlat,
//        ];
//    }

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
