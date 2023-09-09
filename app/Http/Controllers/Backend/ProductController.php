<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ProductDataTable;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\Product;
use App\Models\Vendor;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    use imageUploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(ProductDataTable $dataTable)
    {
        return $dataTable->render('admin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        $vendors = Vendor::all();

        return view('admin.product.create', compact('categories', 'brands', 'vendors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'thumb_image' => ['required', 'image', 'max:2048'],
            'name' => ['required', 'string', 'max:200'],
            'vendor_id' => ['required', 'integer'],
            'category_id' => ['required', 'integer'],
            'sub_category_id' => ['required', 'integer'],
            'child_category_id' => ['required', 'integer'],
            'brand_id' => ['required', 'integer'],
            'quantity' => ['required', 'integer'],
            'short_description' => ['required', 'string', 'max:1000'],
            'long_description' => ['required', 'string', 'max:2000'],
            'video_link' => ['nullable', 'url'],
            'sku' => ['required', 'string', 'max:200'],
            'price' => ['required', 'decimal:0,2'],
            'offer_price' => ['nullable', 'decimal:0,2'],
            'offer_start_date' => ['nullable', 'date'],
            'offer_end_date' => ['nullable', 'date'],
            'is_top' => ['nullable', 'boolean'],
            'is_best' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
            'status' => ['required', 'boolean'],
            'seo_title' => ['nullable', 'string', 'max:200'],
            'seo_description' => ['nullable', 'string', 'max:1000'],
        ]);

        $product = new Product();
        $imagePath = $this->uploadImage($request, 'thumb_image', 'uploads');
        $alert = 'New Product Has Been Created!';
        $route = 'admin.product.index';

        return $this->submitForm($request, $product, $imagePath, $alert, $route);
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
        //
    }

    public function getChildCategories(Request $request){
        $childCategories = ChildCategory::where('sub_category_id', $request->id)->where('status', 1)->get();

        return $childCategories;
    }

    public function submitForm(Request $request, $product, $imagePath, $alert, $route): \Illuminate\Http\RedirectResponse
    {
        if($imagePath != null){$product->thumb_image = $imagePath;}
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->vendor_id = $request->vendor_id;
        $product->category_id = $request->category_id;
        $product->sub_category_id = $request->sub_category_id;
        $product->child_category_id = $request->child_category_id;
        $product->brand_id = $request->brand_id;
        $product->quantity = $request->quantity;
        $product->short_description = $request->short_description;
        $product->long_description = $request->long_description;
        $product->video_link = $request->video_link;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->offer_price = $request->offer_price;
        $product->offer_start_date = $request->offer_start_date;
        $product->offer_end_date = $request->offer_end_date;
        $product->is_top = $request->is_top;
        $product->is_best = $request->is_best;
        $product->is_featured = $request->is_featured;
        $product->status = $request->status;
        $product->is_approved = $request->is_approved;
        $product->seo_title = $request->seo_title;
        $product->seo_description = $request->seo_description;
        $product->save();

        toastr()->success($alert);

        if($route != null) {
            return redirect()->route($route);
        }else{
            return redirect()->back();
        }
    }
}
