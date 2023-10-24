<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\ShippingRule;
use App\Models\UserAddress;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function index()
    {
        $addresses = UserAddress::where('user_id', Auth::user()->id)->get();
        $shippings = ShippingRule::where('status', 1)->get();
        return view('frontend.pages.checkout',
            compact(
                'addresses',
                'shippings'
            )
        );
    }

    public function applyShipping(Request $request)
    {
        if(Cart::content()->isNotEmpty()){
            $shipping = ShippingRule::findOrFail($request->shipping_id);
            if($shipping->type === 'flat_cost'){
                $shipping_cost = $shipping->cost;
                $total_cost = getMainCartTotal() + $shipping_cost;
                return response([
                    'status' => 'success',
                    'shipping_cost' => $shipping_cost,
                    'cart_total' => getCartTotal(),
                    'new_cart_total' => $total_cost,
                ]);
            }elseif($shipping->type === 'min_cost'){
                $shipping_cost = $shipping->cost;
                if(getCartTotal() > $shipping->min_cost){
                    $total_cost = getMainCartTotal() + $shipping_cost;
                    return response([
                        'status' => 'success',
                        'shipping_cost' => $shipping_cost,
                        'cart_total' => getCartTotal(),
                        'new_cart_total' => $total_cost,
                    ]);
                }else{
                    return response([
                        'status' => 'error',
                        'shipping_cost' => 0,
                        'message' => 'Your Total Must be More Than '.GeneralSetting::first()->currency_icon.$shipping->min_cost.' To Choose This Shipping!',
                    ]);
                }
            }
        }else{
            return response([
                'status' => 'error',
                'shipping_cost' => 0,
                'message' => 'Please Add Products To Your Cart',
            ]);
        }
    }

    public function checkoutSubmit(Request $request)
    {
        if(Cart::content()->isNotEmpty()){
            $request->validate([
                'shipping_method_id' => ['required', 'integer', 'exists:shipping_rules,id'],
                'shipping_address_id' => ['required', 'integer', 'exists:user_addresses,id'],
            ]);
            $shipping_method = ShippingRule::findOrFail($request->shipping_method_id);
            $address = UserAddress::findOrFail($request->shipping_address_id)->toArray();
            if($shipping_method && $address){
                Session::put('shipping', [
                    'id' => $shipping_method->id,
                    'name' => $shipping_method->name,
                    'type' => $shipping_method->type,
                    'cost' => $shipping_method->cost,
                ]);
                Session::put('address', $address);
                return response([
                    'status' => 'success',
                    'redirect_url' => route('user.payment'),
                ]);
            }
        }else{
            return response([
                'status' => 'error',
                'message' => 'Please Add Products To Your Cart'
                ]);
        }
    }
}
