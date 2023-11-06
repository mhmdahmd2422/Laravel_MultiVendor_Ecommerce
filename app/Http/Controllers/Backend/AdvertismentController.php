<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Advertisment;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;

class AdvertismentController extends Controller
{
    use ImageUploadTrait;

    public function index()
    {
        $banner_one = Advertisment::where('key', 'homepage_banner_one')->first();
        $banner_one = json_decode($banner_one?->value);
        $banner_two = Advertisment::where('key', 'homepage_banner_two')->first();
        $banner_two = json_decode($banner_two?->value);
        $banner_three = Advertisment::where('key', 'homepage_banner_three')->first();
        $banner_three = json_decode($banner_three?->value);
        $banner_four = Advertisment::where('key', 'homepage_banner_four')->first();
        $banner_four = json_decode($banner_four?->value);
        $banner_five = Advertisment::where('key', 'homepage_banner_five')->first();
        $banner_five = json_decode($banner_five?->value);
        $banner_six = Advertisment::where('key', 'homepage_banner_six')->first();
        $banner_six = json_decode($banner_six?->value);
        $banner_seven = Advertisment::where('key', 'homepage_banner_seven')->first();
        $banner_seven = json_decode($banner_seven?->value);
        $products_banner_one = Advertisment::where('key', 'products_banner_one')->first();
        $products_banner_one = json_decode($products_banner_one?->value);
        $cart_banner_one = Advertisment::where('key', 'cart_banner_one')->first();
        $cart_banner_one = json_decode($cart_banner_one?->value);
        $cart_banner_two = Advertisment::where('key', 'cart_banner_two')->first();
        $cart_banner_two = json_decode($cart_banner_two?->value);
        return view('admin.advertisement.index',
            compact(
                'banner_one',
                'banner_two',
                'banner_three',
                'banner_four',
                'banner_five',
                'banner_six',
                'banner_seven',
                'products_banner_one',
                'cart_banner_one',
                'cart_banner_two'
            )
        );
    }

    public function addBanner(Request $request)
    {
        $request->validate([
           'banner' => ['required'],
           'banner_image' => ['image'],
           'banner_url' => ['required', 'url'],
        ]);

        //handle upload
        $imagePath = $this->updateImage($request, 'banner_image', 'uploads', '');

        $value = [
            'banner_url' => $request->banner_url,
            'status' => $request->status == 'on'? 1: 0,
        ];
        if(!empty($imagePath)){
            $value['banner_image'] = $imagePath;
        }else{
            $value['banner_image'] = $request->banner_old_image;
        }
        $value = json_encode($value);

        Advertisment::updateOrCreate(
            ['key' => $request->banner],
            ['value' => $value],
        );

        toastr('Updated Banner Successfully', 'success', 'success');
        flash('Updated Banner Successfully', 'success');

        return redirect()->back();
    }
}
