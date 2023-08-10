<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AdminController;

//Admin routes
Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

