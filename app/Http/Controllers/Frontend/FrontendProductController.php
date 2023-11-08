<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Advertisment;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\ProductVariant;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FrontendProductController extends Controller
{
    public function index(string $slug){
        $product = Product::with(['vendor', 'category', 'gallery', 'brand'])->activeApproved()->where('slug', $slug)->first();
        $variants = ProductVariant::Active()->where('product_id', $product->id)->get();
        $reviews = ProductReview::where(['product_id' => $product->id, 'status' => 1])->paginate(3);
        return view('frontend.pages.product-details',
            compact(
                'product',
                'variants',
                'reviews'
            )
        );
    }

    public function productsIndex(Request $request)
    {
        $categories = Category::active()->setEagerLoads([])->get();
        $brands = Brand::active()->get();
        $products = Product::activeApproved()
            ->productSearch($request)
            ->selectedBrand($request)
            ->priceRange($request)
            ->setEagerLoads([])
            ->paginate(12);
        if($request->has('category')){
            $category = Category::where('slug', $request->category)->active()->setEagerLoads([])->first();
            $products = Product::where('category_id', $category->id)
                ->priceRange($request)
                ->activeApproved()
                ->setEagerLoads([])
                ->paginate(12);
            foreach($products as $product){
                $selective_brands[] = Brand::find($product->brand->id);
            }
            if(!empty($selective_brands)){
                $brands = collect($selective_brands)->unique('id');
            }
        }elseif($request->has('sub_category')){
            $sub_category = SubCategory::where('slug', $request->sub_category)
                ->active()
                ->setEagerLoads([])
                ->first();
            $products = Product::where('sub_category_id', $sub_category->id)
                ->priceRange($request)
                ->activeApproved()
                ->setEagerLoads([])
                ->paginate(12);
            foreach($products as $product){
                $selective_brands[] = Brand::find($product->brand->id);
            }
            if(!empty($selective_brands)){
                $brands = collect($selective_brands)->unique('id');
            }
        }elseif($request->has('child_category')){
            $child_category = ChildCategory::where('slug', $request->child_category)
                ->active()
                ->setEagerLoads([])
                ->first();
            $products = Product::where('child_category_id', $child_category->id)
                ->priceRange($request)
                ->activeApproved()
                ->setEagerLoads([])
                ->paginate(12);
            foreach($products as $product){
                $selective_brands[] = Brand::find($product->brand->id);
            }
            if(!empty($selective_brands)){
                $brands = collect($selective_brands)->unique('id');
            }
        }
        $products_banner_one = Advertisment::where('key', 'products_banner_one')->first();
        $products_banner_one = json_decode($products_banner_one?->value);
        return view('frontend.pages.products',
            compact(
                'products',
                'categories',
                'brands',
                'products_banner_one',
            ));
    }

    public function changeListView(Request $request)
    {
        Session::put('product_view_style', $request->style);

    }

    public function changeProductInfoView(Request $request)
    {
        Session::put('product_info_view_style', $request->style);

    }
}
