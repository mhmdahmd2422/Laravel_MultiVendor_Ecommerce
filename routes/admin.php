<?php

use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ChildCategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ProductImageGalleryController;
use App\Http\Controllers\Backend\ProductVariantController;
use App\Http\Controllers\Backend\ProductVariantItemController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\AdminVendorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AdminController;

//Admin Dashboard routes
Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
Route::get('profile', [ProfileController::class, 'profile'])->name('profile');
Route::post('profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
Route::post('profile/update/password', [ProfileController::class, 'updatePassword'])->name('password.update');


//Slider routes
Route::resource('slider', SliderController::class);

//category routes
Route::put('change-status', [CategoryController::class, 'changeStatus'])->name('category.change-status');
Route::resource('category', CategoryController::class);

//Sub-category routes
Route::put('sub-category/change-status', [SubCategoryController::class, 'changeStatus'])->name('sub-category.change-status');
Route::resource('sub-category', SubCategoryController::class);

//Child-category routes
Route::get('get-subcategories', [ChildCategoryController::class, 'getSubCategories'])->name('get-subcategories');
Route::put('child-category/change-status', [ChildCategoryController::class, 'changeStatus'])->name('child-category.change-status');
Route::resource('child-category', ChildCategoryController::class);

//Brand routes
Route::put('brand/change-status', [BrandController::class, 'changeStatus'])->name('brand.change-status');
Route::put('brand/change-featured', [BrandController::class, 'changeFeatured'])->name('brand.change-featured');
Route::resource('brand', BrandController::class);

//Admin vendor routes
Route::put('vendor/change-status', [AdminVendorController::class, 'changeStatus'])->name('vendor.change-status');
Route::resource('vendor', AdminVendorController::class);

//Admin products routes
Route::get('get-childcategories', [ProductController::class, 'getChildCategories'])->name('get-childcategories');
Route::put('product/change-status', [ProductController::class, 'changeStatus'])->name('product.change-status');
Route::resource('product', ProductController::class);
//TODO: create dedicated subcategory fetch route

//products image gallery routes
Route::get('products-image-gallery/{id}', [ProductImageGalleryController::class, 'showTable'])
    ->name('products-image-gallery.showTable');
Route::resource('products-image-gallery', ProductImageGalleryController::class);

//product variants routes
Route::get('product-variant/{id}', [ProductVariantController::class, 'showTable'])
    ->name('products-variant.showTable');
Route::put('product-variant/change-status', [ProductVariantController::class, 'changeStatus'])->name('product-variant.change-status');
Route::resource('products-variant', ProductVariantController::class);

//product variant items routes
Route::get('product-variant-items/{product_id}/{variant_id}', [ProductVariantItemController::class, 'showTable'])
    ->name('products-variant-items.showTable');
Route::put('product-variant-items/change-status', [ProductVariantItemController::class, 'changeStatus'])->name('product-variant-items.change-status');
Route::get('product-variant-items/create/{product_id}/{variant_id}', [ProductVariantItemController::class, 'create'])
    ->name('product-variant-items.create');
Route::post('product-variant-items', [ProductVariantItemController::class, 'store'])
    ->name('product-variant-items.store');
Route::get('product-variant-items-edit/{variant_item_id}', [ProductVariantItemController::class, 'edit'])
    ->name('product-variant-items.edit');
Route::put('product-variant-items-update/{variant_item_id}', [ProductVariantItemController::class, 'update'])
    ->name('product-variant-items.update');
Route::delete('product-variant-items-delete/{variant_item_id}', [ProductVariantItemController::class, 'destroy'])
    ->name('product-variant-items.destroy');


