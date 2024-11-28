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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_user');
            $table->enum('metode', ['manual', 'online']);
            $table->enum('status', ['dibayar', 'menunggu_dibayar', 'menunggu_konfirmasi', 'gagal']);
            $table->string('bukti_pembayaran');
            $table->date('tanggal');
            $table->date('total_harga');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
