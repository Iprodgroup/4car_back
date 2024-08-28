<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Product\Review;
use App\Http\Controllers\Controller;

class ReviewsController extends Controller
{
    public function showAllReviews()
    {
        $reviews = Review::with(['user', 'product'])->paginate(15);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();
        return redirect()->route('admin.reviews.index')->with('success', 'Отзыв успешно удален.');
    }
}
