<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\VendorDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Wishlist;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;

class AdminVendorController extends Controller
{
    use ImageUploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(VendorDataTable $dataTable)
    {
        return $dataTable->render('admin.vendor.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.vendor.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'banner' => ['required', 'image', 'max:2048'],
            'name' => ['required','string', 'max:200'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'phone' => ['required', 'numeric'],
            'email' => ['Email', 'max:200', 'unique:vendors,email'],
            'address' => ['required','string', 'max:200'],
            'description' => ['required','string', 'max:1000'],
            'fb_link' => ['url'],
            'tw_link' => ['url'],
            'insta_link' => ['url'],
            'status' => ['required', 'boolean'],
        ]);
        $user = User::findOrFail($request->user_id);
        $vendor = Vendor::where('user_id', $user->id)->get();
        if($vendor->isNotEmpty){
            toastr('This user has an existing vendor profile!', 'error', 'error');
            return redirect()->back();
        }
        if($user->role != 'admin'){
            $user->role = 'vendor';
        }
        $user->save();
        $vendor = new Vendor();
        $imagePath = $this->uploadImage($request, 'banner', 'uploads');
        $alert = 'New Vendor Has Been Created!';
        $route = 'admin.vendor.index';

        $vendor->user_id = $request->user()->id;

        return $this->submitForm($request, $vendor, $imagePath, $alert, $route);
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
        $vendor = Vendor::findOrFail($id);

        return view('admin.vendor.edit', compact('vendor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'banner' => ['nullable', 'image', 'max:2048'],
            'name' => ['required','string', 'max:200'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'phone' => ['required', 'numeric'],
            'email' => ['Email', 'max:200'],
            'address' => ['required','string', 'max:200'],
            'description' => ['required','string', 'max:1000'],
            'fb_link' => ['url'],
            'tw_link' => ['url'],
            'insta_link' => ['url'],
            'status' => ['required', 'boolean'],
        ]);

        $vendor = Vendor::findOrFail($id);
        $imagePath = $this->updateImage($request, 'banner', 'uploads', $vendor->banner);
        $alert = 'Vendor Has Been Updated!';
        $route = 'admin.vendor.index';

        return $this->submitForm($request, $vendor, $imagePath, $alert, $route);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $vendor = Vendor::findOrFail($id);
        $products = Product::where('vendor_id', $vendor->id)->get();
        $orders = Order::where('user_id', $vendor->user->id)->where('order_status', '!=', 'delivered')->get();
        if($products->isNotEmpty()){
            return response(['status' => 'error', 'message' => 'This Vendor Has Registered Products! Delete All Vendor Products to Delete Or Ban the Vendor Instead.']);
        }else if($orders->isNotEmpty()){
            return response(['status' => 'error', 'message' => 'This User Has Incomplete Orders! Delete All User Orders to Delete.']);
        }else {
            $user = User::findOrFail($vendor->user->id);
            if($user->role != 'admin'){
                $user->role = 'user';
                $user->save();
            }
            $vendor->delete();
            return response(['status' => 'success', 'message' => 'Vendor Is Deleted!']);
        }
    }

    public function changeStatus(Request $request){
        $vendor = Vendor::findOrFail($request->id);
        $vendor = $vendor = changeRelatedProductsAdminStatus($vendor, 'vendor_id', $request->status);
        $vendor->save();

        return response(['message' => 'Status Has Been Changed']);
    }

    public function submitForm(Request $request, $vendor, $imagePath, $alert, $route): \Illuminate\Http\RedirectResponse
    {
        if($imagePath != null){$vendor->banner = $imagePath;}
        $vendor->name = $request->name;
        $vendor->user_id = $request->user_id;
        $vendor->phone = $request->phone;
        $vendor->email = $request->email;
        $vendor->address = $request->address;
        $vendor->description = $request->description;
        $vendor->fb_link = $request->fb_link;
        $vendor->tw_link = $request->tw_link;
        $vendor->insta_link = $request->insta_link;
        $vendor->status = $request->status;
        $vendor->is_approved = 1;
        $vendor = changeRelatedProductsAdminStatus($vendor, 'vendor_id', $request->status);
        $vendor->save();

        toastr()->success($alert);

        if($route != null) {
            return redirect()->route($route);
        }else{
            return redirect()->back();
        }
    }
}
