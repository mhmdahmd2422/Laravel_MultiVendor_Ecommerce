<?php

use App\Http\Controllers\Backend\VendorController;
use App\Http\Controllers\Backend\VendorProductController;
use App\Http\Controllers\Backend\VendorProfileController;
use App\Http\Controllers\Backend\VendorShopProfileController;
use Illuminate\Support\Facades\Route;


//Vendor routes
Route::get('/dashboard', [VendorController::class, 'dashboard'])->name('dashboard');
Route::get('/profile', [VendorProfileController::class, 'profile'])->name('profile');
Route::put('profile/update', [VendorProfileController::class, 'updateProfile'])->name('profile.update');
Route::post('profile/update/password', [VendorProfileController::class, 'updatePassword'])->name('password.update');

//Vendor Shop Profile Routes
Route::resource('shop-profile' , VendorShopProfileController::class);

//Vendor Products routes
Route::resource('products', VendorProductController::class);
Route::get('get-subcategories', [VendorProductController::class, 'getSubCategories'])->name('get-subcategories');
Route::get('get-childcategories', [VendorProductController::class, 'getChildCategories'])->name('get-childcategories');
Route::put('product/change-status', [VendorProductController::class, 'changeStatus'])->name('product.change-status');

