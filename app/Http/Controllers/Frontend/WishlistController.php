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
}
