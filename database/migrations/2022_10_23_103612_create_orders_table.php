<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->foreignId('user_id')->nullable()
                ->constrained()
                ->nullonDelete();

            $table->foreignId('product_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('store_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->enum('status', [
                'pending',
                'processing',
                'delivering',
                'completed',
                'canceled',
                'refunded',
                'failed',
            ])->default('pending');

            $table->enum('payment_status', [
                'pending',
                'paid',
                'failed',
            ])->default('pending');

            $table->enum('payment_method', [
                'cash',
                'card',
                'paypal',
                'stripe',
                'bitcoin',
            ])->default('cash');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
