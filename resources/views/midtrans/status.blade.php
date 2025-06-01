@extends('layout.main') {{-- Sesuaikan dengan layout utama aplikasi Anda --}}

@section('container')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto bg-white shadow-lg rounded-lg p-8 text-center">
            @if ($payment_frontend_status == 'success')
                <svg class="mx-auto h-20 w-20 text-green-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h1 class="text-3xl font-bold text-green-700 mb-4">Pembayaran Berhasil!</h1>
                <p class="text-gray-700 text-lg">Terima kasih telah berbelanja! Pembayaran Anda untuk pesanan
                    **#{{ $order->id }}** telah berhasil diterima.</p>
                <p class="text-gray-600 mt-2">Pesanan Anda akan segera diproses.</p>
            @elseif($payment_frontend_status == 'pending')
                <svg class="mx-auto h-20 w-20 text-yellow-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h1 class="text-3xl font-bold text-yellow-700 mb-4">Pembayaran Menunggu!</h1>
                <p class="text-gray-700 text-lg">Pembayaran Anda untuk pesanan **#{{ $order->id }}** sedang menunggu
                    konfirmasi.</p>
                <p class="text-gray-600 mt-2">Mohon selesaikan pembayaran sesuai instruksi yang diberikan oleh Midtrans.</p>
            @elseif($payment_frontend_status == 'failed')
                <svg class="mx-auto h-20 w-20 text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h1 class="text-3xl font-bold text-red-700 mb-4">Pembayaran Gagal!</h1>
                <p class="text-gray-700 text-lg">Maaf, pembayaran Anda untuk pesanan **#{{ $order->id }}** gagal.</p>
                <p class="text-gray-600 mt-2">Silakan coba lagi atau hubungi dukungan pelanggan kami.</p>
            @else
                {{-- cancelled / closed --}}
                <svg class="mx-auto h-20 w-20 text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636">
                    </path>
                </svg>
                <h1 class="text-3xl font-bold text-gray-700 mb-4">Pembayaran Dibatalkan!</h1>
                <p class="text-gray-700 text-lg">Anda telah membatalkan atau menutup proses pembayaran untuk pesanan
                    **#{{ $order->id }}**.</p>
                <p class="text-gray-600 mt-2">Anda bisa mencoba melakukan pembayaran lagi jika ingin melanjutkan pesanan
                    ini.</p>
            @endif

            <div class="mt-8">
                <a href="{{ route('orders.show', $order->id) }}"
                    class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Lihat Detail Pesanan
                </a>
                <a href="{{ route('home') }}"
                    class="ml-4 inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
@endsection
