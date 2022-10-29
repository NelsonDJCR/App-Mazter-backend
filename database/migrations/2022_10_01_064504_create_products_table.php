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
            $table->id('product_id');
            $table->string('name');
            $table->integer('barcode')->nullable();
            $table->integer('price');
            $table->integer('discount')->default(0);
            $table->integer('sales')->default(0);
            $table->integer('stock')->default(0);
            $table->integer('amount_products')->default(0);
            $table->foreignId('user_id')->constrained('users');
            $table->integer('state')->default(1)->comment('1 = active | 0 = disable');
            $table->string('route_image')->nullable();
            $table->boolean('backup')->default(0);
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
