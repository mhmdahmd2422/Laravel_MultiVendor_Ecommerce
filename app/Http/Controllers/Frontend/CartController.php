<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariantItem;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

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

    public function cartDetails()
    {
        $cartItems = Cart::content();

        return view('frontend.pages.cart-details',compact('cartItems'));
    }

    public function updateQuantity(Request $request)
    {
        Cart::update($request->row_id, $request->quantity);
        $productTotal = $this->getProductTotal($request->row_id);

        return response(['status' => 'success', 'message' => 'Product Quantity Is Updated', 'product_total' => $productTotal]);
    }

    public function getProductTotal(String $rowId)
    {
        $product = Cart::get($rowId);
        $total = ($product->price + $product->options->variants_totalPrice)* $product->qty;

        return $total;
    }

    public function removeItem(Request $request)
    {
        Cart::remove($request->row_id);

        return response(['status' => 'success', 'message'=> 'Product Is Removed From Cart']);
    }

    public function clearCart()
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
}
