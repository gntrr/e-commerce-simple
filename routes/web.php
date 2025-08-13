<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\SellerProductController;

// Store routes
Route::get('/', [StoreController::class, 'index'])->name('home');
Route::get('/p/{sku}', [StoreController::class, 'show'])->name('product.show')->middleware('auth');
Route::post('/checkout', [StoreController::class, 'checkout'])->name('checkout');

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes (require authentication)
Route::middleware('auth')->group(function () {
    // Cart routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');
    
    // User orders
    Route::get('/my-orders', [StoreController::class, 'myOrders'])->name('orders.mine');
    
    // Seller product management
    Route::prefix('seller')->name('seller.')->group(function () {
        Route::resource('products', SellerProductController::class);
    });
});

// Admin routes
Route::get('/admin/orders', [AdminOrderController::class, 'index'])->middleware('basic.auth')->name('admin.orders');
