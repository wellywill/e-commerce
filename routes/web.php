<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegistrasiController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products/{product}', [HomeController::class, 'show'])->name('productshow');
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/registrasi', [RegistrasiController::class, 'index'])->name('registrasi')->middleware('guest');
Route::post('/registrasi', [RegistrasiController::class, 'store'])->name('registrasi');
Route::get('/detail', [DetailController::class, 'index'])->name('detail');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);
