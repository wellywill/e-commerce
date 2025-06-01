@extends('layout.main') {{-- Pastikan ini menunjuk ke layout utama admin Anda --}}

@section('container')
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">Manajemen Pembayaran</h1>
            {{-- Tombol Kembali ke Dashboard --}}
            <a href="{{ route('dashboard') }}"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-md text-white bg-coklatmuda-100 hover:bg-coklattua focus:outline-none focus:ring-2 focus:ring-offset-2 ">
                Kembali ke Dashboard
            </a>
        </div>

        {{-- Bagian untuk menampilkan pesan sukses --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">Sukses!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Bagian ini akan menampilkan jika tidak ada pembayaran --}}
        @if ($payments->isEmpty())
            <div class="text-center text-gray-500 py-10">
                <p class="text-lg mb-4">Belum ada pembayaran yang tercatat.</p>
            </div>
        @else
            {{-- Tabel Daftar Pembayaran --}}
            <div class="overflow-x-auto shadow-sm sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID Pembayaran
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Pesanan ID
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Pelanggan
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal Pembayaran
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Jumlah
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Metode
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($payments as $payment)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #{{ $payment->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{-- Link ke detail pesanan jika Anda memiliki admin.orders.show --}}
                                    <a href="{{ route('admin.orders.show', $payment->order->id) }}"
                                        class="text-indigo-600 hover:text-indigo-900">
                                        #{{ $payment->order->id }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $payment->order->user->name ?? 'Guest' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $payment->payment_date ? $payment->payment_date->format('d M Y H:i') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    Rp{{ number_format($payment->order->total_price, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $payment->payment_method ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if ($payment->payment_status == 'completed') bg-green-100 text-green-800
                                        @elseif ($payment->payment_status == 'pending') bg-yellow-100 text-yellow-800
                                        @elseif ($payment->payment_status == 'failed') bg-red-100 text-red-800
                                        @elseif ($payment->payment_status == 'refunded') bg-pink-100 text-pink-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($payment->payment_status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    {{-- Link ke detail pembayaran untuk edit status --}}
                                    <a href="{{ route('admin.payments.show', $payment->id) }}"
                                        class="text-indigo-600 hover:text-indigo-900">Detail & Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Tautan Pagination --}}
            <div class="mt-6">
                {{ $payments->links() }}
            </div>
        @endif
    </div>
@endsection
