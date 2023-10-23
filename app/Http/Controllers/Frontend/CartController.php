<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\ProductVariantItem;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use function PHPUnit\Framework\isEmpty;

class CartController extends Controller
{
    public function cartDetails(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $cartItems = Cart::content();
        if($cartItems->isEmpty()){
            Session::forget('coupon');
            toastr('Cart Is Cleared!', 'warning', 'Warning');
            return redirect()->route('home');
        }

        return view('frontend.pages.cart-details',compact('cartItems'));
    }
    public function addToCart(Request $request): \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $product = Product::findOrFail($request->product_id);
        // Check if sufficient stock
        if($product->quantity === 0){
            return response(['status' => 'error', 'message' => 'Out Of Stock']);
        }elseif($product->quantity < $request->quantity){
            return response(['status' => 'error', 'message' => 'No Sufficient Stock']);
        }
        foreach(Cart::content() as $cartItem){
            if($cartItem->id == $product->id){
                if($cartItem->qty >= $product->quantity){
                    return response(['status' => 'error', 'message' => 'No Sufficient Stock']);
                }
            }
        }
        $variantItems = [];
        $variantTotalPrice = 0;
        if($request->has('variant_items')){
            foreach ($request->variant_items as $item_id){
                $item = ProductVariantItem::find($item_id);
                $variantItems[$item->variant->name]['name'] = $item->name;
                $variantItems[$item->variant->name]['price'] = $item->price;
                $variantTotalPrice += $item->price;
            }
        }
        $cartData = [];
        $cartData['id'] = $product->id;
        $cartData['name'] = $product->name;
        $cartData['qty'] = $request->quantity;
        $cartData['price'] = returnPriceOrDiscount($product) * $request->quantity;
        $cartData['weight'] = 10;
        $cartData['options']['variants'] = $variantItems;
        $cartData['options']['variants_totalPrice'] = $variantTotalPrice;
        $cartData['options']['image'] = $product->thumb_image;
        $cartData['options']['slug'] = $product->slug;
        Cart::add($cartData);

        return response(['status' => 'success', 'message' => 'Added To Cart']);
    }

    public function updateQuantity(Request $request): \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $product_id = Cart::get($request->row_id)->id;
        $product = Product::findOrFail($product_id);
        // Check if sufficient stock
        if($product->quantity === 0){
            return response(['status' => 'error', 'message' => 'Out Of Stock']);
        }elseif($product->quantity < $request->quantity){
            return response(['status' => 'error', 'message' => 'No Sufficient Stock']);
        }
        Cart::update($request->row_id, $request->quantity);
        $productTotal = $this->getProductTotal($request->row_id);

        return response(['status' => 'success', 'message' => 'Product Quantity Is Updated', 'product_total' => $productTotal]);
    }

    public function getProductTotal(String $rowId): float|int
    {
        $product = Cart::get($rowId);
        $total = ($product->price + $product->options->variants_totalPrice)* $product->qty;

        return $total;
    }

    public function removeItem(Request $request): \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        Cart::remove($request->row_id);

        return response(['status' => 'success', 'message'=> 'Product Is Removed From Cart']);
    }

    public function clearCart(): \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
       if(Cart::content()->isEmpty()){
           return response(['status' => 'error', 'message' => 'Your Cart Is Already Cleared!']);
       }else{
           Cart::destroy();
           return response(['status' => 'success', 'message' => 'Your Cart Is Now Cleared']);
       }
    }

    public function getCartCount()
    {
        return Cart::count();
    }

    public function getCartProducts(): \Illuminate\Support\Collection
    {
        return Cart::content();
    }

    public function getCartTotal(): float|int
    {
        $products = Cart::content();
        $total = 0;
        foreach ($products as $product) {
            $total += ($product->price + $product->options->variants_totalPrice)* $product->qty;
        }
        return $total;
    }

    public function applyCoupon(Request $request)
    {
        if($request->coupon_code === null){
            return response(['status' => 'error', 'message' => 'Please Enter Coupon Code!']);
        }
        $coupon = Coupon::where('code', $request->coupon_code)
            ->dateActiveCoupons()
            ->quantityActiveCoupons()
            ->first();
        if($coupon === null){
            return response([
                'status' => 'error',
                'message' => 'Coupon Code Is Invalid'
            ]);
        }
        if($this->getCartTotal() < $coupon->discount_value){
            return response([
                'status' => 'error',
                'message' => 'Cannot Apply This Coupon'
            ]);
        }else{
            Session::put('coupon', [
                'coupon_name' => $coupon->name,
                'coupon_code' => $coupon->code,
                'discount_type' => $coupon->discount_type,
                'discount_value' => $coupon->discount_value,
            ]);
            return response(['status' => 'success',
                'message' => 'Coupon Has Been Applied',
                'coupon_name' => $coupon->name,
            ]);
        }
    }

    public function calculateCouponDiscount()
    {
        if(Session::has('coupon')){
            $coupon = collect(Session::get('coupon'));
            if($coupon->get('discount_type') === 'amount'){
                $cartTotal = $this->getCartTotal();
                if($cartTotal > $coupon->get('discount_value')){
                    $totalAfterDiscount = $cartTotal - $coupon->get('discount_value');
                    return response([
                        'status' => 'success',
                        'new_cart_total' => $totalAfterDiscount,
                        'discount_value' => $coupon->get('discount_value'),
                    ]);
                }else{
                    return response([
                        'status' => 'error',
                        'new_cart_total' => $cartTotal,
                        'discount_value' => 0,
                    ]);
                }
            }elseif($coupon->get('discount_type') === 'percent'){
                $cartTotal = $this->getCartTotal();
                $discountValue = round($cartTotal * ($coupon->get('discount_value')/100),2);
                $totalAfterDiscount = round($cartTotal - $discountValue, 2);
                return response(['status' => 'success',
                    'new_cart_total' => $totalAfterDiscount,
                    'discount_value' => $discountValue
                ]);
            }
        }else{
            return response(['status' => 'success',
                'new_cart_total' => $this->getCartTotal(),
                'discount_value' => 0,
            ]);
        }
    }
    public function removeCoupon()
    {
        if(Session::has('coupon')){
            Session::forget('coupon');
            return response(['status' => 'success',
                'message' => 'Coupon Is Removed From Cart',
                'cart_total' => $this->getCartTotal(),
            ]);
        }else{
            return response(['status' => 'error',
                'message' => 'Cannot Remove Coupon Due To An Error'
            ]);
        }
    }
}
