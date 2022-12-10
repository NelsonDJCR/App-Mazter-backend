<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('shopping_carts', function (Blueprint $table) {
            $table->id('shopping_cart_id');
            $table->unsignedBigInteger('store_id');
            $table->foreign('store_id')->references('store_id')->on('stores');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('shopping_cart_state')->default(1)->comment('1 = active | 0 = disable');
            $table->integer('cart')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shopping_carts');
    }
};
