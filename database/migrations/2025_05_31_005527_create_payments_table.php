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
        Schema::create('payments', function (Blueprint $table) {
            $table->id(); // Kolom ID otomatis (primary key, auto-increment)

            // Kolom untuk order_id (foreign key ke tabel 'orders')
            // Penting: Pastikan tabel 'orders' sudah ada atau migrasinya dijalankan sebelum migrasi 'payments'.
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            // 'onDelete('cascade')' berarti jika order dihapus, pembayaran terkait juga akan dihapus.

            $table->dateTime('payment_date'); // Tanggal dan waktu pembayaran
            $table->string('payment_method'); // Metode pembayaran (misal: 'Bank Transfer', 'Credit Card', 'E-wallet')
            $table->string('payment_status')->default('pending'); // Status pembayaran (misal: 'pending', 'completed', 'failed', 'refunded')

            $table->timestamps(); // Kolom created_at dan updated_at otomatis
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
