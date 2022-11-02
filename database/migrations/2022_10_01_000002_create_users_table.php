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
        Schema::create('users', function (Blueprint $table) {
            $table->id('id');
            $table->string('comercial_name');
            $table->string('propetiary_name');
            $table->string('email')->unique();
            $table->integer('phone');
            $table->integer('phone_secondary')->nullable();
            $table->string('password');
            $table->string('color')->nullable();
            $table->integer('state_suscription')->default(0)->comment('0 = Inactive | 1 = Active | 2 = Free');
            // $table->index('business_type_id');
            // $table->foreign('business_type_id')->references('business_type_id')->on('business_types')->onDelete('cascade');
            // $table->foreignId('business_type_id')->constrained();

            // $table->unsignedBigInteger('shopping_cart_id');
            $table->unsignedBigInteger('business_type_id');
            $table->foreign('business_type_id')->references('business_type_id')->on('business_types');
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
        Schema::dropIfExists('users');
    }
};
