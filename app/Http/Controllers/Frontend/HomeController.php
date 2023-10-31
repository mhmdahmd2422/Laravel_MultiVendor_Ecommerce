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
        $popular_category = HomepageSetting::where('key', 'popular_category_section')->first();
        $brands = Brand::activeFeatured()->get();
        $type_base_products = $this->getTypeBaseProduct();
        return view('frontend.home.home',
            compact(
                'sliders',
                'flash_sale_date',
                'flash_sale_items',
                'popular_category',
                'brands',
                'type_base_products',
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
