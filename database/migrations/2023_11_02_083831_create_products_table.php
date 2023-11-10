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
        Schema::create('products', function (Blueprint $table) {
            $table->increments('ma_sp');
            $table->unsignedInteger('ma_loai');
            $table->string('ten_sp')->unique();
            $table->string('donvi');
            $table->string('dongia');
            $table->timestamps();

            $table->foreign('ma_loai')->references('ma_loai')->on('type_product')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
