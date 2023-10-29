<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\VendorOrderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class VendorOrderController extends Controller
{
    public function index(VendorOrderDataTable $dataTable)
    {
        return $dataTable->render('vendor.order.index');
    }

    public function show(String $id)
    {
        $order = Order::with(['user', 'products'])->findOrFail($id);
        $address = json_decode($order->order_address);
        $shipping = json_decode($order->order_shipping);
        return view('vendor.order.show',
            compact(
                'order',
                'address',
                'shipping'
            ));
    }

    public function orderStatus(Request $request)
    {
        $order = Order::findOrFail($request->id);
        $order->order_status = $request->status;
        $order->save();
        $label = config('order_status.order_status_vendor')[$order->order_status]['details'];

        return response([
            'status' => 'success',
            'message' => 'Updated Order Status',
            'order_status' => $label,
        ]);
    }
}
