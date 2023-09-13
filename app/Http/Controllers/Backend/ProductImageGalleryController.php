<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ProductImageGalleryDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImageGallery;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;

class ProductImageGalleryController extends Controller
{
    use ImageUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function showTable(String $id, ProductImageGalleryDataTable $dataTable)
    {
        $product = Product::find($id);
        return $dataTable->with('productId', $id)
            ->render('admin.product.image-gallery.index', compact('product'));
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
        $request->validate([
           'image.*' => ['required', 'image', 'max:3000']
        ]);

        //handle multi image upload
        $imagePaths = $this->uploadMultiImage($request, 'image', 'uploads');

        foreach ($imagePaths as $imagePath){
            $productImageGallery = new ProductImageGallery();
            $productImageGallery->image = $imagePath;
            $productImageGallery->product_id = $request->product;
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
        $this->deleteImage($productImage->image);
        $productImage->delete();

        return response(['status' => 'success', 'message' => 'Product Image Has Been Deleted Successfully!']);
    }

}

