<?php

use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ChildCategoryController;
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

