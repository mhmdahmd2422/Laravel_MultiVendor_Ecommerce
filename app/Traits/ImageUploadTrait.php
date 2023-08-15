<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

trait ImageUploadTrait{
    public function uploadImage(Request $request, $inputName, $path){
        if($request->hasFile($inputName)){
//            if(File::exists(public_path($user->image))){
//                File::delete(public_path($user->image));
//            }
            $image = $request->{$inputName};
            $extension = $image->getClientOriginalExtension();
            $imageName = 'media_'.uniqid().'.'.$extension;
            $image->move(public_path($path), $imageName);
            return $path.'/'.$imageName;
        }
    }

    public function updateImage(Request $request, $inputName, $path, $oldpath){
        if($request->hasFile($inputName)){
            if(File::exists(public_path($oldpath))){
                File::delete(public_path($oldpath));
            }
            $image = $request->{$inputName};
            $extension = $image->getClientOriginalExtension();
            $imageName = 'media_'.uniqid().'.'.$extension;
            $image->move(public_path($path), $imageName);
            return $path.'/'.$imageName;
        }
    }

    public function deleteImage(?string $path){
        if(File::exists(public_path($path))){
        File::delete(public_path($path));
        }
    }
}
