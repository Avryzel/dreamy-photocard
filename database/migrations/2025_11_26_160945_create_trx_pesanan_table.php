<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trx_pesanan', function (Blueprint $table) {
            $table->id('idPesanan');

            $table->unsignedBigInteger('idUser');
            
            $table->foreign('idUser')
                  ->references('idUser')
                  ->on('Ms_User')
                  ->onDelete('cascade');
            $table->dateTime('tanggal_pemesanan')->useCurrent();
            $table->decimal('total_harga', 10, 2);
            $table->string('nomor_resi')->nullable(); 
            
            $table->enum('status_pesanan', [
                'PERMINTAAN', 
                'DIPROSES', 
                'DIKIRIM', 
                'SELESAI', 
                'DIBATALKAN'
            ])->default('PERMINTAAN');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trx_pesanan');
    }
};