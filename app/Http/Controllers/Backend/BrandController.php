<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\BrandDataTable;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class BrandController extends Controller
{

    use ImageUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(BrandDataTable $dataTable)
    {
        return $dataTable->render('admin.brand.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'logo' => ['required', 'image', 'max:2048'],
            'name' => ['required','string', 'max:200', 'unique:vendors'],
            'is_featured' => ['required', 'boolean'],
            'status' => ['required', 'boolean'],
        ]);

        $brand = new Brand();
        $imagePath = $this->uploadImage($request, 'logo', 'uploads');
        $alert = 'New Brand Has Been Created!';
        $route = 'admin.brand.index';

        return $this->submitForm($request, $brand, $imagePath, $alert, $route);
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
        $brand = Brand::findOrFail($id);

        return view('admin.brand.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'logo' => ['image', 'max:2048'],
            'name' => ['required','string', 'max:200', 'unique:vendors,name'.$id],
            'is_featured' => ['required', 'boolean'],
            'status' => ['required', 'boolean'],
        ]);

        $brand = Brand::findOrFail($id);
        $imagePath = $this->updateImage($request, 'logo', 'uploads', $brand->logo);
        $alert = 'Brand Has Been Updated!';
        $route = 'admin.brand.index';

        return $this->submitForm($request, $brand, $imagePath, $alert, $route);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Brand::findOrFail($id);
        $products = Product::where('brand_id', $brand->id)->get();
        if($products->isNotEmpty()) {
            return response(['status' => 'error', 'message' => 'This Brand Has Registered Products! Delete All Brand Products to Delete Or Ban the Brand Instead.']);
        }
        $this->deleteImage($brand->logo);
        $brand->delete();

        return response(['status' => 'success', 'message' => 'Brand Has Been Deleted Successfully!']);
    }

    public function changeStatus(Request $request)
    {
        $brand = Brand::findOrFail($request->id);
        $brand = changeRelatedProductsAdminStatus($brand, 'brand_id', $request->status);
        $brand->status = $request->status == 'true' ? 1 : 0;
        $brand->save();

        return response(['message' => 'Status Has Been Changed']);
    }

    public function changeFeatured(Request $request)
    {
        $brand = Brand::findOrFail($request->id);
        $brand->is_featured = $request->is_featured == 'true' ? 1 : 0;
        $brand->save();

        return response(['message' => 'Featured Has Been Changed']);
    }


    public function submitForm(Request $request, $brand, $imagePath, $alert, $route): \Illuminate\Http\RedirectResponse
    {
        if($imagePath != null){$brand->logo = $imagePath;}
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);
        $brand->is_featured = $request->is_featured;
        $brand = changeRelatedProductsAdminStatus($brand, 'brand_id', $request->status);
        $brand->save();

        toastr()->success($alert);

        if($route != null) {
            return redirect()->route($route);
        }else{
            return redirect()->back();
        }
    }
}
