<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use App\Models\HomepageSetting;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;

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

}
