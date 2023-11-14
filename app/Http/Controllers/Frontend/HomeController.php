<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Advertisment;
use App\Models\Blog;
use App\Models\Brand;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use App\Models\HomepageSetting;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Vendor;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){
        $sliders = Slider::where('status', 1)->orderBy('serial')->get();
        $flash_sale_date = FlashSale::first();
        $flash_sale_items = FlashSaleItem::showActive()->get();
        $popular_categories = HomepageSetting::where('key', 'popular_category_section')->first();
        $popular_categories = json_decode($popular_categories->value, true);
        $brands = Brand::activeFeatured()->get();
        $type_base_products = $this->getTypeBaseProduct();
        $single_cat_section = HomepageSetting::where('key', 'single_category_section')->first();
        $single_cat_section = json_decode($single_cat_section->value, false);
        $single_cat_section_two = HomepageSetting::where('key', 'single_category_section_two')->first();
        $single_cat_section_two = json_decode($single_cat_section_two->value, false);
        $product_slider_section = HomepageSetting::where('key', 'product_slider_section')->first();
        $product_slider_section = json_decode($product_slider_section->value, true);
        $banner_one = Advertisment::where('key', 'homepage_banner_one')->first();
        $banner_one = json_decode($banner_one?->value);
        $banner_two = Advertisment::where('key', 'homepage_banner_two')->first();
        $banner_two = json_decode($banner_two?->value);
        $banner_three = Advertisment::where('key', 'homepage_banner_three')->first();
        $banner_three = json_decode($banner_three?->value);
        $banner_four = Advertisment::where('key', 'homepage_banner_four')->first();
        $banner_four = json_decode($banner_four?->value);
        $banner_five = Advertisment::where('key', 'homepage_banner_five')->first();
        $banner_five = json_decode($banner_five?->value);
        $banner_six = Advertisment::where('key', 'homepage_banner_six')->first();
        $banner_six = json_decode($banner_six?->value);
        $banner_seven = Advertisment::where('key', 'homepage_banner_seven')->first();
        $banner_seven = json_decode($banner_seven?->value);
        $blogs = Blog::activeNewest()->take(8)->get();
        return view('frontend.home.home',
            compact(
                'sliders',
                'flash_sale_date',
                'flash_sale_items',
                'popular_categories',
                'brands',
                'type_base_products',
                'single_cat_section',
                'single_cat_section_two',
                'product_slider_section',
                'banner_one',
                'banner_two',
                'banner_three',
                'banner_four',
                'banner_five',
                'banner_six',
                'banner_seven',
                'blogs',
            ));
    }

    public function getTypeBaseProduct()
    {
        $typeBaseProducts = [];
        $list_types = [
            'top_product',
            'new_arrival',
            'featured_product',
            'best_product',
        ];
        foreach ($list_types as $list_type){
            $typeBaseProducts[$list_type] = Product::with(['category', 'gallery'])
                ->listType($list_type)
                ->activeApproved()
                ->orderBy('id', 'DESC')
                ->take(8)
                ->get();
        }

        return $typeBaseProducts;
    }

    public function vendorsPage()
    {
        $vendors = Vendor::where('status', 1)->paginate(6);

        return view('frontend.pages.vendor', compact('vendors'));
    }

}
