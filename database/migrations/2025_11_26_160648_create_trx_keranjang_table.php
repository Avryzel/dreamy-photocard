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
        Schema::create('trx_keranjang', function (Blueprint $table) {
            $table->id('idKeranjang');
            $table->foreignId('idUser')->constrained('users', 'id');
            $table->foreignId('idPhotocard')->constrained('ms_photocard', 'idPhotocard')->cascadeOnDelete();

            $table->integer('jumlah_item')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trx_keranjang');
    }
};
