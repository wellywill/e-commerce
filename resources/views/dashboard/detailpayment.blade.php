@extends('layout.main') {{-- Pastikan ini menunjuk ke layout utama admin Anda --}}

@section('container') {{-- Sesuaikan dengan nama section content di layout.admin Anda --}}
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900 mb-8 text-center">Detail Pembayaran #{{ $payment->id }}
        </h1>

        {{-- Pesan sukses atau error --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Sukses!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Oops!</strong>
                <span class="block sm:inline">Ada beberapa masalah dengan input Anda:</span>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Informasi Umum Pembayaran --}}
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-8">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Informasi Pembayaran</h3>
            </div>
            <div class="border-t border-gray-200">
                <dl>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">ID Pembayaran</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">#{{ $payment->id }}</dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">ID Pesanan Terkait</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <a href="{{ route('admin.orders.show', $payment->order->id) }}"
                                class="text-indigo-600 hover:text-indigo-900">
                                #{{ $payment->order->id }}
                            </a>
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Nama Pelanggan</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $payment->order->user->name ?? 'Tamu' }}</dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Email Pelanggan</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $payment->order->user->email ?? '-' }}</dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Tanggal Pembayaran</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $payment->payment_date ? $payment->payment_date->format('d M Y, H:i') : '-' }}
                        </dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Metode Pembayaran</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $payment->payment_method ?? '-' }}
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">ID Transaksi</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $payment->transaction_id ?? '-' }}
                        </dd>
                    </div>

                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Status Pembayaran</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if ($payment->payment_status == 'completed') bg-green-100 text-green-800
                                @elseif ($payment->payment_status == 'pending') bg-yellow-100 text-yellow-800
                                @elseif ($payment->payment_status == 'failed') bg-red-100 text-red-800
                                @elseif ($payment->payment_status == 'refunded') bg-pink-100 text-pink-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($payment->payment_status) }}
                            </span>
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Bukti Pembayaran</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            @if ($payment->proof_of_payment)
                                <a href="{{ asset('storage/' . $payment->proof_of_payment) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $payment->proof_of_payment) }}" alt="Bukti Pembayaran"
                                        class="max-w-xs h-auto rounded-md shadow-sm mt-1 border border-gray-200">
                                </a>
                                <p class="mt-2 text-xs text-gray-500">Klik gambar untuk melihat ukuran penuh.</p>
                            @else
                                <p class="text-gray-500">Tidak ada bukti pembayaran terunggah.</p>
                            @endif
                        </dd>
                    </div>

                    {{-- BAGIAN UPDATE STATUS SAJA --}}
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Perbarui Status Pembayaran</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <form action="{{ route('admin.payments.updateStatus', $payment->id) }}" method="POST">
                                {{-- enctype dihapus karena tidak ada file upload --}}
                                @csrf
                                @method('PUT')
                                <select name="status" id="status"
                                    class="block w-full sm:w-auto mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    @foreach ($statuses as $statusOption)
                                        <option value="{{ $statusOption }}"
                                            {{ $payment->payment_status == $statusOption ? 'selected' : '' }}>
                                            {{ ucfirst($statusOption) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror

                                <button type="submit"
                                    class="mt-3 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Update Status
                                </button>
                            </form>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        {{-- Ini adalah bagian Detail Produk jika Anda ingin menampilkan detail produk dari ORDER terkait --}}
        {{-- Hati-hati: Pastikan Anda memang ingin menampilkan ini di detail pembayaran, karena umumnya ini ada di detail pesanan --}}
        @if ($payment->order->detailOrders->isNotEmpty())
            <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-8">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Produk dalam Pesanan #{{ $payment->order->id }}
                    </h3>
                </div>
                <div class="border-t border-gray-200">
                    <ul role="list" class="divide-y divide-gray-200">
                        @foreach ($payment->order->detailOrders as $item)
                            <li class="flex py-6 px-4 sm:px-6">
                                <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                                    <img src="{{ asset('storage/' . $item->product->image_product) }}"
                                        alt="{{ $item->product->product_name }}"
                                        class="h-full w-full object-cover object-center">
                                </div>

                                <div class="ml-4 flex flex-1 flex-col">
                                    <div>
                                        <div class="flex justify-between text-base font-medium text-gray-900">
                                            <h3><a
                                                    href="{{ route('products.show', $item->product->id) }}">{{ $item->product->product_name }}</a>
                                            </h3>
                                            <p class="ml-4">
                                                Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                            </p>
                                        </div>
                                        <p class="mt-1 text-sm text-gray-500">Kuantitas: {{ $item->quantity }}</p>
                                        @if ($item->color)
                                            <p class="mt-1 text-sm text-gray-500">Warna: {{ $item->color }}</p>
                                        @endif
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="mt-8 text-center">
            <a href="{{ route('admin.payments.index') }}" class="font-medium text-indigo-600 hover:text-indigo-500">&larr;
                Kembali ke Daftar Pembayaran</a>
        </div>


    </div>
@endsection
