<?php

use App\Http\Controllers\Backend\VendorController;
use App\Http\Controllers\Backend\VendorProductController;
use App\Http\Controllers\Backend\VendorProductImageGalleryController;
use App\Http\Controllers\Backend\VendorProductVariantController;
use App\Http\Controllers\Backend\VendorProductVariantItemController;
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

//vendor products image gallery routes
Route::get('products-image-gallery/{id}', [VendorProductImageGalleryController::class, 'showTable'])
    ->name('products-image-gallery.showTable');
Route::resource('products-image-gallery', VendorProductImageGalleryController::class);

//Vendor product variants routes
Route::get('product-variant/{id}', [VendorProductVariantController::class, 'showTable'])
    ->name('products-variant.showTable');
Route::put('product-variant/change-status', [VendorProductVariantController::class, 'changeStatus'])->name('product-variant.change-status');
Route::resource('products-variant', VendorProductVariantController::class);

//product variant items routes
Route::get('product-variant-items/{product_id}/{variant_id}', [VendorProductVariantItemController::class, 'showTable'])
    ->name('products-variant-items.showTable');
Route::put('product-variant-items/change-status', [VendorProductVariantItemController::class, 'changeStatus'])
    ->name('product-variant-items.change-status');
Route::get('product-variant-items/create/{product_id}/{variant_id}', [VendorProductVariantItemController::class, 'create'])
    ->name('product-variant-items.create');
Route::post('product-variant-items', [VendorProductVariantItemController::class, 'store'])
    ->name('product-variant-items.store');
Route::get('product-variant-items-edit/{variant_item_id}', [VendorProductVariantItemController::class, 'edit'])
    ->name('product-variant-items.edit');
Route::put('product-variant-items-update/{variant_item_id}', [VendorProductVariantItemController::class, 'update'])
    ->name('product-variant-items.update');
Route::delete('product-variant-items-delete/{variant_item_id}', [VendorProductVariantItemController::class, 'destroy'])
    ->name('product-variant-items.destroy');

