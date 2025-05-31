<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        // Ambil semua produk beserta relasi category-nya supaya tidak N+1 problem
        $products = Product::with('category')->get();
        $categories = Category::all();

        return view('dashboard.product', compact('products', 'categories'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'image_product' => 'nullable|image|max:2048',
            'gallery_product' => 'nullable|array',
            'gallery_product.*' => 'image|max:2048', // validasi setiap file dalam array
            'price' => 'required|integer',
            'qty' => 'required|integer',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $data = $request->all();

        // Simpan image_product
        if ($request->hasFile('image_product')) {
            $data['image_product'] = $request->file('image_product')->store('image-product', 'public');
        } else {
            $data['image_product'] = null;
        }

        $galleryPaths = [];
        if ($request->hasFile('gallery_product')) {
            foreach ($request->file('gallery_product') as $file) {
                if ($file && $file->isValid()) {
                    $galleryPaths[] = $file->store('gallery-product', 'public');
                }
            }
        }
        $data['gallery_product'] = $galleryPaths;

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }


    public function show(Product $product)
    {
        $product->load('category');

        return view('detail.detail', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $rules = [
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'qty' => 'required|integer',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
        ];

        // Validasi image_product hanya jika ada file baru diunggah
        if ($request->hasFile('image_product')) {
            $rules['image_product'] = 'image|max:2048';
        }

        // Validasi gallery_product hanya jika ada file baru diunggah
        if ($request->hasFile('gallery_product')) {
            $rules['gallery_product'] = 'array';
            $rules['gallery_product.*'] = 'image|max:2048';
        }

        $validatedData = $request->validate($rules);

        // --- Penanganan image_product ---
        if ($request->hasFile('image_product')) {
            // Hapus gambar lama jika ada dan file-nya eksis
            if ($product->image_product && Storage::disk('public')->exists($product->image_product)) {
                Storage::disk('public')->delete($product->image_product);
            }
            // Simpan gambar baru
            $validatedData['image_product'] = $request->file('image_product')->store('image-product', 'public');
        } else {
            // Jika tidak ada gambar baru,nilai lama dipertahankan
            $validatedData['image_product'] = $product->image_product;
        }

        // --- Penanganan gallery_product ---
        // Jika ada file gallery baru diunggah
        if ($request->hasFile('gallery_product')) {
            // Hapus semua file gallery lama jika ada
            if ($product->gallery_product && is_array($product->gallery_product)) {
                foreach ($product->gallery_product as $imagePath) {
                    if (Storage::disk('public')->exists($imagePath)) {
                        Storage::disk('public')->delete($imagePath);
                    }
                }
            }

            // Simpan file gallery baru
            $galleryPaths = [];
            foreach ($request->file('gallery_product') as $file) {
                if ($file && $file->isValid()) { // Pastikan file valid
                    $galleryPaths[] = $file->store('gallery-product', 'public');
                }
            }
            $validatedData['gallery_product'] = $galleryPaths; // Ini akan di-cast otomatis ke JSON string
        } else {
            // Jika tidak ada gallery baru, pertahankan yang lama
            $validatedData['gallery_product'] = $product->gallery_product;
        }

        // Update produk dengan data yang sudah divalidasi dan diolah
        $product->update($validatedData);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Hapus gambar utama
        if ($product->image_product && file_exists(storage_path('app/public/' . $product->image_product))) {
            unlink(storage_path('app/public/' . $product->image_product));
        }

        if ($product->gallery_product && is_array($product->gallery_product)) {
            foreach ($product->gallery_product as $image) {
                if (Storage::disk('public')->exists($image)) {
                    Storage::disk('public')->delete($image);
                }
            }
        }

        // Hapus data produk
        $product->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus.');
    }
}
