@extends('layout.main') {{-- Sesuaikan dengan layout utama aplikasi Anda --}}

@section('container')
    <div class="mx-auto max-w-4xl px-4 py-16 sm:px-6 sm:py-24 lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900 mb-8 text-center">Detail Pesanan #{{ $order->id }}</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">Sukses!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">Gagal!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="bg-white shadow-sm sm:rounded-lg border border-gray-200 p-6">
            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">ID Pesanan</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $order->id }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Tanggal Pesanan</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $order->order_date->format('d M Y, H:i') }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Total Harga</dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-900">
                        Rp{{ number_format($order->total_price, 0, ',', '.') }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        <span
                            class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                            @if ($order->status == 'completed') bg-green-100 text-green-800
                            @elseif ($order->status == 'pending') bg-yellow-100 text-yellow-800
                            @elseif ($order->status == 'cancelled') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-gray-500">Alamat Pengiriman</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $order->shipping_address }}</dd>
                </div>
            </dl>

            <h2 class="text-xl font-bold tracking-tight text-gray-900 mt-8 mb-4">Item Pesanan</h2>
            <div class="flow-root">
                <ul role="list" class="-my-6 divide-y divide-gray-200">
                    @foreach ($order->detailOrders as $detail)
                        <li class="flex py-6">
                            <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                                <img src="{{ asset('storage/' . $detail->product->image_product) }}"
                                    alt="{{ $detail->product->product_name }}"
                                    class="h-full w-full object-cover object-center">
                            </div>

                            <div class="ml-4 flex flex-1 flex-col">
                                <div>
                                    <div class="flex justify-between text-base font-medium text-gray-900">
                                        <h3>
                                            <a
                                                href="{{ route('products.show', $detail->product->id) }}">{{ $detail->product->product_name }}</a>
                                        </h3>
                                        <p class="ml-4">
                                            Rp{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}</p>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500">Harga Satuan:
                                        Rp{{ number_format($detail->price, 0, ',', '.') }}</p>
                                    @if ($detail->color)
                                        <p class="mt-1 text-sm text-gray-500">Warna: {{ $detail->color }}</p>
                                    @endif
                                </div>
                                <div class="flex flex-1 items-end justify-between text-sm">
                                    <p class="text-gray-500">Qty {{ $detail->quantity }}</p>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            @if ($order->payments->isNotEmpty())
                <h2 class="text-xl font-bold tracking-tight text-gray-900 mt-8 mb-4">Informasi Pembayaran</h2>
                <div class="border-t border-gray-200 pt-4">
                    @foreach ($order->payments as $payment)
                        <div class="flex justify-between text-sm text-gray-700">
                            <p>Metode Pembayaran: {{ $payment->payment_method }}</p>
                            <p>Status Pembayaran: <span
                                    class="font-semibold">{{ ucfirst($payment->payment_status) }}</span></p>
                            <p>Tanggal Pembayaran: {{ $payment->payment_date->format('d M Y, H:i') }}</p>
                        </div>
                        @if ($payment->transaction_id)
                            <p class="text-sm text-gray-700">ID Transaksi: {{ $payment->transaction_id }}</p>
                        @endif
                        <hr class="my-2">
                    @endforeach
                </div>
            @endif

            <div class="mt-6 text-right">
                <a href="{{ route('orders.index') }}"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Kembali ke Daftar Pesanan
                </a>
            </div>
        </div>
    </div>

    {{-- Script Midtrans Snap Pop-up --}}
    @if (isset($snapToken) && $order->status == 'pending')
        <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
        <script type="text/javascript">
            window.onload = function() {
                snap.pay('{{ $snapToken }}', {
                    onSuccess: function(result) {

                        alert("Pembayaran berhasil!");
                        window.location.href = "{{ route('midtrans.finish') }}?order_id={{ $order->id }}";
                    },
                    onPending: function(result) {

                        alert("Pembayaran tertunda!");
                        window.location.href =
                            "{{ route('midtrans.unfinish') }}?order_id={{ $order->id }}";
                    },
                    onError: function(result) {

                        alert("Pembayaran gagal!");
                        window.location.href = "{{ route('midtrans.error') }}?order_id={{ $order->id }}";
                    },
                    onClose: function() {

                        alert('Anda menutup pop-up tanpa menyelesaikan pembayaran.');

                    }
                });
            };
        </script>
    @endif
@endsection
