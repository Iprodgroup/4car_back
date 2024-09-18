<?php

namespace App\Services\Product;

use App\Traits\SlugTrait;
use Illuminate\Http\Request;
use App\Models\Product\Product;
use App\Traits\PaginationTrait;

class SearchService
{
    use SlugTrait, PaginationTrait;

    public function searchProducts(Request $request)
    {
        $query = $request->input('query');
        $products = Product::where(function($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%")
            ->where('published', "!=", 0);
        })
            ->select('id', 'name', 'sku', 'image', 'price')
            ->paginate(15);

        $productsData = collect($products->items())->map(function ($product) {
            return [
                'id' => $product['id'],
                'name' => $product['name'],
                'sku' => $product['sku'],
                'slug' => $this->generateSlug($product['name'], $product['sku']),
                'price' => $product['price'],
                'image'=> 'https://test.4car.kz'.$product['image'],
            ];
        });
        return [
            'data' => $productsData,
            'pagination' => $this->paginate($products),
        ];
    }

    public function searchByAllTypes(Request $request)
    {
        $products = $this->searchProducts($request);
        return [
            'products'=>$products
        ];
    }
}
