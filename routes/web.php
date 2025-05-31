<?php

use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegistrasiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
// login & Registrasi
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::get('/registrasi', [RegistrasiController::class, 'index'])->name('registrasi');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('login');

    Route::post('/registrasi', [RegistrasiController::class, 'store'])->name('registrasi');
});

// admin
Route::middleware(['auth'])->group(function () {
    // Rute Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('can:access-admin-dashboard');
    // kategori
    Route::resource('categories', CategoryController::class)->middleware('can:access-admin-dashboard');
    // produk
    Route::resource('products', ProductController::class)->middleware('can:access-admin-dashboard');
    // adminorder
    Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index')->middleware('can:access-admin-dashboard');
    Route::get('/admin/orders/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show')->middleware('can:access-admin-dashboard');
    Route::put('/admin/orders/{order}/update-status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.updateStatus')->middleware('can:access-admin-dashboard');
});





// Rute yang memerlukan autentikasi
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::get('/detail', [DetailController::class, 'index'])->name('detail');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    // Rute ADD tetap menggunakan {product} karena kita hanya perlu ID produk untuk mencari produknya.
    // Data warna akan dikirim melalui POST request body.
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');

    // Untuk REMOVE dan UPDATE, parameter harus berupa KUNCI ITEM KERANJANG (product_id-color),
    // yang dapat berupa string, jadi kita gunakan {cartItemId}
    Route::post('/cart/remove/{cartItemId}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/update/{cartItemId}', [CartController::class, 'update'])->name('cart.update');

    // Rute untuk menampilkan form checkout
    Route::get('/checkout', [CartController::class, 'showCheckoutForm'])->name('checkout.form');
    // Rute untuk memproses data checkout (POST)
    Route::post('/checkout', [CartController::class, 'processCheckout'])->name('checkout.process');

    // --- Rute untuk OrderController ---
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});
