<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->string('product_name');
            $table->integer('price')->nullable();
            $table->integer('stock')->default(0);
            $table->bigInteger('barcode')->nullabe();
            $table->integer('purshase_price');
            $table->string('size')->nullable();
            $table->integer('sales')->default(0);
            $table->unsignedBigInteger('store_id');
            $table->foreign('store_id')->references('store_id')->on('stores');
            $table->integer('product_state')->default(1)->comment('1 = active | 0 = disable');
            $table->string('route_image')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
