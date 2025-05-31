<?php

namespace App\Http\Controllers;

use App\Models\Order; // Import Model Order
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Untuk mendapatkan ID user yang sedang login

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
}
