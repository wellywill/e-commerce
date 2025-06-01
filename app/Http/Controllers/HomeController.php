<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {

        $categories = Category::all();
        $bestSellers = Product::select('products.*')
            ->join('detail_orders', 'products.id', '=', 'detail_orders.product_id')
            ->selectRaw('products.*, COUNT(detail_orders.product_id) as total_sold')
            ->groupBy('products.id') // Sertakan semua kolom product jika menggunakan Strict Mode MySQL
            ->orderByDesc('total_sold')
            ->limit(4) // Ambil 4 produk best seller
            ->get();

        $selectedCategoryId = $request->query('category_id');

        $sortBy = $request->query('sort_by', 'product_name_asc');
        $searchQuery = $request->query('search');

        $productsQuery = Product::with('category');

        // terapkan Filter
        if ($selectedCategoryId && $selectedCategoryId !== 'all') {
            $productsQuery->where('category_id', $selectedCategoryId);
        }
        // Terapkan Filter Pencarian
        if ($searchQuery) {
            $productsQuery->where('product_name', 'like', '%' . $searchQuery . '%');
            // Jika ingin mencari di kolom lain juga, tambahkan:
            // $productsQuery->orWhere('description', 'like', '%' . $searchQuery . '%');
        }

        // Terapkan sorting
        switch ($sortBy) {
            case 'product_name_asc':
                $productsQuery->orderBy('product_name', 'asc');
                break;
            case 'product_name_desc':
                $productsQuery->orderBy('product_name', 'desc');
                break;
            case 'price_asc':
                $productsQuery->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $productsQuery->orderBy('price', 'desc');
                break;
            default:
                $productsQuery->orderBy('product_name', 'asc');
                break;
        }


        $products = $productsQuery->get();

        return view('home.home', compact('products', 'categories', 'selectedCategoryId', 'sortBy', 'bestSellers', 'searchQuery'));
    }
    public function show(Product $product)
    {
        $product->load('category');

        return view('detail.detail', compact('product'));
    }
}
