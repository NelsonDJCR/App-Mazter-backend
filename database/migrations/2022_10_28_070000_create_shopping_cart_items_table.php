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
        Schema::create('shopping_cart_items', function (Blueprint $table) {
            $table->id('shopping_cart_item_id');
            // $table->foreignId('product_id')->constrained('products');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');
            $table->integer('amount')->default(1);
            // $table->index('shopping_cart_id');
            // $table->foreign('shopping_cart_id')->references('shopping_cart_id')->on('shopping_carts')->onDelete('cascade');
            // $table->foreignId('shopping_cart_id')->constrained('shopping_carts');
            $table->unsignedBigInteger('shopping_cart_id');
            $table->foreign('shopping_cart_id')->references('shopping_cart_id')->on('shopping_carts')->onDelete('cascade');
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
        Schema::dropIfExists('shopping_cart_items');
    }
};
