<?php

namespace App\Http\Controllers\Admin; // Penting: Pastikan namespace ini benar!

use App\Http\Controllers\Controller; // Jangan lupa import Controller base
use App\Models\Order; // Import model Order Anda
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public function index()
    {
        $orders = Order::with(['user', 'detailOrders.product', 'payments'])
            ->orderBy('order_date', 'desc')
            ->paginate(10);
        return view('dashboard.pesanan', compact('orders'));
    }

    /**
     * Menampilkan detail spesifik dari sebuah pesanan untuk admin.
     */
    public function show(Order $order)
    {
        $order->load(['user', 'detailOrders.product', 'payments']);
        return view('dashboard.detailpesanan', compact('order'));
    }

    /**
     * Mengupdate status pesanan.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string|in:pending,processing,shipped,completed,cancelled',
        ]);

        $order->status = $request->input('status');
        $order->save();

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
}
