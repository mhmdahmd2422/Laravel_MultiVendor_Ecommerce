<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\CheckoutController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\FlashSaleController;
use App\Http\Controllers\Frontend\FrontendProductController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\UserAddressController;
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

//Cart routes
Route::post('add-to-cart', [CartController::class, 'addToCart'])
    ->name('add-to-cart');
Route::get('cart-details', [CartController::class, 'cartDetails'])
    ->name('cart-details');
Route::post('cart/update-quantity', [CartController::class, 'updateQuantity'])
    ->name('update-quantity');
Route::get('cart/clear', [CartController::class, 'clearCart'])
    ->name('clear-cart');
Route::post('cart/remove-item', [CartController::class, 'removeItem'])
    ->name('remove-item');
Route::get('cart-count', [CartController::class, 'getCartCount'])
    ->name('cart-count');
Route::get('cart-products', [CartController::class, 'getCartProducts'])
    ->name('cart-products');
Route::get('cart-products-total', [CartController::class, 'getCartTotal'])
    ->name('cart-products-total');
Route::post('apply-coupon', [CartController::class, 'ApplyCoupon'])
    ->name('apply-coupon');
Route::get('calculate-coupon', [CartController::class, 'calculateCouponDiscount'])
    ->name('calculate-coupon');
Route::get('remove-coupon', [CartController::class, 'removeCoupon'])
    ->name('remove-coupon');


Route::group(['middleware' => ['auth', 'verified'], 'prefix' => 'user', 'as' => 'user.'], function (){
    Route::get('/dashboard', [UserDashboardController::class, 'index'])
        ->name('dashboard');
    Route::get('/profile', [UserProfileController::class, 'profile'])
        ->name('profile');
    Route::put('profile/update', [UserProfileController::class, 'updateProfile'])
        ->name('profile.update');
    Route::post('profile/update/password', [UserProfileController::class, 'updatePassword'])
        ->name('password.update');
    //User multiple addresses
    Route::resource('address', UserAddressController::class);
    //Cart Checkout
    Route::get('checkout', [CheckoutController::class, 'index'])
        ->name('checkout');
    Route::get('apply-shipping', [CheckoutController::class, 'applyShipping'])
        ->name('apply-shipping');
});
