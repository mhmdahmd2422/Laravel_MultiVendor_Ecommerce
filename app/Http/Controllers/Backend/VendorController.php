<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ProductReview;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function dashboard(){
        $totalOrders = $this->getVendorOrdersCount();
        $todayTotalOrders = $this->getVendorOrdersCount($status = null, $time = 'today');
        $totalPendingOrders = $this->getVendorOrdersCount($status = 'pending');
        $todayPendingOrders = $this->getVendorOrdersCount($status = 'pending', $time = 'today');
        $totalDoneOrders = $this->getVendorOrdersCount($status = 'delivered');
        $todayDoneOrders =  $this->getVendorOrdersCount($status = 'delivered', $time = 'today');
        $totalActiveProducts = Product::activeApproved()
            ->vendorIs(auth()->user()->vendor->id)
            ->count();
        $totalInactiveProducts = Product::inactiveOrUnapproved()
            ->vendorIs(auth()->user()->vendor->id)
            ->count();
        $totalReviews = ProductReview::vendorIs(auth()->user()->vendor->id)->active()->count();
        $totalReviewsAvg = ProductReview::vendorIs(auth()->user()->vendor->id)->active()->avg('rate');
        $totalEarnings = $this->getVendorEarnings();
        $totalMonthEarnings = $this->getVendorEarnings($time = 'month');
        return view('vendor.dashboard.dashboard',
            compact(
                'totalOrders',
                'todayTotalOrders',
                'totalPendingOrders',
                'todayPendingOrders',
                'totalDoneOrders',
                'todayDoneOrders',
                'totalActiveProducts',
                'totalInactiveProducts',
                'totalReviews',
                'totalReviewsAvg',
                'totalEarnings',
                'totalMonthEarnings',
            )
        );
    }

    public function getVendorEarnings($time = null)
    {
        $sum = 0;
        $query = OrderProduct::vendorIs(auth()->user()->vendor->id)
        ->whereHas('order', function ($order){
            $order->whereStatus('delivered');
        });
        if($time === 'month'){
            $query->whereDate('created_at' ,'>=', Carbon::now()->subDays(30));
        }
        $products = $query->get();
        foreach ($products as $product){
            $productTotal = ($product->unit_price + $product->product_variants_total) * $product->quantity;
            $sum += $productTotal;
        }
        return $sum;
    }

    public function getVendorOrdersCount($status = null, $time = null)
    {
        $query = Order::whereHas('products', function ($productOrder) use ($time) {
                $productOrder->vendorIs(auth()->user()->vendor->id);
                if($time === 'today'){
                    $productOrder->createdAt(Carbon::today());
                }
                });
        if(isset($status)){
            $query->whereStatus($status);
        }

        return $query->count();
    }
}
