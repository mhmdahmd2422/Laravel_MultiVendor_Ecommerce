<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ProductVariantDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantItem;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showTable($id, ProductVariantDataTable $dataTable)
    {
        $product = Product::findOrFail($id);
        return $dataTable->with('product_id', $id)
            ->render('admin.product.product-variant.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
//        dd($request->all());
        $product = Product::findOrFail($request->product_id);
        return view('admin.product.product-variant.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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

        return redirect()->route('admin.products-variant.showTable', $request->product_id);

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
        return view('admin.product.product-variant.edit', compact('variant'));
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
        $variant->name = $request->name;
        $variant->status = $request->status;
        $variant->save();

        toastr()->success('Product Variant Created Successfully!');

        return redirect()->route('admin.products-variant.showTable', $variant->product_id);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $variant = ProductVariant::findOrFail($id);
        $variant_items = ProductVariantItem::where('variant_id', $variant->id)->count();
        if($variant_items > 0){
            toastr()->error('Variant Cannot Be Deleted');

            return response(['status' => 'error', 'message' => 'This Variant contains Sub-Items!!']);
        }
        $variant->delete();

        return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
    }

    public function changeStatus(Request $request){
        $variant = ProductVariant::findOrFail($request->id);
        $variant->status = $request->status == 'true' ? 1 : 0;
        $variant->save();

        return response(['message' => 'Status Has Been Changed']);
    }
}
