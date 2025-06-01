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
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('payment_method')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            // LANGKAH PENTING: Sebelum mengubah ke NOT NULL,
            // isi semua nilai NULL di payment_method dengan nilai string default.
            DB::statement("UPDATE payments SET payment_method = 'unknown' WHERE payment_method IS NULL");

            // Sekarang, ubah kolom payment_method kembali menjadi NOT NULL.
            // Anda bisa tambahkan nilai default jika memang ada default sebelumnya
            // atau jika Anda ingin memiliki default saat kembali ke NOT NULL.
            $table->string('payment_method')->nullable(false)->change();

            // Contoh jika Anda ingin menetapkan default 'default_method' saat tidak nullable:
            // $table->string('payment_method')->nullable(false)->default('default_method')->change();
        });
    }
};
