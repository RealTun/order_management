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
        Schema::create('type_product', function (Blueprint $table) {
            $table->increments('ma_loai');
            $table->unsignedInteger('ma_ncc');
            $table->string('ten_loai');
            $table->timestamps();

            $table->foreign('ma_ncc')->references('ma_ncc')->on('providers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_product');
    }
};
