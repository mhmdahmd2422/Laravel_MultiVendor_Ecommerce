<?php

// Set Sidebar Item Active

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;
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

function getCartTotal()
{
    $products = Cart::content();
    $total = 0;
    foreach ($products as $product) {
        $total += ($product->price + $product->options->variants_totalPrice)* $product->qty;
    }
    return $total;
}

function getMainCartTotal(){
    if(Session::has('coupon')){
        $coupon = collect(Session::get('coupon'));
        if($coupon->get('discount_type') === 'amount'){
            $cartTotal = getCartTotal();
            if($cartTotal > $coupon->get('discount_value')){
                $totalAfterDiscount = $cartTotal - $coupon->get('discount_value');
                return $totalAfterDiscount;
            }else{
                return $cartTotal;
            }
        }elseif($coupon->get('discount_type') === 'percent'){
            $cartTotal = getCartTotal();
            $discountValue = round($cartTotal * ($coupon->get('discount_value')/100),2);
            $totalAfterDiscount = round($cartTotal - $discountValue, 2);
            return $totalAfterDiscount;
        }
    }else{
        return getCartTotal();
    }
}

//get shipping fees from session
function getShippingFee()
{
    if(Session::has('shipping')){
        return Session::get('shipping')['cost'];
    }else{
        return 0;
    }
}

//get coupon discount from session
function getCartDiscount()
{
    if(Cart::content()->isNotEmpty() && Session::has('coupon')){
        $coupon = collect(Session::get('coupon'));
        if($coupon->get('discount_type') === 'amount'){
            return $coupon->get('discount_value');
        }elseif($coupon->get('discount_type') === 'percent'){
            $discountValue = round(($coupon->get('discount_value')/100),2);
            return $discountValue;
        }
    }else{
        Session::forget('coupon');
        return 0;
    }
}

//get payment amount (main total +shipping)
function getPaymentAmount()
{
    return getMainCartTotal() + getShippingFee();
}

//generate unique encrypted token
function crypto_rand_secure($min, $max)
{
    $range = $max - $min;
    if ($range < 1) return $min; // not so random...
    $log = ceil(log($range, 2));
    $bytes = (int) ($log / 8) + 1; // length in bytes
    $bits = (int) $log + 1; // length in bits
    $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
        $rnd = $rnd & $filter; // discard irrelevant bits
    } while ($rnd > $range);
    return $min + $rnd;
}

function getToken()
{
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet.= "0123456789";
    $max = strlen($codeAlphabet); // edited

    for ($i=0; $i < 10; $i++) {
        $token .= $codeAlphabet[crypto_rand_secure(0, $max-1)];
    }

    return $token;
}
