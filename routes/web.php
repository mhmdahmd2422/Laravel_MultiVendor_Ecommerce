<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Frontend\FlashSaleController;
use App\Http\Controllers\Frontend\FrontendProductController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\UserDashboardController;
use App\Http\Controllers\Frontend\UserProfileController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('admin/login', [AdminController::class, 'login'])
    ->name('admin.login');
Route::get('flash-sale/all', [FlashSaleController::class, 'ShowAllFlashItems'])
    ->name('flash-sale.details');

//product detail routes
Route::get('product-detail/{slug}', [FrontendProductController::class, 'index'])
    ->name('product-detail.index');


Route::group(['middleware' => ['auth', 'verified'], 'prefix' => 'user', 'as' => 'user.'], function (){
    Route::get('/dashboard', [UserDashboardController::class, 'index'])
        ->name('dashboard');
    Route::get('/profile', [UserProfileController::class, 'profile'])
        ->name('profile');
    Route::put('profile/update', [UserProfileController::class, 'updateProfile'])
        ->name('profile.update');
    Route::post('profile/update/password', [UserProfileController::class, 'updatePassword'])
        ->name('password.update');
});
