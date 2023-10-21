<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Helper\Helper;

class UserAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $addresses = Auth::user()->addresses;

        return view('frontend.dashboard.address.index', compact('addresses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('frontend.dashboard.address.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $address = new UserAddress();

        $alert = 'Address Has Been Added To Your Account';
        //if request from checkout page
        if($request->has('route')){
            $route = $request->route;
        }else{
            $route = 'user.address.index';
        }

        return $this->submitForm($request, $address, $alert, $route);
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
        $address = UserAddress::findOrFail($id);

        return view('frontend.dashboard.address.edit', compact('address'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $address = UserAddress::findOrFail($id);

        $alert = 'Address Has Been Updated';
        $route = 'user.address.index';

        return $this->submitForm($request, $address, $alert, $route);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $address = UserAddress::findOrFail($id);
        $address->delete();

        return response(['status' => 'success', 'message'=>'Address Is Successfully Deleted']);
    }

    public function submitForm(Request $request, UserAddress $address, String $alert, String $route): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name' => ['nullable', 'string', 'max:100'],
            'phone' => ['required', 'phone'],
            'country' => ['required', 'string', 'max:70'],
            'city' => ['required', 'string', 'max:100'],
            'zip_code' => ['nullable', 'integer'],
            'type' => ['required', 'string', 'max:6'],
            'address' => ['required', 'string', 'max:200'],
            'comment' => ['nullable', 'string', 'max:100'],
        ]);
        $user = Auth::user();
        $address->user_id = $user->id;
        if(empty($request->name)){
            $address->name = 'Address '.$user->addresses()->count() +1;
        }else{
            $address->name = $request->name;
        }
        $address->phone = $request->phone;
        $address->country = $request->country;
        $address->city = $request->city;
        $address->zip_code = $request->zip_code;
        $address->address_type = $request->type;
        $address->address = $request->address;
        $address->comment = $request->comment;
        $address->save();

        flash()->addSuccess($alert);

        if($route != null) {
            return redirect()->route($route);
        }else{
            return redirect()->back();
        }
    }

}
