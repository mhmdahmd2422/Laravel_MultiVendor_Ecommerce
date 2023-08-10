<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\VendorController;


//Vendor routes
Route::get('dashboard', [VendorController::class, 'dashboard'])->name('dashboard');

