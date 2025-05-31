<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detail_orders', function (Blueprint $table) {
            $table->id(); // Kolom ID otomatis (primary key, auto-increment)

            // Kolom untuk order_id (foreign key ke tabel 'orders')
            // Penting: Pastikan tabel 'orders' sudah ada.
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            // 'onDelete('cascade')' berarti jika order dihapus, detail ordernya juga akan dihapus.

            // Kolom untuk product_id (foreign key ke tabel 'products')
            // Penting: Pastikan tabel 'products' sudah ada.
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            // 'onDelete('cascade')' berarti jika produk dihapus, entri detail ordernya juga akan dihapus.
            $table->string('color')->nullable();
            $table->integer('quantity'); // Jumlah produk dalam pesanan
            $table->integer('price');    // Harga produk per unit saat pesanan dibuat (penting untuk menjaga harga historis)

            $table->timestamps(); // Kolom created_at dan updated_at otomatis
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_orders');
    }
};
