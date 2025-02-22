<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Models\Product\Review;
use App\Models\Product\Product;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('store', 'update', 'destroy');
    }

    public function index($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $reviews = $product->reviews;
        $avgRating = $reviews->avg('rating');

        return response()->json([
            'reviews' => $reviews,
            'avg_rating' => $avgRating
        ], 201);
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'text' => 'required|string',
            'rating' => 'required|integer',
            'user_id' => 'required|exists:users,id',
        ]);

        $product = Product::findOrFail($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        $review = $product->reviews()->create([
            'text' => $request->text,
            'rating' => $request->rating,
            'user_id' => auth()->user()->id,
        ]);
        $userName = auth()->user()->first_name . ' ' . auth()->user()->last_name;

        $reviewWithUserName = $review->toArray();
        $reviewWithUserName['user_name'] = $userName;
        return response()->json(['Review created', $reviewWithUserName], 201);
    }

    public function show(Review $reviews)
    {
        //
    }


    public function edit(Review $reviews)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $reviews)
    {
        $request->validate([
            'text' => 'string',
            'rating' => 'integer',
        ]);

        $reviews->update($request->all());
        return response()->json(['Ваш отзыв успешно обновлен', $reviews], 201);
    }

    public function destroy(Review $reviews)
    {
        $reviews->delete();
        return response()->json(['Ваш отзыв успешно удален', $reviews], 201);
    }
}
