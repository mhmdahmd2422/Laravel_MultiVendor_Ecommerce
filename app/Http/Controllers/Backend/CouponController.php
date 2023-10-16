<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\CouponDataTable;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CouponDataTable $dataTable)
    {
        return $dataTable->render('admin.coupon.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'max:100', 'unique:coupons'],
        ]);

        $coupon = new Coupon();
        $coupon->total_used = 0;

        $alert = 'New Coupon Has Been Created';
        $route = 'admin.coupons.index';

        return $this->submitForm($request, $coupon, $alert, $route);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('admin.coupon.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $coupon = Coupon::findOrFail($id);
        $alert = 'Coupon Has Been Updated';
        $route = 'admin.coupons.index';

        return $this->submitForm($request, $coupon, $alert, $route);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        return response(['status' => 'success', 'message' => 'Coupon Has Been Deleted Successfully!']);

    }

    public function changeStatus(Request $request){
        $coupon = Coupon::findOrFail($request->id);
        $coupon->status = $request->status == 'true' ? 1 : 0;
        $coupon->save();

        return response(['message' => 'Status Has Been Changed']);
    }
    public function submitForm(Request $request, $coupon, $alert, $route): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'quantity' => ['required', 'integer'],
            'max_use' => ['required', 'integer'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'discount_type' => ['required', 'string'],
            'discount_value' => ['required', 'numeric'],
            'status' => ['required', 'boolean'],
        ]);

        $coupon->name = $request->name;
        $coupon->code = $request->code;
        $coupon->max_use = $request->max_use;
        $coupon->quantity = $request->quantity;
        $coupon->start_date = $request->start_date;
        $coupon->end_date = $request->end_date;
        $coupon->discount_type = $request->discount_type;
        $coupon->discount_value = $request->discount_value;
        $coupon->status = $request->status;
        $coupon->save();

        flash()->addSuccess($alert);

        if($route != null) {
            return redirect()->route($route);
        }else{
            return redirect()->back();
        }
    }
}
