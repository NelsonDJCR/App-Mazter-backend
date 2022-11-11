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
            $table->integer('campaing');
            $table->integer('month_price');
            $table->integer('trimester_price');
            $table->integer('semester_price');
            $table->integer('yearly_price');
            $table->integer('month_discount')->nullable();
            $table->integer('trimester_discount')->nullable();
            $table->integer('semester_discount')->nullable();
            $table->integer('yearly_discount')->nullable();
            $table->unsignedBigInteger('business_type_id');
            $table->foreign('business_type_id')->references('business_type_id')->on('business_type');
            $table->integer('sales')->default(0);
            $table->integer('state_suscriptions')->default(1)->comment('1 = active | 0 = disable');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('suscriptions');
    }
};
