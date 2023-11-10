<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserVendorRequestController extends Controller
{
    use ImageUploadTrait;

    public function index()
    {
        return view('frontend.dashboard.vendor-request.index');
    }

    public function create(Request $request)
    {
        if(Auth::user()->role === 'vendor'){
            return redirect()->back();
        }

        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'unique:vendors,email'],
            'phone' => ['required', 'phone', 'unique:vendors,phone'],
            'banner' => ['required', 'image', 'max:2040'],
            'address' => ['required', 'string', 'max:150'],
            'description' => ['required', 'string', 'max:500'],
            'fb_link' => ['nullable'],
            'tw_link' => ['nullable'],
            'insta_link' => ['nullable'],
        ]);

        $imagePath = $this->uploadImage($request, 'banner', 'uploads');

        $vendor = new Vendor();
        $vendor->name = $request->name;
        $vendor->email = $request->email;
        $vendor->phone = $request->phone;
        $vendor->banner = $imagePath;
        $vendor->address = $request->address;
        $vendor->description = $request->description;
        $vendor->fb_link = $request->fb_link;
        $vendor->tw_link = $request->tw_link;
        $vendor->insta_link = $request->insta_link;
        $vendor->user_id = Auth::id();
        $vendor->status = 0;
        $vendor->save();

        toastr('Your Request has been submitted! Please Wait for Approval.', 'success', 'success');
        flash('Your Request has been submitted! Please Wait for Approval.', 'success');

        return redirect()->back();
    }
}
