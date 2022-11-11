<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->unsignedBigInteger('role_id')->nullable();
            $table->unsignedBigInteger('store_id')->nullable();
            $table->foreign('role_id')->references('role_id')->on('roles');
            $table->foreign('store_id')->references('store_id')->on('stores');
            $table->integer('users_state')->default(1)->comment('1 = active | 0 = disable');
            /*$table->string('comercial_name');
            $table->string('propetiary_name');
            $table->string('email')->unique();
            $table->integer('phone');
            $table->integer('phone_secondary')->nullable();
            $table->string('password');
            $table->string('color')->nullable();
            $table->integer('state_suscription')->default(0)->comment('0 = Inactive | 1 = Active | 2 = Free');
            $table->unsignedBigInteger('business_type_id');
            $table->foreign('business_type_id')->references('business_type_id')->on('business_types');*/
            $table->string('auth_token')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
