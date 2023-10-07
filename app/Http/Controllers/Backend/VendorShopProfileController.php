<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorShopProfileController extends Controller
{

    use ImageUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vendor = Vendor::where('user_id', Auth::user()->id)->first();
        return view('vendor.shop-profile.index', compact('vendor'));
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
        'banner' => ['nullable', 'image', 'max:2048'],
        'name' => ['required','string', 'max:200'],
        'phone' => ['required', 'max:50'],
        'email' => ['Email', 'max:200'],
        'address' => ['required','string', 'max:200'],
        'description' => ['required','string', 'max:1000'],
        'fb_link' => ['url'],
        'tw_link' => ['url'],
        'insta_link' => ['url'],
        'status' => ['required', 'boolean'],
        ]);

        $vendor = Vendor::where('user_id', Auth::user()->id)->first();
        $imagePath = $this->updateImage($request, 'banner', 'uploads', $vendor->banner);
        $alert = 'Shop Profile Has Been Updated!';
        $route = null;

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

    public function submitForm(Request $request, $vendor, $imagePath, $alert, $route): \Illuminate\Http\RedirectResponse
    {
        if($imagePath != null){$vendor->banner = $imagePath;}
        $vendor->name = $request->name;
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
