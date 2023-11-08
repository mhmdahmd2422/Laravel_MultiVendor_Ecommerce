<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use App\Models\ProductReviewGallery;
use Illuminate\Http\Request;

class UserProductReviewController extends Controller
{
    public function index()
    {
        $reviews = ProductReview::where('user_id', auth()->id())->orderBy('id', 'DESC')->paginate(4);

        return view('frontend.dashboard.review.index', compact('reviews'));
    }

    public function destroy(string $id)
    {
        $review = ProductReview::where(['id' => $id, 'user_id' => auth()->id()])->first();
        ProductReviewGallery::where('product_review_id', $id)->delete();
        $review->delete();

        return response(['status' => 'success', 'message' => 'Your Review Has Been Deleted']);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
           'rate' => ['required', 'integer'],
           'review' => ['required', 'string'],
        ]);

        $review = ProductReview::where(['id' => $id, 'user_id' => auth()->id()])->first();
        if($request->has('rate')){
            $review->rate = $request->rate;
        }
        if($request->has('review')){
            $review->review = $request->review;
        }
        $review->save();

        toastr('Your Review Has Been Updated', 'success', 'success');
        flash('Your Review Has Been Updated', 'success');

        return redirect()->back();
    }
}
