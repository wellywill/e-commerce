@extends('layout.main') {{-- Pastikan ini mengarah ke layout utama Anda --}}

@section('container')
    <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900 mb-8">Informasi Checkout</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Sukses!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Gagal!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Ada kesalahan:</strong>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="lg:grid lg:grid-cols-2 lg:gap-x-12 xl:gap-x-16">
            {{-- Detail Pesanan --}}
            <div>
                <h2 class="text-lg font-medium text-gray-900 mb-4">Ringkasan Pesanan</h2>
                <div class="border-t border-gray-200 py-6">
                    <ul role="list" class="-my-6 divide-y divide-gray-200">
                        @foreach ($cart as $cartItemId => $details)
                            <li class="flex py-6">
                                <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                                    <img src="{{ asset('storage/' . $details['image']) }}"
                                        alt="{{ $details['product_name'] }}"
                                        class="h-full w-full object-cover object-center">
                                </div>
                                <div class="ml-4 flex flex-1 flex-col">
                                    <div>
                                        <div class="flex justify-between text-base font-medium text-gray-900">
                                            <h3>{{ $details['product_name'] }}</h3>
                                            <p class="ml-4">
                                                Rp{{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}
                                            </p>
                                        </div>
                                        <p class="mt-1 text-sm text-gray-500">Qty: {{ $details['quantity'] }}</p>
                                        @if (isset($details['color']))
                                            <p class="mt-1 text-sm text-gray-500">Color: {{ $details['color'] }}</p>
                                        @endif
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="border-t border-gray-200 py-6 flex justify-between text-base font-medium text-gray-900">
                    <p>Total Harga</p>
                    <p>Rp{{ number_format($total, 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- Form Pengiriman dan Pembayaran --}}
            <div class="mt-10 lg:mt-0">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Alamat Pengiriman</h2>
                <form action="{{ route('checkout.process') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="shipping_address" class="block text-sm font-medium text-gray-700">Alamat
                            Pengiriman</label>
                        <div class="mt-1">
                            <textarea id="shipping_address" name="shipping_address" rows="3" required
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"></textarea>
                        </div>
                        @error('shipping_address')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>



                    <button type="submit"
                        class="w-full flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700">
                        Buat Pesanan
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
