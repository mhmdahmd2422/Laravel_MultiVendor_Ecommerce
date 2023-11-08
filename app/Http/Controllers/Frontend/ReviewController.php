<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use App\Models\ProductReviewGallery;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    use ImageUploadTrait;

    public function createReview(Request $request)
    {
        $request->validate([
           'rate' => ['required', 'numeric'],
           'review' => ['required', 'string', 'max:200'],
            'image' => ['image'],
            'product_id' => ['required', 'numeric', 'exists:products,id'],
            'vendor_id' => ['required', 'numeric', 'exists:vendors,id'],
        ]);
        $checkReviewExist = ProductReview::where(['product_id' => $request->product_id, 'user_id' => auth()->id()])->first();
        if($checkReviewExist){
            toastr('You Already Reviewed This Product', 'error', 'error');
            session()->flash('You Already Reviewed This Product', 'error');
            return redirect()->back();
        }

        $imagePath = $this->uploadImage($request, 'image', 'uploads');

        $product_review = new ProductReview();
        $product_review->product_id = $request->product_id;
        $product_review->vendor_id = $request->vendor_id;
        $product_review->user_id = auth()->id();
        $product_review->rate = $request->rate;
        $product_review->review = $request->review;
        $product_review->status = 0;
        $product_review->save();

        $product_review_gallery = new ProductReviewGallery();
        $product_review_gallery->product_review_id = $product_review->id;
        if(!empty($imagePath)){
            $product_review_gallery->image = $imagePath;
        }
        $product_review_gallery->save();

        toastr('Your Review Is Sent', 'success', 'success');
        flash('Your Review Is Sent', 'success');

        return redirect()->back();
    }
}
