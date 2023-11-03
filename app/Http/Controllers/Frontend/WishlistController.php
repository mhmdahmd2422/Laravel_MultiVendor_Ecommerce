<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariantItem;
use App\Models\Wishlist;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlist_items = Wishlist::where('user_id', Auth::id())->orderBy('id', 'DESC')->get();

        return view('frontend.pages.wishlist', compact('wishlist_items'));
    }

    public function addToWishlist(Request $request)
    {
        if (Auth::check()) {
            $product = Product::activeApproved()->find($request->productId);
            if (Wishlist::where([['product_id', $product->id], ['user_id', Auth::id()]])->exists()) {
                return response(['status' => 'error', 'message' => 'Product Is Already Added To Your Wishlist']);
            } else {
                $wishlist = new Wishlist();
                $wishlist->product_id = $product->id;
                $wishlist->user_id = Auth::id();
                $wishlist->save();
                $wishlist_count = Wishlist::where('user_id', Auth::id())->count();
                return response([
                    'status' => 'success',
                    'message' => 'Added To Wishlist!',
                    'wishlistCount' => $wishlist_count,
                ]);
            }
        } else {
            return response([
                'status' => 'error',
                'message' => 'Please Login To Add Products To Your Wishlist'
            ]);
        }
    }

    public function removeFromWishlist(Request $request)
    {
        $wishlist = Wishlist::findOrFail($request->id);

        if ($wishlist->user_id === Auth::id()) {
            $wishlist->delete();

            return response(['status' => 'success', 'message' => 'Item Is Removed From Wishlist']);
        }
        return response(['status' => 'error', 'message' => 'Something Went Wrong!']);
    }

    public function addToCartFromWishlist(Request $request): \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $wishlist = Wishlist::findOrFail($request->wishlist_id);

        $product = Product::findOrFail($request->product_id);
        // Check if sufficient stock
        if ($product->quantity === 0) {
            return response(['status' => 'error', 'message' => 'Out Of Stock']);
        } elseif ($product->quantity < $request->product_qty) {
            return response(['status' => 'error', 'message' => 'No Sufficient Stock']);
        }
        foreach (Cart::content() as $cartItem) {
            if ($cartItem->id == $product->id) {
                if ($cartItem->qty >= $product->quantity) {
                    return response(['status' => 'error', 'message' => 'No Sufficient Stock']);
                }
            }
        }
        $variantItems = [];
        $variantTotalPrice = 0;
        if ($request->has('variant_items')) {
            foreach ($request->variant_items as $item_id) {
                $item = ProductVariantItem::find($item_id);
                $variantItems[$item->variant->name]['name'] = $item->name;
                $variantItems[$item->variant->name]['price'] = $item->price;
                $variantTotalPrice += $item->price;
            }
        }
        if ($wishlist->user_id === Auth::id()) {
            $wishlist->delete();
        }else{
            return response(['status' => 'error', 'message' => 'Something Went Wrong']);
        }
        $cartData = [];
        $cartData['id'] = $product->id;
        $cartData['name'] = $product->name;
        $cartData['qty'] = $request->product_qty;
        $cartData['price'] = returnPriceOrDiscount($product) * $request->product_qty;
        $cartData['weight'] = 10;
        $cartData['options']['variants'] = $variantItems;
        $cartData['options']['variants_totalPrice'] = $variantTotalPrice;
        $cartData['options']['image'] = $product->thumb_image;
        $cartData['options']['slug'] = $product->slug;
        Cart::add($cartData);


        return response(['status' => 'success', 'message' => 'Added To Cart']);
    }
}
