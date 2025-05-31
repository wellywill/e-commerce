<?php

namespace App\Http\Controllers;

use App\Models\DetailOrder;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []); // Mengambil data keranjang dari session
        return view('cart.cart', compact('cart')); // Meneruskan data ke view
    }
    public function add(Request $request, Product $product)
    {
        // Validasi input (opsional tapi disarankan)
        $request->validate([
            'color' => 'required|string',
        ]);

        $selectedColor = $request->input('color');

        $cart = Session::get('cart', []);

        $cartItemId = $product->id . '-' . str_replace(' ', '', $selectedColor);

        if (isset($cart[$cartItemId])) {
            // Jika produk dengan warna yang sama sudah ada, tambahkan kuantitasnya
            $cart[$cartItemId]['quantity']++;
        } else {
            // Jika produk dengan warna tersebut belum ada, tambahkan sebagai item baru
            $cart[$cartItemId] = [
                "product_id" => $product->id,
                "product_name" => $product->product_name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image_product,
                "color" => $selectedColor
            ];
        }

        Session::put('cart', $cart);

        return redirect()->back()->with('success', 'Produk ' . $product->product_name . ' (' . $selectedColor . ') berhasil ditambahkan ke keranjang!');
    }
    public function remove($cartItemId)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$cartItemId])) {
            unset($cart[$cartItemId]);
            Session::put('cart', $cart);
            return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang.');
        }

        return redirect()->back()->with('error', 'Produk tidak ditemukan di keranjang.');
    }

    /**
     * Mengupdate kuantitas produk di keranjang.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $cartItemId // Ubah dari int $productId menjadi string $cartItemId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $cartItemId) // Sesuaikan parameter di sini
    {
        $request->validate([
            'quantity' => 'required|numeric|min:1',
        ]);

        $cart = Session::get('cart', []);

        if (isset($cart[$cartItemId])) {
            $cart[$cartItemId]['quantity'] = $request->quantity;
            Session::put('cart', $cart);
            return redirect()->back()->with('success', 'Kuantitas produk berhasil diperbarui.');
        }

        return redirect()->back()->with('error', 'Produk tidak ditemukan di keranjang.');
    }

    public function showCheckoutForm()
    {

        $cart = Session::get('cart');
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong, tidak bisa checkout.');
        }

        $user = Auth::user();

        $total = 0;
        foreach ($cart as $details) {
            $total += $details['price'] * $details['quantity'];
        }

        return view('checkout.checkout', compact('cart', 'total', 'user'));
    }

    public function processCheckout(Request $request)
    {
        // Validasi data yang masuk dari form checkout
        $request->validate([
            'shipping_address' => 'required|string|max:255',
            'payment_method' => 'required|string|in:Bank Transfer,Credit Card,E-wallet',

        ]);

        $cart = Session::get('cart');
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        // Hitung total harga dari keranjang
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        // 1. Buat entri di tabel 'orders'
        $order = Order::create([
            'user_id' => Auth::id(),
            'order_date' => now(),
            'total_price' => $totalPrice,
            'status' => 'pending',
            'shipping_address' => $request->input('shipping_address'),

        ]);

        // 2. Buat entri di tabel 'detail_orders' untuk setiap item di keranjang
        foreach ($cart as $cartItemId => $details) {
            DetailOrder::create([
                'order_id' => $order->id,
                'product_id' => $details['product_id'],
                'quantity' => $details['quantity'],
                'price' => $details['price'],
                'color' => $details['color'] ?? null,
            ]);
        }

        // 3. Buat entri di tabel 'payments'
        Payment::create([
            'order_id' => $order->id,
            'payment_date' => now(),
            'payment_method' => $request->input('payment_method'),
            'payment_status' => 'pending', // Status awal pembayaran
        ]);

        // 4. Hapus keranjang dari session setelah checkout berhasil
        Session::forget('cart');

        return redirect()->route('orders.show', $order->id)->with('success', 'Pesanan Anda berhasil dibuat!');
    }
}
