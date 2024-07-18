<?php

namespace App\Http\Controllers;

use App\Models\Disk;
use App\Models\Review;
use App\Models\Tires;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request, $type, $id)
    {
        if ($type == 'tires') {
            $model = Tires::findOrFail($id);
        } elseif ($type == 'disk') {
            $model = Disk::findOrFail($id);
        } else {
            return response()->json(['error' => 'Invalid type'], 400);
        }

        return response()->json($model->reviews, 201);
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
    public function store(Request $request, $type, $id)
    {
        $request->validate([
            'text' => 'required|string',
            'title' => 'required|string',
            'rating' => 'required|integer',

            'user_id' => 'required|exists:users,id',
        ]);

        if ($type == 'tires') {
            $model = Tires::findOrFail($id);
        } elseif ($type == 'disk') {
            $model = Disk::findOrFail($id);
        } else {
            return response()->json(['error' => 'Invalid type'], 400);
        }

        $review = $model->reviews()->create([
            'text' => $request->text,
            'title' => $request->title,
            'rating' => $request->rating,
            'user_id' => \auth()->user()->id,
        ]);

        return $this->success('Review created', $review);
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
