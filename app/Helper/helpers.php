<?php

// Set Sidebar Item Active

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Str;

function setActive(array $route){
    foreach ($route as $r){
        if(request()->routeIs($r)){
            return 'active';
        }
    }
}

//Check if product in discount

function checkDiscount(Product $product)
{
    $currentDate = date('Y-m-d');

    if($product->offer_price > 0 &&
        $currentDate >= $product->offer_start_date &&
        $currentDate <= $product->offer_end_date
    ){
        return true;
    }
    return false;
}

function returnPriceOrDiscount(Product $product)
{
    $currentDate = date('Y-m-d');

    if($product->offer_price > 0 &&
        $currentDate >= $product->offer_start_date &&
        $currentDate <= $product->offer_end_date
    ){
        return $product->offer_price;
    }
    return $product->price;
}


function discountPercent(int $price_before, int $price_after){

    return ceil(($price_before - $price_after)/$price_before *100);
}

function productListing(Product $product){
    if(isset($product->list_type)){
        $listing = Str::upper(Str::before($product->list_type, '_'));

        return $listing;
    }
    return false;
}

function checkStock(Product $product)
{
    if ($product->quantity > 0) {
        return true;
    } else {
        return false;
    }
}

function checkLowStock(Product $product)
{
    if ($product->quantity < 5) {
        return true;
    } else {
        return false;
    }
}

function getCartTotal()
{
    $products = Cart::content();
    $total = 0;
    foreach ($products as $product) {
        $total += ($product->price + $product->options->variants_totalPrice)* $product->qty;
    }
    return $total;
}
