@extends('layout.main') {{-- Sesuaikan dengan layout utama aplikasi Anda --}}

@section('container')
    <div class="mx-auto max-w-4xl px-4 py-16 sm:px-6 sm:py-24 lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900 mb-8 text-center">Daftar Pesanan Saya</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">Sukses!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if ($orders->isEmpty())
            <div class="text-center text-gray-500 py-10">
                <p class="text-lg mb-4">Anda belum memiliki pesanan.</p>
                <a href="{{ route('products.index') }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Mulai Belanja
                </a>
            </div>
        @else
            <div class="space-y-6">
                @foreach ($orders as $order)
                    <div class="bg-white shadow-sm sm:rounded-lg border border-gray-200">
                        <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                            <div>
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Pesanan #{{ $order->id }}</h3>
                                <p class="mt-1 max-w-2xl text-sm text-gray-500">Tanggal:
                                    {{ $order->order_date->format('d M Y, H:i') }}</p>
                            </div>
                            <div>
                                <span
                                    class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                                    @if ($order->status == 'completed') bg-green-100 text-green-800
                                    @elseif ($order->status == 'pending') bg-yellow-100 text-yellow-800
                                    @elseif ($order->status == 'cancelled') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Total Harga</dt>
                                    <dd class="mt-1 text-base font-semibold text-gray-900">
                                        Rp{{ number_format($order->total_price, 0, ',', '.') }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Jumlah Item</dt>
                                    <dd class="mt-1 text-base text-gray-900">{{ $order->detailOrders->sum('quantity') }}
                                    </dd>
                                </div>
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Alamat Pengiriman</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $order->shipping_address }}</dd>
                                </div>
                            </dl>
                        </div>
                        <div class="px-4 py-4 sm:px-6 bg-gray-50 text-right">
                            <a href="{{ route('orders.show', $order->id) }}"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
