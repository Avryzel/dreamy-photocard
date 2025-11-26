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
        Schema::create('ms_photocard', function (Blueprint $table) {
            $table->id('idPhotocard');
            $table->foreignId('idGroupBand')->constrained('ms_grup_band', 'idGroupBand')->cascadeOnDelete();

            $table->string('nama_pc');
            $table->text('deskripsi_pc')->nullable();
            $table->integer('stock_pc')->default(0);
            $table->decimal('harga_pc', 10, 2);
            $table->string('foto_pc')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms_photocard');
    }
};
