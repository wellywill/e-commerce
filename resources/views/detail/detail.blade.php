@extends('layout.main')
@section('container')
    <div class="bg-white">
        <div class="pt-6">
            <nav aria-label="Breadcrumb">
                <ol role="list" class="mx-auto flex max-w-2xl items-center space-x-2 px-4 sm:px-6 lg:max-w-7xl lg:px-8">
                    {{-- Link ke Beranda --}}
                    <li>
                        <div class="flex items-center">
                            <a href="{{ route('home') }}#katalog" class="mr-2 text-sm font-medium text-gray-900">Home</a>
                            <svg width="16" height="20" viewBox="0 0 16 20" fill="currentColor" aria-hidden="true"
                                class="h-5 w-4 text-gray-300">
                                <path d="M5.697 4.34L8.98 16.532h1.327L7.025 4.341H5.697z" />
                            </svg>
                        </div>
                    </li>
                    @if ($product->category)
                        <li>
                            <div class="flex items-center">
                                <span class="mr-2 text-sm font-medium text-gray-500">
                                    {{ $product->category->category_name }}
                                </span>
                                <svg width="16" height="20" viewBox="0 0 16 20" fill="currentColor"
                                    aria-hidden="true" class="h-5 w-4 text-gray-300">
                                    <path d="M5.697 4.34L8.98 16.532h1.327L7.025 4.341H5.697z" />
                                </svg>
                            </div>
                        </li>
                    @endif

                    <li class="text-sm">
                        <span aria-current="page" class="font-medium text-gray-500">
                            {{ $product->product_name }}
                        </span>
                    </li>
                </ol>
            </nav>

            <div x-data="{ mainImage: '{{ asset('storage/' . $product->image_product) }}' }"
                class="mx-auto mt-6 max-w-2xl sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-3 lg:gap-x-8 lg:px-8">

                <div class="lg:col-span-2"> {{-- Gambar utama mengambil 2 kolom di desktop --}}
                    <img :src="mainImage" class="sm:w-[450px]" alt="{{ $product->product_name }} - Main Image"
                        class="aspect-4/5 w-full h-auto rounded-lg object-cover">
                </div>

                <div class="mt-6 lg:mt-0 lg:col-span-1 lg:w-20 ">
                    <div class="grid grid-cols-4 sm:grid-cols-3 lg:grid-cols-1 gap-4"> {{-- Grid untuk thumbnail --}}
                        <img src="{{ asset('storage/' . $product->image_product) }}"
                            alt="{{ $product->product_name }} - Thumbnail" @click="mainImage = $event.target.src"
                            class="cursor-pointer aspect-square w-full rounded-lg object-cover ring-2 ring-transparent hover:ring-indigo-500 transition-all duration-200">

                        @if ($product->gallery_product && is_array($product->gallery_product) && count($product->gallery_product) > 0)
                            @foreach ($product->gallery_product as $image)
                                <img src="{{ asset('storage/' . $image) }}"
                                    alt="{{ $product->product_name }} - Gallery Thumbnail"
                                    @click="mainImage = $event.target.src"
                                    class="cursor-pointer aspect-square w-full rounded-lg object-cover ring-2 ring-transparent hover:ring-indigo-500 transition-all duration-200">
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <div
                class="mx-auto max-w-2xl px-4 pt-10 pb-16 sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-3 lg:grid-rows-[auto_auto_1fr] lg:gap-x-8 lg:px-8 lg:pt-16 lg:pb-24">
                <div class="lg:col-span-2 lg:border-r lg:border-gray-200 lg:pr-8">
                    <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">{{ $product->product_name }}
                    </h1>
                </div>

                <div class="mt-4 lg:row-span-3 lg:mt-0">
                    <h2 class="sr-only">Product information</h2>
                    <p class="text-3xl tracking-tight text-gray-900">Rp{{ number_format($product->price, 0, ',', '.') }}
                    </p>

                    <div class="mt-6">
                        <h3 class="sr-only">Stock Quantity</h3> {{-- Ubah dari Reviews jadi Stock Quantity --}}
                        <div class="flex items-center">
                            <p class="text-xl text-gray-900 font-bold">Stok: {{ $product->qty }}</p> {{-- Tampilkan jumlah stok --}}
                            {{-- Jika Anda ingin menambahkan teks "Available" atau "Tersedia" --}}
                            {{-- <p class="ml-2 text-md text-gray-600">Tersedia</p> --}}
                        </div>
                    </div>

                    {{-- Notifikasi Sukses/Error --}}
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4"
                            role="alert">
                            <strong class="font-bold">Sukses!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4"
                            role="alert">
                            <strong class="font-bold">Gagal!</strong>
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    {{-- Form Add to Bag - Pastikan action dan method sudah benar --}}
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-6">
                        @csrf {{-- Jangan lupakan CSRF token! --}}

                        {{-- Pilihan Warna --}}
                        <div class="mt-10">
                            <h3 class="text-sm font-medium text-gray-900">Color</h3>
                            <fieldset aria-label="Choose a color" class="mt-4">
                                {{-- Menggunakan flex gap-x-3 untuk jarak antar pilihan warna --}}
                                <div class="flex items-center gap-x-3">
                                    {{-- Pilihan Warna: White --}}
                                    <div class="flex">
                                        <input type="radio" name="color" value="White" id="color-white"
                                            class="sr-only peer" checked>
                                        <label for="color-white"
                                            class="relative flex cursor-pointer items-center justify-center rounded-full p-0.5
                           size-8  border border-black/10 bg-white
                           peer-checked:ring-2 peer-checked:ring-offset-2 peer-checked:ring-gray-400
                           focus:outline-hidden"
                                            aria-label="White Color">
                                            {{-- span ini sebelumnya adalah visual color swatch, sekarang label itu sendiri --}}
                                            {{-- Preline's default checked style for radio is a blue dot, adjust as needed if you want that --}}
                                        </label>
                                    </div>

                                    {{-- Pilihan Warna: Gray --}}
                                    <div class="flex">
                                        <input type="radio" name="color" value="Gray" id="color-gray"
                                            class="sr-only peer">
                                        <label for="color-gray"
                                            class="relative flex cursor-pointer items-center justify-center rounded-full p-0.5
                           size-8  border border-black/10 bg-gray-200
                           peer-checked:ring-2 peer-checked:ring-offset-2 peer-checked:ring-gray-400
                           focus:outline-hidden"
                                            aria-label="Gray Color">
                                        </label>
                                    </div>

                                    {{-- Pilihan Warna: Black --}}
                                    <div class="flex">
                                        <input type="radio" name="color" value="Black" id="color-black"
                                            class="sr-only peer">
                                        <label for="color-black"
                                            class="relative flex cursor-pointer items-center justify-center rp-0.5
                           size-8 rounded-full border border-black/10 bg-gray-900
                           peer-checked:ring-2 peer-checked:ring-offset-2 peer-checked:ring-gray-900
                           focus:outline-hidden"
                                            aria-label="Black Color">
                                        </label>
                                    </div>
                                </div>
                            </fieldset>
                        </div>

                        {{-- Tombol Add to Bag --}}
                        <button type="submit"
                            class="mt-10 flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-hidden">
                            Add to bag
                        </button>
                    </form>

                </div>

                <div class="py-10 lg:col-span-2 lg:col-start-1 lg:border-r lg:border-gray-200 lg:pt-6 lg:pr-8 lg:pb-16">
                    <div>
                        <h3 class="sr-only">Description</h3>
                        <div class="space-y-6">
                            <p class="text-base text-gray-900">{{ $product->description }}</p>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection
