<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Brand;
use App\Models\Category;
use App\Models\NewsletterSubscriber;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\User;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function login(){
        return view('admin.auth.login');
    }
    public function dashboard(){
        //vars are ordered per view row
        $totalOrders = $this->getAdminOrdersCount();
        $todayTotalOrders = $this->getAdminOrdersCount($status = null, $time = 'today');
        $totalPendingOrders = $this->getAdminOrdersCount($status = ['pending','processed_and_ready_to_ship','dropped_off','shipped','out_for_delivery']);
        $todayPendingOrders = $this->getAdminOrdersCount($status = ['pending','processed_and_ready_to_ship','dropped_off','shipped','out_for_delivery'], $time = 'today');
        $totalDoneOrders = $this->getAdminOrdersCount($status = ['delivered']);
        $todayDoneOrders =  $this->getAdminOrdersCount($status = ['delivered'], $time = 'today');
        $totalCanceledOrders = $this->getAdminOrdersCount($status = ['canceled']);
        $todayCanceledOrders =  $this->getAdminOrdersCount($status = ['canceled'], $time = 'today');
        $totalEarnings = $this->getAdminEarnings();
        $totalTodayEarnings = $this->getAdminEarnings($time = 'today');
        $totalMonthEarnings = $this->getAdminEarnings($time = 'month');
        $totalYearEarnings = $this->getAdminEarnings($time = 'year');
        $totalActiveCategories = Category::active()->count();
        $totalInactiveCategories = Category::inactive()->count();
        $totalActiveProducts = Product::activeApproved()->count();
        $totalInactiveProducts = Product::inactive()->count();
        $totalActiveBlogs = Blog::active()->count();
        $totalInactiveBlogs = Blog::inactive()->count();
        $totalUnapprovedProducts = $this->getApprovedProductsCount($approve = 0);
        $totalActiveReviews = ProductReview::active()->count();
        $totalPendingReviews = ProductReview::inactive()->count();
        $totalActiveUsers = $this->getUsersCount($status = 'active');
        $totalInactiveUsers = $this->getUsersCount($status = 'inactive');
        $totalActiveBrands = $this->getBrandsCount($status = 1);
        $totalInactiveBrands = $this->getBrandsCount($status = 0);
        $totalActiveVendors = $this->getVendorsCount($status = 1);
        $totalInactiveVendors = $this->getVendorsCount($status = 0);
        $totalUnapprovedVendors = $this->getApprovedVendorsCount($approve = 0);
        $totalVerifiedSubs = $this->getNewsletterSubsCount($verified = true);
        $totalPendingSubs = $this->getNewsletterSubsCount($verified = false);
        return view('admin.dashboard',
            //params are ordered per view row
            compact(
                'totalOrders',
                'todayTotalOrders',
                'totalPendingOrders',
                'todayPendingOrders',
                'totalDoneOrders',
                'todayDoneOrders',
                'totalCanceledOrders',
                'todayCanceledOrders',
                'totalEarnings',
                'totalTodayEarnings',
                'totalMonthEarnings',
                'totalYearEarnings',
                'totalActiveCategories',
                'totalInactiveCategories',
                'totalActiveProducts',
                'totalInactiveProducts',
                'totalUnapprovedProducts',
                'totalActiveBlogs',
                'totalInactiveBlogs',
                'totalActiveReviews',
                'totalPendingReviews',
                'totalActiveUsers',
                'totalInactiveUsers',
                'totalActiveBrands',
                'totalInactiveBrands',
                'totalActiveVendors',
                'totalInactiveVendors',
                'totalUnapprovedVendors',
                'totalVerifiedSubs',
                'totalPendingSubs',
            )
        );
    }

    public function getAdminOrdersCount(array $status = null, string $time = null)
    {
        $query = Order::whereHas('products', function ($productOrder) use ($time) {
            if($time === 'today'){
                $productOrder->createdAt(Carbon::today());
            }
        });
        if(isset($status)){
            $query->whereStatus($status[0]);
            for($i=1; $i<count($status); $i++){
                $query->orWhereStatus($status[$i]);
            }
        }
        return $query->count();
    }

    public function getAdminEarnings(string $time = null)
    {
        $sum = 0;
        $query = OrderProduct::whereHas('order', function ($order)
            {
                $order->whereStatus('delivered');
            });
        if($time === 'today'){
            $query->whereDate('created_at' ,'>=', Carbon::now());
        }
        if($time === 'month'){
            $query->whereDate('created_at' ,'>=', Carbon::now()->subDays(30));
        }
        if($time === 'year'){
            $query->whereDate('created_at' ,'>=', Carbon::now()->subDays(365));
        }
        $products = $query->get();
        foreach ($products as $product){
            $productTotal = ($product->unit_price + $product->product_variants_total) * $product->quantity;
            $sum += $productTotal;
        }
        return $sum;
    }

    public function getUsersCount(string $status = null)
    {
        return User::where('status', $status)->count();
    }

    public function getBrandsCount(int $status = null)
    {
        return Brand::where('status', $status)->count();
    }

    public function getVendorsCount(int $status = null)
    {
        return Vendor::where('status', $status)->count();
    }

    public function getApprovedVendorsCount(int $approve = null)
    {
        return Vendor::where('is_approved', $approve)->count();
    }

    public function getNewsletterSubsCount(bool $verified = false)
    {
        if($verified){
            return NewsletterSubscriber::where('verified_at', '!=', 0)->count();
        }else{
            return NewsletterSubscriber::where('verified_at', '=', 0)->count();
        }
    }

    public function getApprovedProductsCount(int $approve = null)
    {
        return Product::where('is_approved', $approve)->count();
    }

}
