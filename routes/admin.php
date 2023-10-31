<?php

use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ChildCategoryController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\FlashSaleController;
use App\Http\Controllers\Backend\HomepageSettingsController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\PaymentSettingsController;
use App\Http\Controllers\Backend\PaypalSettingsController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ProductImageGalleryController;
use App\Http\Controllers\Backend\ProductVariantController;
use App\Http\Controllers\Backend\ProductVariantItemController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\SellerProductController;
use App\Http\Controllers\Backend\SettingsController;
use App\Http\Controllers\Backend\ShippingRuleController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\StripeSettingsController;
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

//Seller products routes
Route::get('seller-products', [SellerProductController::class, 'index'])
    ->name('seller-products.index');
Route::get('seller-pending-products', [SellerProductController::class, 'pendingProducts'])
    ->name('seller-products.pending');
Route::put('seller-pending-products/{product_id}', [SellerProductController::class, 'approveProduct'])
    ->name('seller-products.approve');

//Flash Sale Routes
Route::get('flash-sale', [FlashSaleController::class, 'index'])
    ->name('flash-sale.index');
Route::put('flash-sale', [FlashSaleController::class, 'update'])
    ->name('flash-sale.update');
Route::post('flash-sale', [FlashSaleController::class, 'AddToSale'])
    ->name('flash-sale.add');
Route::delete('flash-sale/{id}', [FlashSaleController::class, 'destroy'])
    ->name('flash-sale.destroy');
Route::put('flash-sale/change-status', [FlashSaleController::class, 'changeStatus'])
    ->name('flash-sale.change-status');
Route::put('flash-sale/change-show', [FlashSaleController::class, 'changeShow'])
    ->name('flash-sale.change-show');

//Coupons Routes
Route::resource('coupons', CouponController::class);
Route::put('coupon/change-status', [CouponController::class, 'changeStatus'])
    ->name('coupons.change-status');

//Shipping Routes
Route::put('shipping/change-status', [ShippingRuleController::class, 'changeStatus'])
    ->name('shipping.change-status');
Route::resource('shipping', ShippingRuleController::class);

//Settings Routes
Route::put('general-settings-update', [SettingsController::class, 'generalSettingsUpdate'])
    ->name('general-settings.update');
Route::get('settings', [SettingsController::class, 'index'])
    ->name('settings.index');
//home page settings routes
Route::get('homepage-settings', [HomepageSettingsController::class, 'index'])
    ->name('homepage-settings.index');
Route::put('popular-category-section', [HomepageSettingsController::class, 'updatePopularCategorySection'])
    ->name('popular-category-section.update');
Route::put('single-category-section', [HomepageSettingsController::class, 'updateSingleCategorySection'])
    ->name('single-category-section.update');
Route::put('product-slider-section', [HomepageSettingsController::class, 'updateProductSliderSection'])
    ->name('product-slider-section.update');

//order routes
Route::get('order-status', [OrderController::class, 'changeOrderStatus'])
    ->name('change-order-status');
Route::get('payment-status', [OrderController::class, 'changePaymentStatus'])
    ->name('change-payment-status');
Route::get('pending-orders', [OrderController::class, 'pendingOrders'])
    ->name('order.pending');
Route::get('processed-orders', [OrderController::class, 'processedOrders'])
    ->name('order.processed');
Route::get('dropped-orders', [OrderController::class, 'droppedOrders'])
    ->name('order.dropped');
Route::get('shipped-orders', [OrderController::class, 'shippedOrders'])
    ->name('order.shipped');
Route::get('delivery-orders', [OrderController::class, 'deliveryOrders'])
    ->name('order.delivery');
Route::get('delivered-orders', [OrderController::class, 'deliveredOrders'])
    ->name('order.delivered');
Route::get('canceled-orders', [OrderController::class, 'canceledOrders'])
    ->name('order.canceled');
Route::resource('order', OrderController::class);
Route::get('transactions', [OrderController::class, 'transactions'])
    ->name('transactions.index');

//payment settings routes
Route::get('payment-settings', [PaymentSettingsController::class, 'index'])
    ->name('payment-settings.index');
Route::put('/paypal-setting/{id}', [PaypalSettingsController::class, 'update'])
    ->name('paypal-setting.update');
Route::put('/stripe-setting/{id}', [StripeSettingsController::class, 'update'])
    ->name('stripe-setting.update');





