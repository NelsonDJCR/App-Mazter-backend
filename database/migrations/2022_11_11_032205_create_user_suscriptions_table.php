<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_suscriptions', function (Blueprint $table) {
            $table->id('user_suscription_id');
            $table->unsignedBigInteger('store_id');
            $table->foreign('store_id')->references('store_id')->on('stores');
            $table->unsignedBigInteger('suscription_id');
            $table->foreign('suscription_id')->references('suscription_id')->on('suscriptions');
            $table->unsignedBigInteger('payment_method_id');
            $table->foreign('payment_method_id')->references('payment_method_id')->on('payment_methods');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_suscriptions');
    }
};
