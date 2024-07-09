<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $reviewableType, $reviewableId)
    {
        $request->validate([
            'title' => 'required|string|max:50',
            'text' => 'required|string|max:255',
            'rating' => 'required',
        ]);


        $review = new Review([
            'user_id' => Auth::id(),
            'reviewable_id' => $reviewableId,
            'reviewable_type' => $reviewableType,
            'title' => $request->title,
            'text' => $request->text,
            'rating' => $request->rating,
        ]);

        $review->save();

        return $this->success('Ваш отзыв успешно добавлен', $review);

    }

    /**
     * Display the specified resource.
     */
    public function show(Review $reviews)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
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
            'title' => 'string',
            'text' => 'string',
            'rating' => 'integer',
        ]);

        $reviews->update($request->all());
        return $this->success('Ваш отзыв успешно обновлен', $reviews);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $reviews)
    {
        $reviews->delete();
        return $this->success('Ваш отзыв успешно удален', $reviews);
    }
}
