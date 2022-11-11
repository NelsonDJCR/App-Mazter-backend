<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('suscriptions', function (Blueprint $table) {
            $table->id('suscription_id');
            $table->integer('months_duration');
            $table->integer('suscription_price');
            $table->integer('suscription_sales')->default(0);
            $table->integer('state_suscriptions')->default(1)->comment('1 = active | 0 = disable');
            $table->unsignedBigInteger('business_type_id');
            $table->foreign('business_type_id')->references('business_type_id')->on('business_types');
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down()
    {
        Schema::dropIfExists('suscriptions');
    }
};
