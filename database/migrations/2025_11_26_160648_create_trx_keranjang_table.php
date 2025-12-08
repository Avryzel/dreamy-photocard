<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trx_keranjang', function (Blueprint $table) {
            $table->id('idKeranjang');

            $table->unsignedBigInteger('idUser');      
            $table->unsignedBigInteger('idPhotocard');
            
            $table->integer('jumlah_item'); 

            $table->foreign('idUser')
                  ->references('idUser')
                  ->on('Ms_User')
                  ->onDelete('cascade');

            $table->foreign('idPhotocard')
                  ->references('idPhotocard') 
                  ->on('Ms_Photocard') 
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trx_keranjang');
    }
};