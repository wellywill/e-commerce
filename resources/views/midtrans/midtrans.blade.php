@extends('layout.main') {{-- Sesuaikan dengan layout utama Anda --}}

@section('container')
    <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900 mb-8 text-center">Pembayaran Pesanan #{{ $order->id }}
        </h1>

        <div class="bg-white shadow-lg rounded-lg p-6 text-center">
            <p class="text-lg font-semibold text-gray-800 mb-4">Total yang harus dibayar:</p>
            <p class="text-4xl font-extrabold text-indigo-600 mb-8">Rp{{ number_format($order->total_price, 0, ',', '.') }}
            </p>

            <p class="text-gray-600 mb-6">Mohon selesaikan pembayaran Anda melalui metode yang tersedia.</p>

            <button id="pay-button"
                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                Bayar Sekarang
            </button>

            <p class="mt-6 text-sm text-gray-500">Anda akan diarahkan ke halaman pembayaran Midtrans.</p>
        </div>
    </div>

    {{-- Memuat library Snap.js dari Midtrans --}}
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function() {
            // Snap token diambil dari controller
            Snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    /* You may add your own implementation here */
                    alert("Pembayaran Berhasil!");
                    console.log(result);
                    window.location.href =
                        "{{ route('order.status', $order->id) }}"; // Redirect ke halaman sukses
                },
                onPending: function(result) {
                    /* You may add your own implementation here */
                    alert("Pembayaran Pending!");
                    console.log(result);
                    window.location.href =
                        "{{ route('order.pending', $order->id) }}"; // Redirect ke halaman pending
                },
                onError: function(result) {
                    /* You may add your own implementation here */
                    alert("Pembayaran Gagal!");
                    console.log(result);
                    window.location.href =
                        "{{ route('order.failed', $order->id) }}"; // Redirect ke halaman gagal
                },
                onClose: function() {
                    /* You may add your own implementation here */
                    alert('Anda menutup pop-up tanpa menyelesaikan pembayaran.');
                    window.location.href =
                        "{{ route('order.cancel', $order->id) }}"; // Redirect ke halaman pembatalan
                }
            });
        };
    </script>
@endsection
