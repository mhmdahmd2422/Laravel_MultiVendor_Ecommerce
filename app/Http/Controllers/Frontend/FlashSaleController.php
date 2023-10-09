<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use Illuminate\Http\Request;

class FlashSaleController extends Controller
{
    public function showAllFlashItems(){
        $flash_sale_date = FlashSale::first();
        $flash_sale_items = FlashSaleItem::showActive()->paginate(20);
        return view('frontend.pages.flash-sale-items', compact(
            'flash_sale_date',
            'flash_sale_items'
        ));
    }
}
