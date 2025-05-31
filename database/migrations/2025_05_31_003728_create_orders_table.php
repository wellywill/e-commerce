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
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); // Kolom ID otomatis (primary key, auto-increment)

            // Kolom untuk user_id (foreign key ke tabel 'users')
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // 'constrained('users')' mengindikasikan foreign key ke tabel 'users'.
            // 'onDelete('cascade')' berarti jika user dihapus, semua ordernya juga akan dihapus.
            // Anda bisa mengubahnya menjadi 'onDelete('set null')' jika ingin user_id menjadi null.

            $table->dateTime('order_date'); // Mengubah dari date menjadi dateTime
            $table->integer('total_price'); // Total harga pesanan (10 digit total, 2 di belakang koma)
            $table->string('status')->default('pending'); // Status pesanan (misal: pending, completed, cancelled, processing)
            $table->text('shipping_address'); // Alamat pengiriman lengkap

            $table->timestamps(); // Kolom created_at dan updated_at otomatis
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
