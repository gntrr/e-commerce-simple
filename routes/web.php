<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\AdminOrderController;

// Store routes
Route::get('/', [StoreController::class, 'index']);
Route::get('/p/{sku}', [StoreController::class, 'show']);
Route::post('/checkout', [StoreController::class, 'checkout']);

// Admin routes
Route::get('/admin/orders', [AdminOrderController::class, 'index'])->middleware('basic.auth');
