<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id('store_id');
            $table->string('business_name');
            $table->string('propetiary_name');
            $table->string('address');
            $table->string('store_phone');
            $table->integer('store_phone_secondary')->nullable();
            $table->unsignedBigInteger('store_state_id');
            $table->foreign('store_state_id')->references('store_state_id')->on('store_states')->onDelete('cascade');
            $table->string('picture_business');
            $table->string('city');
            $table->unsignedBigInteger('business_type_id');
            $table->foreign('business_type_id')->references('business_type_id')->on('business_types');
            // Settings
            $table->string('logo');
            $table->string('color_primary')->default('#FF0080');
            $table->string('color_secondary')->default('#FFFFFF');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stores');
    }
};
