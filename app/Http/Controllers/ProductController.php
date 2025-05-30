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

        // Ambil kategori untuk dropdown modal tambah produk
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

        $data = $request->all(); // Mengambil semua data request

        // Simpan image_product
        if ($request->hasFile('image_product')) {
            $data['image_product'] = $request->file('image_product')->store('image-product', 'public');
        } else {
            $data['image_product'] = null; // Pastikan ini diatur jika nullable dan tidak ada file
        }

        // Simpan gallery_product. Laravel akan otomatis mengkonversi array ini ke JSON string
        // karena ada '$casts = ['gallery_product' => 'array']' di model Product.
        $galleryPaths = [];
        if ($request->hasFile('gallery_product')) {
            foreach ($request->file('gallery_product') as $file) {
                // Pastikan $file adalah instance UploadedFile yang valid sebelum memanggil store()
                if ($file && $file->isValid()) {
                    $galleryPaths[] = $file->store('gallery-product', 'public');
                }
            }
        }
        $data['gallery_product'] = $galleryPaths; // Cukup masukkan array PHP

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }


    public function show(Product $product)
    {
        // Data produk sudah otomatis didapatkan oleh Route Model Binding.
        // Memastikan relasi category terload jika belum.
        $product->load('category');

        // Mengirim data produk ke view 'detail_product'
        return view('detail.detail', compact('product')); // Asumsi nama view Anda 'detail_product.blade.php'
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
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

        $data = $request->only(['product_name', 'price', 'qty', 'description', 'category_id']);

        // Handle image utama
        if ($request->hasFile('image_product')) {
            // Hapus gambar lama jika ada
            if ($product->image_product && Storage::disk('public')->exists($product->image_product)) {
                Storage::disk('public')->delete($product->image_product);
            }

            // Simpan gambar baru
            $data['image_product'] = $request->file('image_product')->store('image-product', 'public');
        }

        // Handle gallery jika ada input baru
        if ($request->hasFile('gallery_product')) {
            // Hapus file gallery lama
            if ($product->gallery_product) {
                $oldGallery = json_decode($product->gallery_product, true);
                foreach ($oldGallery as $file) {
                    if (Storage::disk('public')->exists($file)) {
                        Storage::disk('public')->delete($file);
                    }
                }
            }

            // Simpan file baru
            $galleryPaths = [];
            foreach ($request->file('gallery_product') as $file) {
                $galleryPaths[] = $file->store('gallery-product', 'public');
            }

            $data['gallery_product'] = json_encode($galleryPaths);
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Hapus gambar utama
        if ($product->image_product && file_exists(storage_path('app/public/' . $product->image_product))) {
            unlink(storage_path('app/public/' . $product->image_product));
        }

        // Hapus gambar gallery (jika disimpan sebagai array JSON, misal)
        if ($product->gallery_product) {
            foreach (json_decode($product->gallery_product) as $image) {
                if (file_exists(storage_path('app/public/' . $image))) {
                    unlink(storage_path('app/public/' . $image));
                }
            }
        }

        // Hapus data produk
        $product->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus.');
    }
}
