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
        Schema::create('transaction', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->integer('id_user');
            $table->string('invoice');
            $table->bigInteger('total_price');
            $table->integer('status');
            $table->text('note')->nullable();
            $table->timestamps();
            $table->datetime('payment_date')->nullable();

            $table->foreign('id_user')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction');
    }
};
