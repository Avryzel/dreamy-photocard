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
        Schema::create('trx_detail_pesanan', function (Blueprint $table) {
            $table->id('idDetailPesanan');

            $table->foreignId('idPesanan')->constrained('trx_pesanan', 'idPesanan')->cascadeOnDelete();
            $table->foreignId('idPhotocard')->constrained('ms_photocard', 'idPhotocard')->cascadeOnDelete();
            
            $table->integer('jumlah');
            $table->decimal('harga_per_item', 10, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trx_detail_pesanan');
    }
};
