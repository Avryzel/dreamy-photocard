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
        Schema::create('trx_pesanan', function (Blueprint $table) {
            $table->id('idPesanan');

            $table->foreignId('idUser')->constrained('users', 'id');
            
            $table->timestamp('tanggal_pemesanan')->useCurrent();
            $table->decimal('total_harga', 10, 2);
            $table->string('nomor_resi')->nullable();
            $table->enum('status_pesanan', ['PERMINTAAN', 'DIPROSES', 'DIKIRIM', 'SELELESAI', 'DIBATALKAN'])->default('PERMINTAAN');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trx_pesanan');
    }
};
