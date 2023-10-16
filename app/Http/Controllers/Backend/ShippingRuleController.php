<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ShippingRuleDataTable;
use App\Http\Controllers\Controller;
use App\Models\ShippingRule;
use Illuminate\Http\Request;

class ShippingRuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ShippingRuleDataTable $dataTable)
    {
        return $dataTable->render('admin.shipping.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.shipping.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rule = new ShippingRule();

        $alert = 'New Shipping Method Has Been Created';
        $route = 'admin.shipping.index';

        return $this->submitForm($request, $rule, $alert, $route);
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
        $rule = ShippingRule::findOrFail($id);

        return view('admin.shipping.edit', compact('rule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rule = ShippingRule::findOrFail($id);

        $alert = 'Shipping Method Has Been Updated';
        $route = 'admin.shipping.index';

        return $this->submitForm($request, $rule, $alert, $route);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rule = ShippingRule::findOrFail($id);
        $rule->delete();

        return response(['status' => 'success', 'message' => 'Shipping Method Has Been Deleted']);
    }

    public function changeStatus(Request $request){
        $rule = ShippingRule::findOrFail($request->id);
        $rule->status = $request->status == 'true' ? 1 : 0;
        $rule->save();

        return response(['message' => 'Status Has Been Changed']);
    }

    public function submitForm(Request $request, ShippingRule $rule, String $alert, String $route): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:200'],
            'type' => ['required', 'string', 'max:9'],
            'min_cost' => ['required_if:type,min_cost', 'max:50'],
            'cost' => ['required', 'numeric'],
            'status' => ['required', 'boolean'],
            'currency' => ['required', 'string', 'max:1'],
        ]);
        $rule->name = $request->name;
        $rule->type = $request->type;
        if($request->type =='min_cost') {
            $rule->min_cost = $request->min_cost;
        }else{
            $rule->min_cost = 0;
        }
        $rule->cost = $request->cost;
        $rule->status = $request->status;
        $rule->currency = $request->currency;
        $rule->save();

        flash()->addSuccess($alert);

        if($route != null) {
            return redirect()->route($route);
        }else{
            return redirect()->back();
        }
    }
}
