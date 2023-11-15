<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ProductReview;
use App\Models\UserAddress;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index(){
        $totalOrdersCount = Order::where('user_id', auth()->id())->count();
        $totalReviewsCount = ProductReview::where('user_id', auth()->id())->count();
        $totalWishlistCount = Wishlist::where('user_id', auth()->id())->count();
        $totalAddressesCount = UserAddress::where('user_id', auth()->id())->count();

        return view('frontend.dashboard.dashboard',
            compact(
                'totalOrdersCount',
                'totalReviewsCount',
                'totalWishlistCount',
                'totalAddressesCount',
            ));
    }

}
