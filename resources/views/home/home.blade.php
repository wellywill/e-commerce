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
    {{-- Bagian Best Seller (Tambahan Baru) --}}
    <div class="mx-auto max-w-2xl px-4 py-8  sm:px-6  sm:py-10 lg:max-w-7xl lg:px-8">
        <h2 class="text-2xl font-bold uppercase tracking-widest inline-flex rounded-full text-coklattua mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-8 mr-1 text-coklattua">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z" />
            </svg>

            Best Seller
        </h2>

        <div class="grid grid-cols-4 gap-x-3 sm:gap-x-6 gap-y-10 sm:grid-cols-4 lg:grid-cols-6 xl:gap-x-8">
            @forelse ($bestSellers as $product)
                <a href="{{ route('products.show', $product->id) }}" class="group block text-center"> {{-- Tambah text-center --}}
                    <div
                        class="w-10 h-10 sm:w-32 sm:h-32 mx-auto overflow-hidden rounded-full bg-gray-100 flex items-center justify-center group-hover:opacity-75 shadow-lg">
                        {{-- Ukuran kecil dan rounded-full --}}
                        <img src="{{ asset('storage/' . $product->image_product) }}" alt="{{ $product->product_name }}"
                            class="h-full w-full object-contain object-center p-2"> {{-- object-contain untuk menghindari cropping --}}
                    </div>
                    <h3 class="mt-4 text-[10px] sm:text-sm text-gray-700 font-medium truncate">{{ $product->product_name }}
                    </h3>
                    {{-- Tambah truncate
                    <p class="mt-1 text-xs font-semibold text-gray-900">Rp{{ number_format($product->price, 0, ',', '.') }}
                    </p> --}}
                </a>
            @empty
                <div class="col-span-full text-center py-10 text-gray-600">
                    <p>Belum ada produk best seller.</p>
                </div>
            @endforelse
        </div>
    </div>

    <div class="" id="katalog">
        <div class="mx-auto max-w-2xl px-4 py-4 sm:px-6 sm:py-10 lg:max-w-7xl lg:px-8 ">
            <h2 class="text-2xl font-bold uppercase tracking-widest inline-flex rounded-full text-coklattua">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-8 text-coklattua mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                </svg>
                Katalog
            </h2>

            <div x-data="{
                selectedCategory: '{{ $selectedCategoryId ?? 'all' }}',
                sortBy: '{{ $sortBy ?? 'product_name_asc' }}',
                dropdownOpen: false, // Tambahkan state untuk dropdown
                applyFilters: function() {
                    const url = new URL(window.location.href);
                    url.searchParams.set('category_id', this.selectedCategory);
                    url.searchParams.set('sort_by', this.sortBy);
                    window.location.href = url.toString();
                },
                setSortAndClose: function(value) {
                    this.sortBy = value;
                    this.dropdownOpen = false;
                    this.applyFilters();
                }
            }" class="flex flex-row justify-between items-center mt-8 mb-6 gap-4">

                <div class="flex flex-wrap lg:gap-3 gap-1 justify-center sm:justify-start">
                    <button @click="selectedCategory = 'all'; applyFilters()"
                        :class="{ 'bg-coklattua text-white ': selectedCategory === 'all', 'bg-gray-200 text-gray-700  hover:bg-gray-300': selectedCategory !== 'all' }"
                        class="lg:px-4 lg:py-2 py-1 px-1 rounded-full lg:text-sm text-[7px] font-medium transition-colors duration-200 shadow-md">
                        Semua Produk
                    </button>
                    @foreach ($categories as $category)
                        <button @click="selectedCategory = '{{ $category->id }}'; applyFilters()"
                            :class="{
                                'bg-coklattua text-white lg:text-sm text-[7px] py-1 px-1': selectedCategory ==
                                    '{{ $category->id }}',
                                'bg-gray-200 text-gray-700 text-[7px] py-1 px-1 lg:text-sm hover:bg-gray-300': selectedCategory !=
                                    '{{ $category->id }}'
                            }"
                            class="px-4 py-2 rounded-full text-sm font-medium transition-colors duration-200 shadow-md flex items-center">

                            @if ($category->logo_path)
                                <img src="{{ asset('storage/' . $category->logo_path) }}"
                                    alt="{{ $category->category_name }} Logo" class="size-5 mr-2 object-contain">
                            @endif
                            {{ $category->category_name }}
                        </button>
                    @endforeach
                </div>

                <div class="relative inline-block text-left" x-data="{ open: false }" @click.away="open = false">
                    <div>
                        <button type="button" @click="open = !open"
                            class="group inline-flex justify-center lg:text-sm text-[7px]  font-medium text-gray-700 hover:text-gray-900"
                            id="menu-button" aria-expanded="true" aria-haspopup="true">
                            Sort
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="lg:size-5 size-3 ml-1">
                                <path fill-rule="evenodd"
                                    d="M3.792 2.938A49.069 49.069 0 0 1 12 2.25c2.797 0 5.54.236 8.209.688a1.857 1.857 0 0 1 1.541 1.836v1.044a3 3 0 0 1-.879 2.121l-6.182 6.182a1.5 1.5 0 0 0-.439 1.061v2.927a3 3 0 0 1-1.658 2.684l-1.757.878A.75.75 0 0 1 9.75 21v-5.818a1.5 1.5 0 0 0-.44-1.06L3.13 7.938a3 3 0 0 1-.879-2.121V4.774c0-.897.64-1.683 1.542-1.836Z"
                                    clip-rule="evenodd" />
                            </svg>

                        </button>
                    </div>

                    <div x-show="open" x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute right-0 z-10 mt-2 w-40 origin-top-right rounded-md bg-white shadow-2xl ring-1 ring-black/5 focus:outline-none"
                        role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                        <div class="py-1" role="none">
                            <a href="#" @click.prevent="setSortAndClose('product_name_asc')"
                                :class="{ 'font-medium text-gray-900 bg-gray-100': sortBy === 'product_name_asc', 'text-gray-500 hover:bg-gray-50': sortBy !== 'product_name_asc' }"
                                class="block px-4 py-2 text-sm" role="menuitem" tabindex="-1">Nama: A-Z</a>
                            <a href="#" @click.prevent="setSortAndClose('product_name_desc')"
                                :class="{ 'font-medium text-gray-900 bg-gray-100': sortBy === 'product_name_desc', 'text-gray-500 hover:bg-gray-50': sortBy !== 'product_name_desc' }"
                                class="block px-4 py-2 text-sm" role="menuitem" tabindex="-1">Nama: Z-A</a>
                            <a href="#" @click.prevent="setSortAndClose('price_asc')"
                                :class="{ 'font-medium text-gray-900 bg-gray-100': sortBy === 'price_asc', 'text-gray-500 hover:bg-gray-50': sortBy !== 'price_asc' }"
                                class="block px-4 py-2 text-sm" role="menuitem" tabindex="-1">Harga: Termurah</a>
                            <a href="#" @click.prevent="setSortAndClose('price_desc')"
                                :class="{ 'font-medium text-gray-900 bg-gray-100': sortBy === 'price_desc', 'text-gray-500 hover:bg-gray-50': sortBy !== 'price_desc' }"
                                class="block px-4 py-2 text-sm" role="menuitem" tabindex="-1">Harga: Termahal</a>
                        </div>
                    </div>
                </div>
                {{-- End Sorting Dropdown (New Layout) --}}
            </div>

            <div class="mt-6 grid grid-cols-3 gap-x-6 gap-y-10  lg:grid-cols-4 xl:gap-x-8">
                @forelse ($products as $product)
                    <div class="group relative bg-coklatmuda-100 px-2 py-2 rounded-md">
                        {{-- Pastikan path gambar produk benar. Asumsi menggunakan storage link --}}
                        <img src="{{ asset('storage/' . $product->image_product) }}" alt="{{ $product->product_name }}"
                            class="aspect-square w-full rounded-md bg-gray-200 object-cover group-hover:opacity-75 lg:aspect-auto lg:h-80">
                        <div class="mt-4 flex justify-between">
                            <div>
                                <h3 class="lg:text-sm text-white text-[7px] ">
                                    <a href="{{ route('products.show', $product->id) }}">
                                        <span aria-hidden="true" class="absolute inset-0"></span>
                                        {{ $product->product_name }}
                                    </a>
                                </h3>

                                <p class="mt-1 lg:text-sm text-coklattua text-[7px]">
                                    {{ $product->category->category_name ?? 'Uncategorized' }}</p>
                            </div>
                            <p class="lg:text-sm text-[7px] font-medium text-black">
                                Rp{{ number_format($product->price, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-10 text-gray-600">
                        <p>Tidak ada produk yang ditemukan untuk kategori atau filter ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <script>
        // Inisialisasi Alpine.js data untuk fungsionalitas pencarian, filter, dan sorting
        document.addEventListener('alpine:init', () => {
            Alpine.data('searchFunctionality', () => ({
                // Inisialisasi state dari parameter URL saat ini
                searchQuery: '{{ request('search', '') }}',
                selectedCategory: '{{ $selectedCategoryId ?? 'all' }}',
                sortBy: '{{ $sortBy ?? 'product_name_asc' }}',
                dropdownOpen: false,


                applyFilters: function() {

                    const url = new URL(window.location.origin + window.location.pathname);

                    g
                    if (this.searchQuery && this.searchQuery.trim() !== '') {
                        url.searchParams.set('search', this.searchQuery.trim());
                    } else {
                        url.searchParams.delete('search');
                    }


                    url.searchParams.set('category_id', this.selectedCategory);


                    url.searchParams.set('sort_by', this.sortBy);


                    url.hash =
                        'katalog';


                    window.location.href = url.toString();
                },


                setSortAndClose: function(value) {
                    this.sortBy = value;
                    this.dropdownOpen = false;
                    this.applyFilters();
                }
            }));
        });
    </script>
@endsection
