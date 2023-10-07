<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\VendorProductImageGalleryDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImageGallery;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorProductImageGalleryController extends Controller
{

    use ImageUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function showTable(String $id, VendorProductImageGalleryDataTable $dataTable)
    {
        $product = Product::find($id);
        //Check if editor is product owner
        if(Auth::user()->vendor->id != $product->vendor_id){
            abort(404);
        }
        return $dataTable->with('productId', $id)
            ->render('vendor.product.image-gallery.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
            'image' => 'required',
            'image.*' => ['image', 'max:3000']
        ]);

        //handle multi image upload
        $imagePaths = $this->uploadMultiImage($request, 'image', 'uploads');

        foreach ($imagePaths as $imagePath){
            $productImageGallery = new ProductImageGallery();
            $productImageGallery->image = $imagePath;
            $productImageGallery->product_id = $request->product_id;
            $productImageGallery->save();
        }
        toastr()->success('Product Image Uploaded Successfully!');

        return redirect()->back();
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
        $productImage = ProductImageGallery::findOrFail($id);
        //Check if editor is product owner
        if(Auth::user()->vendor->id != $productImage->product->vendor_id){
            abort(404);
        }
        $this->deleteImage($productImage->image);
        $productImage->delete();

        return response(['status' => 'success', 'message' => 'Product Image Has Been Deleted Successfully!']);
    }
}
