<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('shopping_cart_items', function (Blueprint $table) {
            $table->id('shopping_cart_item_id');
            $table->integer('amount')->default(1);
            $table->integer('price')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('shopping_cart_id');
            $table->foreign('product_id')->references('product_id')->on('products');
            $table->foreign('shopping_cart_id')->references('shopping_cart_id')->on('shopping_carts');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shopping_cart_items');
    }
};
