@extends('layout.main')
@section('container')
    <div class="relative">
        <div class="absolute top-96  -z-40 right-10 bg-orange-500 w-72 h-72 rounded-full opacity-80 blur-[120px]"></div>
    </div>
    {{-- <div class="relative">
        <div
            class="absolute hidden sm:block top-80  -z-40 left-10 bg-orange-500 w-80 h-80 rounded-full opacity-80 blur-[120px]">
        </div>
    </div> --}}
    <div class="relative">
        <div class="absolute top-28  -z-40 left-1/2 bg-orange-500 w-72 h-72  rounded-full opacity-80 blur-[120px]"></div>
    </div>
    <!-- Wrapper untuk mengatur posisi slider ke kanan -->
    <div class="flex flex-row sm:flex-row sm:items-center pl-5  sm:h-screen px-2 sm:pl-10">
        <!-- Teks di kiri -->
        <div class="pt-12 sm:pt-0 sm:mb-0 sm:ml-20  sm:w-1/2  text-left ">
            <h1 class="text-[15px] sm:text-4xl font-bold text-orange-500 drop-shadow-lg mb-2 sm:mb-4 ">Temukan Gadget
                Impianmu!</h1>
            <p class="text-white text-xs sm:text-xl ">Belanja aman, cepat, dan terpercaya hanya di
                <span id="typingText" class=" font-bold text-orange-500 drop-shadow-lg"></span>
            </p>
            <button
                class="mt-2 px-4 py-1 sm:mt-4 sm:px-6 sm:py-2 text-[10px] sm:text-[15px] bg-orange-500 text-white font-semibold rounded-lg shadow-xl shadow-orange-500/50 hover:bg-orange-600 transition duration-300">
                Shop Now
            </button>
        </div>
        <!-- Slider -->
        <div data-hs-carousel='{
      "loadingClasses": "opacity-0",
      "dotsItemClasses": "hs-carousel-active:bg-blue-700 hs-carousel-active:border-blue-700 size-3 border border-gray-400 rounded-full cursor-pointer",
      "isAutoPlay": true
    }'
            class="relative w-full max-w-[200px] sm:max-w-2xl"> <!-- max-w-md agar tidak selebar layar -->

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
@endsection
