<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

// Public routes for customers
Route::get('/', [CustomerController::class, 'home'])->name('home');
Route::get('/shop', [CustomerController::class, 'shop'])->name('shop');

// Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Checkout routes
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
});

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Categories
    Route::resource('categories', CategoryController::class);

    // Products
    Route::resource('products', ProductController::class);

    // Orders
    Route::resource('orders', OrderController::class);

    // Customer orders
    Route::get('/my-orders', [CustomerController::class, 'myOrders'])->name('customer.orders');
    Route::get('/my-orders/{order}', [CustomerController::class, 'orderDetail'])->name('customer.order.detail');
});

// Public product detail route (must come after resource routes to avoid conflicts)
Route::get('/products-detail/{product}', [CustomerController::class, 'productDetail'])->name('product.detail');

// Public category products route (must come after resource routes to avoid conflicts)
Route::get('/categories-detail/{category}', [CustomerController::class, 'categoryProducts'])->name('category.products');

require __DIR__ . '/auth.php';
