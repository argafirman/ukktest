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
        Schema::create('detailsuppliers', function (Blueprint $table) {
            $table->id('DetailID');
            $table->unsignedBigInteger('ProdukID');
            $table->integer('JumlahProduk');
            $table->decimal('TotalHarga', 10, 2);
            $table->string('NamaSupplier', 255);
            $table->foreign('ProdukID')->references('ProdukID')->on('produks');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detailsuppliers');
    }
};
