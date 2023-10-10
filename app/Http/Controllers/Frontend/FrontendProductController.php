<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class FrontendProductController extends Controller
{
    public function index(string $slug){
        $product = Product::with(['vendor', 'category', 'gallery', 'brand'])->activeApproved()->where('slug', $slug)->first();
        $variants = ProductVariant::Active()->where('product_id', $product->id)->get();
//        dd($variants);
        return view('frontend.pages.product-details',
            compact(
                'product',
                'variants'
            )
        );
    }
}
