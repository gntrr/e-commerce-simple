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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // format INV-XXXXXX
            $table->string('product_sku');
            $table->string('product_name');
            $table->unsignedInteger('price'); // rupiah
            $table->unsignedInteger('qty')->default(1);
            $table->string('customer_name');
            $table->string('phone');
            $table->text('address');
            $table->enum('status', ['pending', 'done', 'canceled'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
