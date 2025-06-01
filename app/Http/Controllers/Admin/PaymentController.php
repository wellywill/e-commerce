<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['order.user'])
            ->orderBy('payment_date', 'desc')
            ->paginate(10); // Menampilkan 10 pembayaran per halaman

        return view('dashboard.payment', compact('payments'));
    }
    public function show(Payment $payment)
    {
        // Eager load relasi yang diperlukan untuk detail pembayaran dan ordernya,
        // termasuk user yang membuat order dan produk dalam detail order.
        $payment->load(['order.user', 'order.detailOrders.product']);

        // Definisikan daftar status pembayaran yang mungkin.
        // Pastikan ini sesuai dengan nilai yang Anda gunakan di database.
        $statuses = ['pending', 'completed', 'failed', 'refunded'];

        // Kirim objek $payment dan array $statuses ke tampilan 'admin.payments.show'.
        return view('dashboard.detailpayment', compact('payment', 'statuses'));
    }
    public function updateStatus(Request $request, Payment $payment)
    {
        $request->validate([
            // Validasi untuk status pembayaran baru saja
            'status' => 'required|string|in:pending,completed,failed,refunded',
        ]);

        // Perbarui status pembayaran
        $payment->payment_status = $request->input('status');

        // Simpan perubahan ke database
        $payment->save();

        // Redirect kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Status pembayaran berhasil diperbarui!');
    }
}
