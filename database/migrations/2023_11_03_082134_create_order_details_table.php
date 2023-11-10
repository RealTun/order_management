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
        Schema::create('order_details', function (Blueprint $table) {
            $table->unsignedInteger('ma_hoadon');
            $table->unsignedInteger('ma_sp');
            $table->unsignedInteger('soluong');

            $table->foreign('ma_hoadon')->references('ma_hoadon')->on('orders')->onDelete('cascade');
            $table->foreign('ma_sp')->references('ma_sp')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
