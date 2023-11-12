<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderTrackController extends Controller
{
    public function index()
    {
        return view('frontend.pages.order-track');
    }

    public function track(Request $request)
    {
        $request->validate([
           'invoice_id' => ['required', 'string', 'exists:orders,invoice_id'],
            'email' => ['required', 'email', 'exists:users,email'],
        ]);

        $order = Order::where('invoice_id', $request->invoice_id)->first();
        if($order === null || $order->user->email != $request->email){
            return response(['status' => 'error', 'message' => 'Please Check Submitted Order Details']);
        }else{
//            foreach (config('order_status.order_status_admin') as $status){
//                dd($status['pending']);
//            }
            $status_array = config('order_status.order_status_admin');
            return response([
                'status' => 'success',
                'order_at' => date('d-m-Y', strtotime($order->created_at)),
                'order_by' => $order->user->name,
                'order_status' => $status_array[$order->order_status]['status'],
                'payment' => $order->payment_method,
            ]);
        }

    }
}
