<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ProductVariantItemDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantItem;
use Illuminate\Http\Request;

class ProductVariantItemController extends Controller
{
    public function showTable(String $product_id, String $variant_id, ProductVariantItemDataTable $dataTable)
    {
        $product = Product::findOrFail($product_id);
        $variant = ProductVariant::findOrFail($variant_id);
        return $dataTable->with(['product_id', $product_id])
            ->render('admin.product.product-variant-item.index', compact('variant', 'product'));
    }

    public function create(String $product_id, String $variant_id){
        $variant = ProductVariant::findOrFail($variant_id);
        $product = Product::findOrFail($product_id);
        return view('admin.product.product-variant-item.create', compact('variant', 'product'));
    }

    public function store(Request $request){

        $request->validate([
            'variant_id' => ['required', 'integer'],
            'product_id' => ['required', 'integer'],
            'variant_name' => ['required' , 'string', 'exists:product_variants,name'],
            'name' => ['required', 'string', 'max:100'],
            'price' => ['required', 'decimal:0,2'],
            'is_default' => ['required', 'boolean'],
            'status' => ['required', 'boolean'],
        ]);

        $item = new ProductVariantItem();
        $item->variant_id = $request->variant_id;
        $item->name = $request->name;
        $item->price = $request->price;
        $item->is_default = $request->is_default;
        $item->status = $request->status;
        $item->save();

        toastr()->success('Product Variant Item Created Successfully!');

        return redirect()->route('admin.products-variant-items.showTable', [$request->product_id, $request->variant_id]);
    }

    public function edit(String $variant_item_id){
        $item = ProductVariantItem::findOrFail($variant_item_id);
        return view('admin.product.product-variant-item.edit', compact('item'));
    }

    public function update(Request $request, String $id){
        $request->validate([
            'variant_id' => ['required', 'integer'],
            'variant_name' => ['required' , 'string', 'exists:product_variants,name'],
            'name' => ['required', 'string', 'max:100'],
            'price' => ['required', 'decimal:0,2'],
            'is_default' => ['required', 'boolean'],
            'status' => ['required', 'boolean'],
        ]);

        $item = ProductVariantItem::findOrFail($id);
        $item->name = $request->name;
        $item->price = $request->price;
        $item->is_default = $request->is_default;
        $item->status = $request->status;
        $item->save();

        toastr()->success('Product Variant Item Updated Successfully!');

        return redirect()->route('admin.products-variant-items.showTable', [$item->variant->product_id, $item->variant_id]);
    }

    public function destroy(String $id){

        $item = ProductVariantItem::findOrFail($id);
        $item->delete();

        return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
    }

    public function changeStatus(Request $request){
        $item = ProductVariantItem::findOrFail($request->id);
        $item->status = $request->status == 'true' ? 1 : 0;
        $item->save();

        return response(['message' => 'Status Has Been Changed']);
    }
}
