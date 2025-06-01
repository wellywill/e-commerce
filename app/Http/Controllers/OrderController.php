<?php

namespace App\Http\Controllers;

use App\Models\Order; // Import Model Order
use App\Models\Payment;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Untuk mendapatkan ID user yang sedang login
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Snap;

class OrderController extends Controller
{

    public function index()
    {

        if (!Auth::check()) {

            return redirect()->route('login')->with('error', 'Anda harus login untuk melihat pesanan Anda.');
        }

        $userId = Auth::id();

        $orders = Order::where('user_id', $userId) // Filter pesanan berdasarkan user_id
            ->with(['detailOrders.product', 'payments']) // Eager load relasi 'detailOrders' (dengan produknya) dan 'payments'
            ->orderBy('order_date', 'desc') // Urutkan dari yang terbaru
            ->get();
        return view('order.order', compact('orders'));
    }


    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }


        $order->load(['detailOrders.product', 'payments', 'user']);

        return view('order.show', compact('order'));
    }

    // Fungsi untuk menginisiasi pembayaran Midtrans
    public function payWithMidtrans(Order $order)
    {


        // Pastikan hanya pemilik order yang bisa menginisiasi pembayaran
        if ($order->user_id !== Auth::id()) {

            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk memproses pesanan ini.');
        }

        // Pastikan order masih dalam status 'pending'
        if ($order->status !== 'pending') {

            return redirect()->back()->with('error', 'Pesanan ini tidak bisa dibayar karena statusnya bukan pending.');
        }

        // Load relasi detailOrders dan produk di dalamnya
        $order->load('detailOrders.product');


        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.serverKey'); // Perbaikan: Gunakan server_key
        Config::$isProduction = config('midtrans.isProduction'); // Perbaikan: Gunakan is_production
        Config::$isSanitized = config('midtrans.isSanitized'); // Perbaikan: Gunakan is_sanitized
        Config::$is3ds = config('midtrans.is3ds'); // Perbaikan: Gunakan is_3ds


        // Detail Transaksi
        $transaction_details = [
            'order_id'     => $order->id, // Penting: tambahkan uniqid() untuk menghindari duplikasi Order ID
            'gross_amount' => (int)$order->total_price, // Pastikan gross_amount adalah integer
        ];



        // Detail Pelanggan
        $customer_details = [
            'first_name'   => Auth::user()->name,
            'email'        => Auth::user()->email,
        ];


        // Item Detail (opsional, tapi disarankan)
        $item_details = [];
        // Pastikan $order->detailOrders tidak kosong sebelum foreach
        if ($order->detailOrders->isEmpty()) {
            Log::error('payWithMidtrans: No items found in order for Order ID: ' . $order->id);
            return redirect()->back()->with('error', 'Keranjang Anda kosong, tidak bisa checkout.');
        }

        foreach ($order->detailOrders as $detail) {
            // Pastikan 'product' relasi ada
            if (!$detail->product) {
                return redirect()->back()->with('error', 'Beberapa produk dalam pesanan tidak ditemukan. Harap hubungi admin.');
            }
            $item_details[] = [
                'id'       => $detail->product->id,
                'price'    => (int)$detail->price,
                'quantity' => (int)$detail->quantity,
                'name'     => $detail->product->product_name, // Pastikan ini product_name atau name
                'category' => 'Product',
                'merchant_name' => 'Nama Toko Anda', // Ganti dengan nama toko Anda
            ];
        }
        $params = [
            'transaction_details' => $transaction_details,
            'customer_details'    => $customer_details,
            'item_details'        => $item_details,
            'callbacks' => [
                'finish' => route('midtrans.finish'),
                'unfinish' => route('midtrans.unfinish'),
                'error' => route('midtrans.error'),
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return view('order.show', compact('order', 'snapToken'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menginisiasi pembayaran: ' . $e->getMessage());
        }
    }

    public function midtransCallback(Request $request)
    {
        Log::info('Midtrans callback received:', $request->all()); // Log seluruh payload

        // Konfigurasi Midtrans Server Key
        // Pastikan Anda sudah mengaturnya di config/midtrans.php atau config/services.php
        Config::$serverKey = config('midtrans.serverKey'); // Atau config('services.midtrans.server_key')
        Config::$isProduction = config('midtrans.isProduction'); // Sesuaikan dengan env Anda

        try {
            $notif = new Notification();
        } catch (Exception $e) { // Tangkap Exception umum
            Log::error('Error creating Midtrans Notification object: ' . $e->getMessage());
            return response('Error processing notification', 500);
        }

        $transactionStatus = $notif->transaction_status;
        $orderIdMidtrans = $notif->order_id;
        $fraudStatus = $notif->fraud_status;
        $paymentType = $notif->payment_type;
        $grossAmount = $notif->gross_amount; // Ambil gross_amount dari notif
        $transactionId = $notif->transaction_id; // Ambil transaction_id dari notif
        $paymentTime = $notif->transaction_time; // Waktu transaksi dari Midtrans

        // Midtrans kadang mengirim order_id dengan suffix, pisahkan untuk mendapatkan order ID asli Anda
        $originalOrderId = explode('-', $orderIdMidtrans)[0];
        $order = Order::find($originalOrderId);

        if (!$order) {
            Log::error('Order not found for Midtrans callback with ID: ' . $originalOrderId);
            return response('Order not found', 404);
        }

        Log::info("Processing Midtrans callback for Order ID #{$order->id} (Midtrans transaction ID: {$orderIdMidtrans}) - Status: {$transactionStatus}, Fraud: {$fraudStatus}");

        $newOrderStatus = $order->status; // Default: status tidak berubah
        $newPaymentStatus = null; // Default: status pembayaran belum ditentukan

        // Logic berdasarkan status transaksi Midtrans
        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            if ($fraudStatus == 'challenge') {
                $newOrderStatus = 'pending_verification'; // Pesanan memerlukan verifikasi karena terindikasi fraud
                $newPaymentStatus = 'challenge';
                Log::info("Order #{$order->id} status set to 'pending_verification' (fraud challenge).");
            } else if ($fraudStatus == 'accept') {
                // Pembayaran diterima, set status order ke 'processed'
                $newOrderStatus = 'processed';
                // Status pembayaran awal juga 'verification_required'
                $newPaymentStatus = 'verification_required';
                Log::info("Order #{$order->id} status updated to 'processed'.");
                Log::info("Payment for Order #{$order->id} status set to 'verification_required'.");
            }
        } elseif ($transactionStatus == 'pending') {
            // Pembeli belum membayar atau menunggu konfirmasi pembayaran
            $newOrderStatus = 'pending_payment'; // Misal, order tetap pending
            $newPaymentStatus = 'pending';
            Log::info("Order #{$order->id} status set to 'pending_payment'.");
            Log::info("Payment for Order #{$order->id} status set to 'pending'.");
        } elseif ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
            // Pembayaran ditolak, kadaluarsa, atau dibatalkan
            $newOrderStatus = 'cancelled';
            $newPaymentStatus = 'failed';
            Log::info("Order #{$order->id} status set to 'cancelled' due to '{$transactionStatus}'.");
        }

        // Hanya perbarui status order jika memang ada perubahan
        if ($newOrderStatus !== $order->status) {
            $order->status = $newOrderStatus;
            $order->save();
            Log::info("Order #{$order->id} status saved as '{$order->status}'.");
        } else {
            Log::info("Order #{$order->id} status remains '{$order->status}'.");
        }

        // Buat atau perbarui catatan pembayaran
        // Gunakan updateOrCreate untuk menghindari duplikasi jika callback terkirim berkali-kali
        if ($newPaymentStatus) { // Pastikan ada status pembayaran yang akan diatur
            try {
                Log::info("Attempting to create/update Payment record for Order #{$order->id}...");
                Payment::updateOrCreate(
                    ['order_id' => $order->id], // Cari berdasarkan order_id
                    [
                        'transaction_id' => $transactionId, // Dari notifikasi Midtrans
                        'payment_method' => $paymentType,
                        'amount' => str_replace('.00', '', $grossAmount), // Hapus .00 jika ada
                        'payment_date' => \Carbon\Carbon::parse($paymentTime), // Ubah string waktu ke objek Carbon
                        'payment_status' => $newPaymentStatus,
                        'raw_response' => json_encode($request->all()), // Simpan raw response
                    ]
                );
                Log::info("Payment record created/updated successfully for Order #{$order->id}.");
            } catch (\Illuminate\Database\QueryException $e) {
                Log::error('Database Error creating/updating Payment record: ' . $e->getMessage() . ' - Query: ' . $e->getSql() . ' - Bindings: ' . json_encode($e->getBindings()));
                return response('Database error processing payment record', 500);
            } catch (Exception $e) {
                Log::error('General Error creating/updating Payment record: ' . $e->getMessage());
                return response('Error processing payment record', 500);
            }
        } else {
            Log::warning("No new payment status determined for Order #{$order->id}. Payment record might not be updated.");
        }


        return response('OK', 200); // Penting: Selalu balas dengan HTTP 200 OK untuk Midtrans
    }
    // Redirect URLs (hanya untuk tampilan browser, status update harus via callback)
    public function midtransFinish(Request $request)
    {
        $orderId = $request->input('order_id');
        $order = Order::find($orderId);
        if ($order) {
            return redirect()->route('orders.show', $order->id)->with('success', 'Pembayaran berhasil dikonfirmasi. Mohon tunggu verifikasi.');
        }
        return redirect()->route('orders.index')->with('success', 'Pembayaran berhasil. Silakan cek status pesanan Anda.');
    }

    public function midtransUnfinish(Request $request)
    {
        $orderId = $request->input('order_id');
        $order = Order::find($orderId);
        if ($order) {
            return redirect()->route('orders.show', $order->id)->with('error', 'Pembayaran belum selesai. Silakan coba lagi.');
        }
        return redirect()->route('orders.index')->with('error', 'Pembayaran belum selesai.');
    }

    public function midtransError(Request $request)
    {
        $orderId = $request->input('order_id');
        $order = Order::find($orderId);
        if ($order) {
            return redirect()->route('orders.show', $order->id)->with('error', 'Pembayaran gagal. Silakan coba lagi.');
        }
        return redirect()->route('orders.index')->with('error', 'Pembayaran gagal.');
    }
}
