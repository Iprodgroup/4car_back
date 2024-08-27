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
            $q->where('name', 'LIKE', "%{$query}%");
        })
            ->select('id', 'name', 'image', 'price')
            ->paginate(15);

        $productsData = collect($products->items())->map(function ($product) {
            return [
                'id' => $product['id'],
                'name' => $product['name'],
                'slug' => $this->generateSlug($product['name']),
                'price' => $product['price'],
                'image'=> 'https://8eb0-93-188-86-71.ngrok-free.app/storage/users/ass.jpeg',
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
