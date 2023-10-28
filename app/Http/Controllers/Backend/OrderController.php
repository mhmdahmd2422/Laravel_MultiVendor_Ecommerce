<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\CanceledOrderDataTable;
use App\DataTables\DeliveredOrderDataTable;
use App\DataTables\DeliveryOrderDataTable;
use App\DataTables\DroppedOrderDataTable;
use App\DataTables\OrderDataTable;
use App\DataTables\PendingOrderDataTable;
use App\DataTables\ProcessedOrderDataTable;
use App\DataTables\ShippedOrderDataTable;
use App\DataTables\TransactionDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(OrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.index');
    }

    public function pendingOrders(PendingOrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.pending-orders');
    }

    public function processedOrders(ProcessedOrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.processed-orders');
    }

    public function droppedOrders(DroppedOrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.dropped-orders');
    }

    public function shippedOrders(ShippedOrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.shipped-orders');
    }

    public function deliveryOrders(DeliveryOrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.delivery-orders');
    }

    public function deliveredOrders(DeliveredOrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.delivered-orders');
    }

    public function canceledOrders(CanceledOrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.canceled-orders');
    }

    public function transactions(TransactionDataTable $dataTable)
    {
        return $dataTable->render('admin.transaction.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::findOrFail($id);
        $address = json_decode($order->order_address);
        $shipping = json_decode($order->order_shipping);
        $coupon = json_decode($order->order_coupon);
        return view('admin.order.show',
            compact(
                'order',
                'address',
                'shipping',
                'coupon',
            ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);
        //delete order products
        $order->products()->delete();
        //delete order transaction
        $order->transaction()->delete();
        //delete order
        $order->delete();

        return response(['status' => 'success', 'message' => 'Order Has Been Deleted']);
    }

    public function changeOrderStatus(Request $request)
    {
        $order = Order::findOrFail($request->id);
        $order->order_status = $request->status;
        $order->save();

        return response(['status' => 'success', 'message' => 'Updated Order Status']);
    }
    public function changePaymentStatus(Request $request)
    {
        $order = Order::findOrFail($request->id);
        $order->payment_status = $request->status;
        $order->save();

        return response(['status' => 'success', 'message' => 'Updated Payment Status']);
    }
}
