<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\VendorProductVariantDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorProductVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showTable($id, VendorProductVariantDataTable $dataTable)
    {
        $product = Product::findOrFail($id);
        //Check if editor is product owner
        if(Auth::user()->vendor->id != $product->vendor_id){
            abort(404);
        }
        return $dataTable->with('product_id', $id)
            ->render('vendor.product.product-variant.index', compact('product'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        //Check if editor is product owner
        if(Auth::user()->vendor->id != $product->vendor_id){
            abort(404);
        }
        return view('vendor.product.product-variant.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product = Product::find($request->product_id);
        //Check if editor is product owner
        if(Auth::user()->vendor->id != $product->vendor_id){
            abort(404);
        }
        $request->validate([
            'product_id' => ['required' , 'integer'],
            'name' => ['required', 'string', 'max:100'],
            'status' => ['required', 'boolean'],
        ]);

        $variant = new ProductVariant();
        $variant->product_id = $request->product_id;
        $variant->name = $request->name;
        $variant->status = $request->status;
        $variant->save();

        toastr()->success('Product Variant Created Successfully!');

        return redirect()->route('vendor.products-variant.showTable', $request->product_id);

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
        $variant = ProductVariant::findOrFail($id);
        //Check if editor is product owner
        if(Auth::user()->vendor->id != $variant->product->vendor_id){
            abort(404);
        }
        return view('vendor.product.product-variant.edit', compact('variant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'status' => ['required', 'boolean'],
        ]);

        $variant = ProductVariant::findOrFail($id);
        //Check if editor is product owner
        if(Auth::user()->vendor->id != $variant->product->vendor_id){
            abort(404);
        }
        $variant->name = $request->name;
        $variant->status = $request->status;
        $variant->save();

        toastr()->success('Product Variant Updated Successfully!');

        return redirect()->route('vendor.products-variant.showTable', $variant->product_id);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $variant = ProductVariant::findOrFail($id);
        //Check if editor is product owner
        if(Auth::user()->vendor->id != $variant->product->vendor_id){
            abort(404);
        }
        $variant_items = ProductVariantItem::where('variant_id', $variant->id)->count();
        if($variant_items > 0){
            toastr()->error('Variant Cannot Be Deleted');

            return response(['status' => 'error', 'message' => 'This Variant contains Sub-Items!!']);
        }
        $variant->delete();

        return response(['status' => 'success', 'message' => 'Product Variant Deleted Successfully!']);

    }

    public function changeStatus(Request $request){
        $variant = ProductVariant::findOrFail($request->id);
        //Check if editor is product owner
        if(Auth::user()->vendor->id != $variant->product->vendor_id){
            abort(404);
        }
        $variant->status = $request->status == 'true' ? 1 : 0;
        $variant->save();

        return response(['message' => 'Status Has Been Changed']);
    }
}
