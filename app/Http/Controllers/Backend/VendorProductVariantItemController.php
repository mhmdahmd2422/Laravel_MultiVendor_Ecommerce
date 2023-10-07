<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\VendorProductVariantItemDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorProductVariantItemController extends Controller
{
    public function showTable(String $product_id, String $variant_id, VendorProductVariantItemDataTable $dataTable)
    {
        $product = Product::findOrFail($product_id);
        //Check if editor is product owner
        if($product->vendor_id != Auth::user()->vendor->id){
            abort(404);
        }
        $variant = ProductVariant::findOrFail($variant_id);
        return $dataTable->with(['product_id', $product_id])
            ->render('vendor.product.product-variant-item.index', compact('variant', 'product'));
    }

    public function create(String $product_id, String $variant_id){
        $variant = ProductVariant::findOrFail($variant_id);
        $product = Product::findOrFail($product_id);
        //Check if editor is product owner
        if($product->vendor_id != Auth::user()->vendor->id){
            abort(404);
        }
        return view('vendor.product.product-variant-item.create', compact('variant', 'product'));
    }

    public function store(Request $request){

        //Check if editor is product
        $product = Product::find($request->product_id);
        if($product->vendor_id != Auth::user()->vendor->id){
            abort(404);
        }
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

        return redirect()->route('vendor.products-variant-items.showTable', [$request->product_id, $request->variant_id]);
    }

    public function edit(String $variant_item_id){
        $item = ProductVariantItem::findOrFail($variant_item_id);
        //Check if editor is product owner
        if($item->variant->product_id != Auth::user()->vendor->id){
            abort(404);
        }
        return view('vendor.product.product-variant-item.edit', compact('item'));
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
        //Check if editor is product owner
        if($item->variant->product_id != Auth::user()->vendor->id){
            abort(404);
        }
        $item->name = $request->name;
        $item->price = $request->price;
        $item->is_default = $request->is_default;
        $item->status = $request->status;
        $item->save();

        toastr()->success('Product Variant Item Updated Successfully!');

        return redirect()->route('vendor.products-variant-items.showTable', [$item->variant->product_id, $item->variant_id]);
    }

    public function destroy(String $id){

        $item = ProductVariantItem::findOrFail($id);
        //Check if editor is product owner
        if($item->variant->product_id != Auth::user()->vendor->id){
            abort(404);
        }
        $item->delete();

        return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
    }

    public function changeStatus(Request $request){
        $item = ProductVariantItem::findOrFail($request->id);
        //Check if editor is product owner
        if($item->variant->product_id != Auth::user()->vendor->id){
            abort(404);
        }
        $item->status = $request->status == 'true' ? 1 : 0;
        $item->save();

        return response(['message' => 'Status Has Been Changed']);
    }
}
