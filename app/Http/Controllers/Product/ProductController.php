<?php
namespace App\Http\Controllers\Product;

use App\Traits\SlugTrait;
use App\Models\Product\Cars;
use Illuminate\Http\Request;
use App\Models\Product\Product;
use App\Traits\PaginationTrait;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\Product\ProductService;
use App\Http\Resources\ProductFullResource;
use App\Http\Resources\ProductMinimalResource;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    use PaginationTrait, SlugTrait;
    protected ProductService $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function filter(Request $request)
    {
        $query = Product::query();

        if ($request->has('season')) {
            $query->where('sezony', $request->season);
        }

        if ($request->has('diameter')) {
            $query->where('diametr_shin', $request->diameter);
        }

        if ($request->has('width')) {
            $query->where('shirina_shin', $request->width);
        }

        if ($request->has('run_flat')) {
            $query->where('run_flat', $request->run_flat);
        }

        if ($request->has('spikes')) {
            $query->where('shipy', $request->spikes);
        }

        if ($request->has('indeks_nagruzki')) {
            $query->where('indeks_nagruzki', $request->indeks_nagruzki);
        }

        if ($request->has('indeks_skorosti')) {
            $query->where('indeks_skorosti', $request->indeks_skorosti);
        }

        $products = $query->get();

        return ProductMinimalResource::collection($products);
    }
    public function showAllTires(Request $request): JsonResponse
    {
        $tires = $this->productService->getAllTires($request, $this->productService);
        return response()->json($tires);
    }

    public function showAllDisks(Request $request): JsonResponse
    {
       $disks = $this->productService->getAllDisks($request, $this->productService);
       return response()->json($disks);
    }

    public function showProductBySlug($slug): JsonResponse
    {
        $product = $this->productService->showProductBySlug($slug);
        return response()->json(new ProductFullResource($product));
    }

    public function getBestSellingProducts()
    {
        $products = $this->productService->getBestSalesProducts();
        return response()->json(ProductMinimalResource::collection($products));
    }

    public function getModelsByBrand(Request $request)
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

            return response()->json($models);
        }
        return response()->json($brands);
    }

    public function getYearsByModel(Request $request)
    {
        if ($request->has('model')) {
            $model = $request->input('model');
            $years = Cars::where('CarModel', $model)
                ->select('CarYear')
                ->distinct()
                ->get();

            return response()->json($years);
        }
        return response()->json(['error' => 'Модель не выбрана'], 400);
    }

    public function getModificationsByModelAndYear(Request $request)
    {
        if ($request->has(['model', 'year'])) {
            $model = $request->input('model');
            $year = $request->input('year');

            $modifications = Cars::where('CarModel', $model)
                ->where('CarYear', $year)
                ->select('Kuzov', 'Dvigatel')
                ->distinct()
                ->get();

            return response()->json($modifications);
        }
        return response()->json(['error' => 'Модель или год не выбраны'], 400);
    }

    public function getOptionsByModification(Request $request)
    {
        if ($request->has('modification')) {
            $modification = $request->input('modification');

            $options = DB::table('disks')
                ->join('cars', 'cars.id', '=', 'disks.item') // Соединение таблицы disks с таблицей cars по полю кузов
                ->where('cars.kuzov', $modification)
                ->select('disks.description', 'disks.shirina', 'disks.diametr')
                ->first();

            if ($options) {
                return response()->json($options);
            }
            return response()->json(['error' => 'Данные не найдены'], 404);
        }
        return response()->json(['error' => 'Модификация не выбрана'], 400);
    }
}
