<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrasiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home.home');
});
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/registrasi', [RegistrasiController::class, 'index'])->name('registrasi')->middleware('guest');
Route::post('/registrasi', [RegistrasiController::class, 'store'])->name('registrasi');
