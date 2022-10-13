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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->foreignId('store_id')->constrained('stores')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->decimal('price', 8, 2)->default(0); // 999999.99
            $table->decimal('compare_price', 8, 2)->nullable();
            $table->integer('quantity')->default(0);
            $table->json('options')->nullable();
            $table->decimal('rating', 2, 1)->default(0);
            $table->boolean('featured')->default(false);
            $table->enum('status', ['active', 'draft', 'archived'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
