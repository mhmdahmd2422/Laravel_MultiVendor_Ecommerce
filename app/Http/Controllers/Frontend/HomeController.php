<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $sliders = Slider::where('status', 1)->orderBy('serial')->get();
        $flash_sale_date = FlashSale::first();
        $flash_sale_items = FlashSaleItem::showActive()->get();
        return view('frontend.home.home',
            compact(
                'sliders',
                'flash_sale_date',
                'flash_sale_items'
            ));
    }
}
