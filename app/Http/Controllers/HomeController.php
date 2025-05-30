<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {

        $products = Product::with('category')->get();


        return view('home.home', compact('products'));
    }
    public function show(Product $product)
    {
        // Data produk sudah otomatis didapatkan oleh Route Model Binding
        // Anda juga bisa memuat kategori di sini jika diperlukan, meskipun
        // sudah ada di model Product.
        $product->load('category'); // Memastikan relasi category terload

        // Jika Anda ingin menampilkan kategori lain di halaman detail (misal: untuk dropdown)
        // $categories = Category::all();

        // Mengirim data produk (dan kategori jika ada) ke view 'detail_product'
        return view('detail.detail', compact('product')); // Asumsi nama view Anda 'detail_product.blade.php'
    }
}
