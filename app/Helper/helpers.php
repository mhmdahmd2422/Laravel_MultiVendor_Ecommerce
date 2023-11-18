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

function returnDiscountOrFalse(Product $product)
{
    $currentDate = date('Y-m-d');

    if($product->offer_price > 0 &&
        $currentDate >= $product->offer_start_date &&
        $currentDate <= $product->offer_end_date
    ){
        return $product->offer_price;
    }
    return false;
}


function discountPercent(int $price_before, int $price_after){

    return ceil(($price_before - $price_after)/$price_before *100);
}

function getDiscountValueFromPercent(int $discountPercent, int $beforeDiscount){
    $discountValue = round($beforeDiscount * ($discountPercent/100),2);
    return $discountValue;
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
            $discountValue = getCartTotal() * round(($coupon->get('discount_value')/100),2);
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

function getToken($length = 10)
{
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet.= "0123456789";
    $max = strlen($codeAlphabet); // edited

    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[crypto_rand_secure(0, $max-1)];
    }

    return $token;
}

function limitText(string $text, $limit = 20)
{
    return Str::limit($text, $limit);
}

function changeRelatedProductsAdminStatus(\Illuminate\Database\Eloquent\Model $model, string $column_name, $status)
{
    $products = Product::where($column_name, $model->id)->get();
    if($status === 'true' || $status == 1){
        $model->status = 1;
        foreach ($products as $product){
            $product->admin_status = $product->admin_status_cache;
            $product->save();
        }
    }else if($status === 'false' || $status == 0){
        $model->status = 0;
        foreach ($products as $product){
            $product->admin_status = 0;
            $product->save();
        }
    }

    return $model;
}

function checkBeforeCategoryDelete(\Illuminate\Database\Eloquent\Model $category, string $column_name){
    $products = Product::where($column_name, $category->id)->get();
    if($products->isNotEmpty()) {
        return response(['status' => 'error', 'message' => 'This Category Has Registered Products! Delete All Category Products to Delete Or Ban the Category Instead.']);
    }
    $homeSettings = \App\Models\HomepageSetting::all();
    $flag = false;
    foreach ($homeSettings as $homeSetting) {
        $array = json_decode($homeSetting->value, true);
        $collection = collect($array);
        if($collection->contains(rtrim($column_name, '_id'), $category->id)){
            $flag = true;
        }
    }
    if($flag){
        return response(['status' => 'error', 'message' => 'This Category Is Featured In Homepage!']);
    }

    return $category;
}


