<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\VendorProductDataTable;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ProductImageGallery;
use App\Models\ProductVariant;
use App\Models\SubCategory;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class VendorProductController extends Controller
{
    use ImageUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(VendorProductDataTable $dataTable)
    {
        return $dataTable->render('vendor.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('status' , 1)->get();
        $brands = Brand::where('status' , 1)->get();
        return view('vendor.product.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'thumb_image' => ['required', 'image', 'max:2048'],
            'name' => ['required', 'string', 'max:200'],
            'category_id' => ['required', 'integer'],
            'sub_category_id' => ['nullable'],
            'child_category_id' => ['nullable'],
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
            'status' => ['required', 'boolean'],
            'seo_title' => ['nullable', 'string', 'max:200'],
            'seo_description' => ['nullable', 'string', 'max:1000'],
        ]);

        $product = new Product();
        $imagePath = $this->uploadImage($request, 'thumb_image', 'uploads');
        $product->is_approved = 0;
        $product->vendor_id = Auth::user()->vendor->id;
        $alert = 'New Product Has Been Created!';
        $route = 'vendor.products.index';

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
        $product = Product::findOrFail($id);
        //Check if editor is product owner
        if($product->vendor_id != Auth::user()->vendor->id){
            abort(404);
        }
        $categories = Category::all();
        $sub_categories = SubCategory::where('category_id', $product->category_id)->get();
        $child_categories = ChildCategory::where('sub_category_id', $product->sub_category_id)->get();
        $brands = Brand::all();

        return view('vendor.product.edit', compact('product', 'categories', 'sub_categories', 'child_categories', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'thumb_image' => ['nullable', 'image', 'max:2048'],
            'name' => ['required', 'string', 'max:200'],
            'category_id' => ['required', 'integer'],
            'sub_category_id' => ['nullable'],
            'child_category_id' => ['nullable'],
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
            'status' => ['required', 'boolean'],
            'seo_title' => ['nullable', 'string', 'max:200'],
            'seo_description' => ['nullable', 'string', 'max:1000'],
        ]);

        $product = Product::findOrFail($id);
        //Check if editor is product owner
        if($product->vendor_id != Auth::user()->vendor->id){
            abort(404);
        }
        $imagePath = $this->updateImage($request, 'thumb_image', 'uploads', $product->thumb_image);
        $product->is_approved = 0;
        $alert = 'Product Has Been Updated!';
        $route = 'vendor.products.index';

        return $this->submitForm($request, $product, $imagePath, $alert, $route);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        //Check if editor is product owner
        if($product->vendor_id != Auth::user()->vendor->id){
            abort(404);
        }else{
            $orders = OrderProduct::where('product_id', $product->id)
                ->whereHas('order', function ($order){
                    $order->where('order_status', '!=', 'delivered')->orWhere('order_status', '!=', 'canceled');
                })->get();
            if($orders->isNotEmpty()){
                return response(['status' => 'error', 'message' => 'This Product Have Processing Orders! Deactivate The Product And Complete Its Orders To Delete.']);
            }else{
                $galleries = ProductImageGallery::where('product_id', $product->id)->get();
                $variants = ProductVariant::where('product_id', $product->id)->get();
                foreach ($galleries as $gallery){
                    $this->deleteImage($gallery->image);
                    $gallery->delete();
                }
                foreach ($variants as $variant) {
                    $variant->variantItems()->delete();
                    $variant->delete();
                }
                $this->deleteImage($product->thumb_image);
                $product->delete();

                return response(['status' => 'success', 'message' => 'Product Deleted Successfully!']);
            }
        }

    }

    public function getSubCategories(Request $request){
        $subCategories = SubCategory::where('category_id', $request->id)->where('status', 1)->get();

        return $subCategories;
    }

    public function getChildCategories(Request $request){
        $childCategories = ChildCategory::where('sub_category_id', $request->id)->where('status', 1)->get();

        return $childCategories;
    }
    public function changeStatus(Request $request){
        $product = Product::findOrFail($request->id);
        $product->status = $request->status == 'true' ? 1 : 0;
        $product->save();

        return response(['message' => 'Status Has Been Changed']);
    }

    public function submitForm(Request $request, $product, $imagePath, $alert, $route): \Illuminate\Http\RedirectResponse
    {
        if($imagePath != null){$product->thumb_image = $imagePath;}
        $product->name = $request->name;
        $product->slug = Str::slug($request->name).'#'.$request->sku;
        $product->category_id = $request->category_id;
        if($request->sub_category_id == null){
            $product->sub_category_id = 0;
        }else{
            $product->sub_category_id = $request->sub_category_id;
        }
        if($request->child_category_id == null){
            $product->child_category_id = 0;
        }else{
            $product->child_category_id = $request->child_category_id;
        }
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
        $product->list_type = $request->list_type;
        $product->status = $request->status;
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
