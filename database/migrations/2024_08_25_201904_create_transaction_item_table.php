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
        Schema::create('transaction_item', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->unsignedBigInteger('id_product');
            $table->unsignedBigInteger('id_transaction');
            $table->integer('qty');
            $table->bigInteger('price');
            $table->integer('discounnt')->nullable();
            $table->bigInteger('total');
            $table->timestamps();

            $table->foreign('id_product')->references('id')->on('product');
            $table->foreign('id_transaction')->references('id')->on('transaction');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_item');
    }
};
