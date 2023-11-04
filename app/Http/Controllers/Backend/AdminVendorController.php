<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\VendorDataTable;
use App\Http\Controllers\Controller;
use App\Models\Vendor;
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
            'phone' => ['required', 'numeric'],
            'email' => ['Email', 'max:200'],
            'address' => ['required','string', 'max:200'],
            'description' => ['required','string', 'max:1000'],
            'fb_link' => ['url'],
            'tw_link' => ['url'],
            'insta_link' => ['url'],
            'status' => ['required', 'boolean'],
        ]);

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
        //
    }

    public function changeStatus(Request $request){
        $vendor = Vendor::findOrFail($request->id);
        $vendor->status = $request->status == 'true' ? 1 : 0;
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
        $vendor->save();

        toastr()->success($alert);

        if($route != null) {
            return redirect()->route($route);
        }else{
            return redirect()->back();
        }
    }
}
