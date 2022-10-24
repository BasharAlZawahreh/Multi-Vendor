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
        Schema::create('order_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->enum('type',['billing','shipping']);
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone_number');
            $table->string('email');
            $table->string('street_address');
            $table->string('city');
            $table->string('state')->nullable();
            $table->char('country',2);
            $table->string('zip_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_addresses');
    }
};
