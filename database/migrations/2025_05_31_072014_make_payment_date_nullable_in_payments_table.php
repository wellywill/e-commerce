<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            // Mengubah kolom payment_date agar bisa menerima NULL
            $table->timestamp('payment_date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            // LANGKAH PENTING: Sebelum mengubah ke NOT NULL,
            // isi semua nilai NULL di payment_date dengan nilai default (misal: waktu sekarang).
            // Ini mencegah error "Null value not allowed".
            DB::statement("UPDATE payments SET payment_date = NOW() WHERE payment_date IS NULL");

            // Sekarang, ubah kolom payment_date kembali menjadi NOT NULL.
            // Pastikan Anda juga menentukan nilai default jika memang sebelumnya ada default,
            // atau Laravel akan mengasumsikan tidak ada.
            // Jika sebelumnya tidak ada default, dan hanya NOT NULL, baris ini cukup:
            $table->dateTime('payment_date')->nullable(false)->change();

            // Jika sebelumnya ada default, misalnya default 'CURRENT_TIMESTAMP', Anda bisa coba:
            // $table->dateTime('payment_date')->nullable(false)->default(DB::raw('CURRENT_TIMESTAMP'))->change();
            // PENTING: Sesuaikan dengan kondisi kolom Anda sebelum migrasi 'up' ini dijalankan.
            // Default yang paling aman jika tidak yakin adalah NOW() seperti di DB::statement.
        });
    }
};
