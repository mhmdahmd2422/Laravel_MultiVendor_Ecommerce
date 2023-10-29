<?php

namespace App\Http\Controllers\Frontend;

use App\DataTables\UserOrderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class UserOrderController extends Controller
{
    public function index(UserOrderDataTable $dataTable)
    {
        return $dataTable->render('frontend.dashboard.order.index');
    }

    public function show(String $id)
    {
        $order = Order::with(['user', 'products'])->findOrFail($id);
        $address = json_decode($order->order_address);
        $shipping = json_decode($order->order_shipping);
        $coupon = json_decode($order->order_coupon);
        return view('frontend.dashboard.order.show',
            compact(
                'order',
                'address',
                'shipping',
                'coupon'
            ));
    }
}
