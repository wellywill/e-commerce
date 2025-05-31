@extends('layout.main')
@section('container')
    <div class="min-h-screen  py-10 px-4 sm:px-6 lg:px-8">

        <h1 class="text-3xl font-bold text-coklattua mb-8">Admin Dashboard</h1>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Kelola Produk -->
            <a href="{{ route('products.index') }}"
                class="group bg-coklatmuda-100 rounded-xl shadow-md p-6 hover:shadow-lg hover:scale-[1.02] hover:bg-coklattua transition">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-white group-hover:text-black">Kelola Produk</h2>
                    <svg class="w-6 h-6 text-white group-hover:scale-110 group-hover:text-black transition" fill="none"
                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M3 12h18M3 17h18"></path>
                    </svg>
                </div>
                <p class="text-sm text-gray-300">Tambah, edit, atau hapus produk di katalog.</p>
            </a>

            <!-- Lihat Pesanan -->
            <a href="{{ route('admin.orders.index') }}"
                class="group bg-coklatmuda-100 rounded-xl shadow-md p-6 hover:bg-coklattua hover:shadow-lg hover:scale-[1.02] transition">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-white group-hover:text-black">Pesanan Masuk</h2>
                    <svg class="w-6 h-6 text-white group-hover:scale-110 transition" fill="none" stroke="currentColor"
                        stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-6h13M3 6h18M3 6l3 9h13"></path>
                    </svg>
                </div>
                <p class="text-sm text-gray-300">Lihat dan kelola semua pesanan pelanggan.</p>
            </a>

            <!-- Pembayaran -->
            <a href="#"
                class="group bg-coklatmuda-100 rounded-xl shadow-md p-6 hover:shadow-lg hover:scale-[1.02]  transition">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-white group-hover:text-orange-500">Pembayaran</h2>
                    <svg class="w-6 h-6 text-orange-500 group-hover:scale-110 transition" fill="none"
                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 9V7a4 4 0 00-8 0v2H5v10h14V9h-2zM7 13h10"></path>
                    </svg>
                </div>
                <p class="text-sm text-gray-300">Pantau dan konfirmasi status pembayaran.</p>
            </a>

            <a href="{{ route('categories.index') }}"
                class="group bg-coklatmuda-100 rounded-xl shadow-md p-6 hover:bg-coklattua hover:shadow-lg hover:scale-[1.02] transition">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-white group-hover:text-black">Kelola Kategori</h2>
                    <svg class="w-6 h-6 text-white group-hover:scale-110 group-hover:text-black transition" fill="none"
                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h8m-8 6h16"></path>
                    </svg>
                </div>
                <p class="text-sm text-gray-300">Tambah, edit, atau hapus kategori produk.</p>
            </a>
        </div>
    </div>
@endsection
