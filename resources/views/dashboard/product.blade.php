@extends('layout.main') {{-- Ganti dengan layout yang kamu gunakan --}}

@section('container')
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold text-coklattua">Kelola Produk</h1>
            <div class="text-center my-8">
                <div class="flex gap-2 items-center">
                    <!-- Tombol Kembali ke Dashboard -->
                    <a href="{{ route('dashboard') }}"
                        class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-300 text-gray-700 bg-white hover:bg-gray-100 focus:outline-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                        Dashboard
                    </a>
                    <!-- Tombol Tambah Produk -->
                    <button data-hs-overlay="#create-product-modal" type="button"
                        class="px-4 py-2 text-white bg-coklatmuda-100 hover:bg-coklattua rounded-lg">
                        Tambah Produk
                    </button>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-coklatmuda-100 text-white">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold">#</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Nama Produk</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Gambar</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Gallery</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Harga</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Qty</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Kategori</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Description</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-sm">
                    @foreach ($products as $index => $product)
                        <tr>
                            <td class="px-4 py-2">{{ $index + 1 }}</td>
                            <td class="px-4 py-2">{{ $product->product_name }}</td>
                            <td class="px-4 py-2">
                                <img src="{{ asset('storage/' . $product->image_product) }}"
                                    class="w-16 h-16 object-cover rounded-md" alt="">
                            </td>
                            <td class="px-4 py-2">
                                @if ($product->gallery_product && is_array($product->gallery_product) && count($product->gallery_product) > 0)
                                    <div class="flex flex-wrap gap-1">
                                        @foreach ($product->gallery_product as $galleryImage)
                                            <img src="{{ asset('storage/' . $galleryImage) }}"
                                                class="w-10 h-10 rounded object-cover" alt="gallery">
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-gray-400 italic">Tidak ada gambar</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                            <td class="px-4 py-2">{{ $product->qty }}</td>
                            <td class="px-4 py-2">{{ $product->category->category_name ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $product->description }}</td>
                            <td class="px-4 py-2 flex gap-2">
                                <button type="button" onclick='openEditModal(@json($product))'
                                    class="bg-coklatmuda-100 text-white p-2 rounded hover:bg-coklattua focus:outline-none  ">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path
                                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.38-2.828-2.829z" />
                                    </svg>
                                </button>

                                <button onclick="setDeleteProduct({{ $product->id }})"
                                    data-hs-overlay="#delete-product-modal"
                                    class="bg-red-600 p-2 rounded text-white hover:bg-red-800 focus:outline-none ">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 011-1h4a1 1 0 110 2H8a1 1 0 01-1-1zm1 3a1 1 0 100 2h4a1 1 0 100-2H8z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @include('product.tambah')
    @include('product.edit')
    @include('product.delete')
    @if (session('success'))
        <div class="absolute bottom-3 end-2">
            @include('alert.alertsukses')
        </div>
    @endif
    @if ($errors->any())
        <div class="absolute bottom-3 end-2">
            @include('alert.alertgagal')
        </div>
    @endif
@endsection
