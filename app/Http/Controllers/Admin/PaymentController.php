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
            ->paginate(10);

        return view('dashboard.payment', compact('payments'));
    }
    public function show(Payment $payment)
    {

        $payment->load(['order.user', 'order.detailOrders.product']);


        $statuses = ['verify', 'completed', 'failed', 'refunded'];

        return view('dashboard.detailpayment', compact('payment', 'statuses'));
    }
    public function updateStatus(Request $request, Payment $payment)
    {
        $request->validate([

            'status' => 'required|string|in:verify,completed,failed,refunded',
        ]);

        // Perbarui status pembayaran
        $payment->payment_status = $request->input('status');

        // Simpan perubahan ke database
        $payment->save();

        // Redirect kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Status pembayaran berhasil diperbarui!');
    }
}
