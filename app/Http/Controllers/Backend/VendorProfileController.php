<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class VendorProfileController extends Controller
{
    public function profile(){
        return view('frontend.dashboard.profile');
    }

    public function updateProfile(Request $request){
        $request->validate([
            'name' => ['required', 'max:100'],
            'username' => ['required', 'unique:App\Models\User,username,'.Auth::user()->id],
            'email' => ['required', 'email', 'unique:App\Models\User,email,'.Auth::user()->id],
            'phone' => ['nullable', 'numeric', 'max:20', 'unique:App\Models\User,phone,'.Auth::user()->id],
            'image' => ['image', 'max:2040']
        ]);

        $user = Auth::user();

        if($request->hasFile('image')){
            if(File::exists(public_path($user->image))){
                File::delete(public_path($user->image));
            }
            $image = $request->image;
            $imageName = rand().'_'.$image->getClientOriginalName();
            $image->move(public_path('uploads'), $imageName);
            $imagePath = '/uploads/'.$imageName;
            $user->image = $imagePath;
        }
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->save();

        toastr()->success('You Had Changed Your Profile Info!');
        return redirect()->back();
    }

    public function updatePassword(Request $request){
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $request->user()->update([
            'password' => bcrypt($request->password)
        ]);

        toastr()->success('You Had Changed Your Password!');
        return redirect()->back();
    }
}
