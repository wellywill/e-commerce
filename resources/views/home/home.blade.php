@extends('layout.main')
@section('container')
    <!-- Wrapper untuk mengatur posisi slider ke kanan -->
    <div class="flex flex-row sm:flex-row sm:items-center pl-5  sm:h-screen px-2 sm:pl-10">
        <!-- Teks di kiri -->
        <div class="pt-12 sm:pt-0 sm:mb-0 sm:ml-20  sm:w-1/2  text-left ">
            <h1 class="text-[15px] sm:text-4xl font-bold text-coklattua drop-shadow-lg mb-2 sm:mb-4 ">Temukan Gadget
                Impianmu!</h1>
            <p class="text-black text-xs sm:text-xl pb-5 ">Belanja aman, cepat, dan terpercaya hanya di
                <span id="typingText" class=" font-bold text-coklattua drop-shadow-lg"></span>
            </p>
            <a href="#katalog"
                class="mt-2 px-4 py-1 sm:mt-4 sm:px-6 sm:py-2 text-[10px] sm:text-[15px] bg-coklatmuda-100 text-white font-semibold rounded-lg shadow-xl shadow-coklattua/50 hover:bg-coklattua transition duration-300">
                Shop Now
            </a>
        </div>
        <!-- Slider -->
        <div data-hs-carousel='{
      "loadingClasses": "opacity-0",
      "dotsItemClasses": "hs-carousel-active:bg-blue-700 hs-carousel-active:border-blue-700 size-3 border border-gray-400 rounded-full cursor-pointer",
      "isAutoPlay": true
    }'
            class="relative w-full max-w-[200px] sm:max-w-2xl">

            <div class="hs-carousel relative overflow-hidden min-h-52 sm:min-h-96  rounded-lg">
                <div
                    class="hs-carousel-body absolute top-0 bottom-0 start-0 flex flex-nowrap transition-transform duration-700 opacity-0">
                    <div class="hs-carousel-slide">
                        <div class="flex justify-center h-50 sm:h-full p-6 sm:p-0">
                            <img src="asset/img/iphone.png" alt="">
                        </div>
                    </div>
                    <div class="hs-carousel-slide">
                        <div class="flex justify-center h-50 sm:h-full p-6 sm:p-0">
                            <img src="asset/img/samsung.png" alt="">
                        </div>
                    </div>
                    <div class="hs-carousel-slide">
                        <div class="flex justify-center h-50 sm:h-full p-6 sm:p-0">
                            <img src="asset/img/huawei.png" alt="">
                        </div>
                    </div>
                    <div class="hs-carousel-slide">
                        <div class="flex justify-center h-50 sm:h-full p-6 sm:p-0">
                            <img src="asset/img/vivo.png" alt="">
                        </div>
                    </div>
                    <div class="hs-carousel-slide">
                        <div class="flex justify-center h-50 sm:h-full p-6 sm:p-0">
                            <img src="asset/img/oppo.png" alt="">
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- End Slider -->
    </div>
    <div class="" id="katalog">

        <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8 ">
            <h2 class="text-2xl font-bold uppercase tracking-widest  inline-flex  rounded-full text-coklattua">
                <!-- SVG Ikon -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-8 text-coklattua mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                </svg>
                Katalog
            </h2>

            <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                @foreach ($products as $product)
                    <div class="group relative bg-coklatmuda-100 px-2 py-2 rounded-md">
                        {{-- Pastikan path gambar produk benar. Asumsi menggunakan storage link --}}
                        <img src="{{ asset('storage/' . $product->image_product) }}" alt="{{ $product->product_name }}"
                            class="aspect-square w-full rounded-md bg-gray-200 object-cover group-hover:opacity-75 lg:aspect-auto lg:h-80">
                        <div class="mt-4 flex justify-between">
                            <div>
                                <h3 class="text-sm text-white">
                                    <a href="{{ route('products.show', $product->id) }}">
                                        <span aria-hidden="true" class="absolute inset-0"></span>
                                        {{ $product->product_name }}
                                    </a>
                                </h3>

                                <p class="mt-1 text-sm text-coklattua">
                                    {{ $product->category->category_name ?? 'Uncategorized' }}</p>
                            </div>
                            <p class="text-sm font-medium text-black">Rp{{ number_format($product->price, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
