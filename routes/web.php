<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\BlogCategoryController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\NewsletterController;
use App\Http\Controllers\Frontend\OrderTrackController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\FlashSaleController;
use App\Http\Controllers\Frontend\FrontendProductController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ReviewController;
use App\Http\Controllers\Frontend\UserAddressController;
use App\Http\Controllers\Frontend\UserDashboardController;
use App\Http\Controllers\Frontend\UserOrderController;
use App\Http\Controllers\Frontend\UserProductReviewController;
use App\Http\Controllers\Frontend\UserProfileController;
use App\Http\Controllers\Frontend\UserVendorRequestController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('wishlist/add', [WishlistController::class, 'addToWishlist'])
    ->name('wishlist.store');
Route::get('flash-sale/all', [FlashSaleController::class, 'ShowAllFlashItems'])
    ->name('flash-sale.details');
Route::get('about-us', [PageController::class, 'about'])
    ->name('about.index');
Route::get('terms-and-conditions', [PageController::class, 'termsAndConditions'])
    ->name('terms-and-conditions.index');
Route::get('contact-us', [PageController::class, 'contact'])
    ->name('contact.index');
Route::post('contact-form', [PageController::class, 'handleContactForm'])
    ->name('contact.send');

//products routes
Route::get('product-detail/{slug}', [FrontendProductController::class, 'index'])
    ->name('product-detail.index');
Route::get('change-product-info-view', [FrontendProductController::class, 'changeProductInfoView'])
    ->name('change-product-info-view');
Route::get('products', [FrontendProductController::class, 'productsIndex'])
    ->name('products.index');
Route::get('change-product-view', [FrontendProductController::class, 'changeListView'])
    ->name('change-product-view');

//vendors routes
Route::get('vendors', [HomeController::class, 'vendorsPage'])
    ->name('vendors.index');

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

//order Tracking
Route::get('order-track', [OrderTrackController::class, 'index'])
    ->name('order-track');
Route::post('order-track/order', [OrderTrackController::class, 'track'])
    ->name('order-track.track');

//newsletter route
Route::post('newsletter-request', [NewsletterController::class, 'newsletterRequest'])
    ->name('newsletter.request');
Route::get('newsletter-verify/{token}', [NewsletterController::class, 'newsletterEmailVerification'])
    ->name('newsletter.verification');

//blog routes
Route::get('blog-details/{slug}', [BlogController::class, 'index'])
    ->name('blog.index');
Route::get('blog', [BlogController::class, 'blog'])
    ->name('blog');

Route::group(['middleware' => ['auth', 'verified'], 'prefix' => 'user', 'as' => 'user.'], function (){
    Route::get('/dashboard', [UserDashboardController::class, 'index'])
        ->name('dashboard');
    Route::get('/profile', [UserProfileController::class, 'profile'])
        ->name('profile');
    Route::put('profile/update', [UserProfileController::class, 'updateProfile'])
        ->name('profile.update');
    Route::post('profile/update/password', [UserProfileController::class, 'updatePassword'])
        ->name('password.update');
    //wishlist
    Route::get('wishlist', [WishlistController::class, 'index'])
        ->name('wishlist.index');
    Route::post('wishlist/remove', [WishlistController::class, 'removeFromWishlist'])
        ->name('wishlist.destroy');
    Route::post('wishlist/add-to-cart', [WishlistController::class, 'addToCartFromWishlist'])
        ->name('wishlist.add-to-cart');
    //product review routes
    Route::post('review', [ReviewController::class, 'createReview'])
        ->name('review.create');
    Route::get('my-reviews', [UserProductReviewController::class, 'index'])
        ->name('review.index');
    Route::delete('my-reviews/delete/{id}', [UserProductReviewController::class, 'destroy'])
        ->name('review.destroy');
    Route::post('my-reviews/edit/{id}', [UserProductReviewController::class, 'update'])
        ->name('review.update');
    //blog comment
    Route::post('blog-comment', [BlogController::class, 'comment'])
        ->name('blog.comment');
    //vendor request routes
    Route::get('vendor-request', [UserVendorRequestController::class, 'index'])
        ->name('vendor-request.index');
    Route::post('vendor-request/create', [UserVendorRequestController::class, 'create'])
        ->name('vendor-request.create');
    //User multiple addresses
    Route::resource('address', UserAddressController::class);
    //order routes
    Route::get('orders', [UserOrderController::class, 'index'])
        ->name('orders');
    Route::get('orders/show/{id}', [UserOrderController::class, 'show'])
        ->name('orders.show');
    //Cart Checkout
    Route::get('checkout', [CheckoutController::class, 'index'])
        ->name('checkout');
    Route::post('apply-shipping', [CheckoutController::class, 'applyShipping'])
        ->name('apply-shipping');
    Route::post('checkout-submit', [CheckoutController::class, 'checkoutSubmit'])
        ->name('checkout-submit');
    //payments
    Route::get('payment', [PaymentController::class, 'index'])
        ->name('payment');
    Route::get('payment-success', [PaymentController::class, 'paymentSuccess'])
        ->name('payment.success');
    //paypal
    Route::get('paypal/payment', [PaymentController::class, 'payWithPaypal'])
        ->name('paypal.payment');
    Route::get('paypal/success', [PaymentController::class, 'paypalSuccess'])
        ->name('paypal.success');
    Route::get('paypal/cancel', [PaymentController::class, 'paypalCancel'])
        ->name('paypal.cancel');
    //stripe
    Route::post('stripe/payment', [PaymentController::class, 'payWithStripe'])
        ->name('stripe.payment');
    //cod
    Route::get('cod/payment', [PaymentController::class, 'payWithCod'])
        ->name('cod.payment');
});
