@extends('layout.main') {{-- Pastikan ini mengarah ke layout utama Anda --}}

@section('container')
    <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900 mb-8">Keranjang Belanja Anda</h1>

        {{-- Menampilkan Notifikasi Sukses/Error --}}
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

        @if (empty($cart))
            {{-- Kondisi jika keranjang kosong --}}
            <p class="text-gray-600">Keranjang belanja Anda kosong. Mari mulai belanja!</p>
            <a href="{{ route('home') }}"
                class="mt-4 inline-block px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">Lanjutkan
                Belanja</a>
        @else
            {{-- Kondisi jika keranjang ada isinya --}}
            <div class="border-t border-gray-200 py-6">
                <ul role="list" class="-my-6 divide-y divide-gray-200">
                    @php $total = 0; @endphp
                    @foreach ($cart as $cartItemId => $details)
                        {{-- $cartItemId adalah kunci unik (product_id-color) --}}
                        @php $total += $details['price'] * $details['quantity']; @endphp
                        <li class="flex py-6">
                            <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                                <img src="{{ asset('storage/' . $details['image']) }}" alt="{{ $details['product_name'] }}"
                                    class="h-full w-full object-cover object-center">
                            </div>

                            <div class="ml-4 flex flex-1 flex-col">
                                <div>
                                    <div class="flex justify-between text-base font-medium text-gray-900">
                                        <h3>
                                            <a
                                                href="{{ route('products.show', $details['product_id']) }}">{{ $details['product_name'] }}</a>
                                        </h3>
                                        <p class="ml-4">
                                            Rp{{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}</p>
                                    </div>
                                    {{-- Menampilkan Warna --}}
                                    @if (isset($details['color']))
                                        <p class="mt-1 text-sm text-gray-500">Color: {{ $details['color'] }}</p>
                                    @endif
                                </div>
                                <div class="flex flex-1 items-end justify-between text-sm">
                                    <div class="flex items-center mt-2">
                                        {{-- Form Update Kuantitas --}}
                                        <form action="{{ route('cart.update', $cartItemId) }}" method="POST">
                                            @csrf
                                            <label for="quantity-{{ $cartItemId }}" class="sr-only">Quantity</label>
                                            <input type="number" id="quantity-{{ $cartItemId }}" name="quantity"
                                                value="{{ $details['quantity'] }}" min="1"
                                                class="w-16 text-center border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <button type="submit"
                                                class="ml-2 text-indigo-600 hover:text-indigo-900">Update</button>
                                        </form>
                                    </div>

                                    <div class="flex">
                                        {{-- Form Hapus Item --}}
                                        <form action="{{ route('cart.remove', $cartItemId) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="font-medium text-indigo-600 hover:text-indigo-500">Remove</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="border-t border-gray-200 py-6 px-4 sm:px-6">
                <div class="flex justify-between text-base font-medium text-gray-900">
                    <p>Subtotal</p>
                    <p>Rp{{ number_format($total, 0, ',', '.') }}</p>
                </div>
                <p class="mt-0.5 text-sm text-gray-500">Shipping and taxes calculated at checkout.</p>
                <div class="mt-6">
                    <a href="{{ route('checkout.form') }}"
                        class="flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700">Checkout</a>
                </div>
                <div class="mt-6 flex justify-center text-center text-sm text-gray-500">
                    <p>
                        or
                        <a href="{{ route('home') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                            Continue Shopping
                            <span aria-hidden="true"> &rarr;</span>
                        </a>
                    </p>
                </div>
            </div>
        @endif
    </div>
@endsection
