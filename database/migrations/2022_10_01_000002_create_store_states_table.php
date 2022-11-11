<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('store_states', function (Blueprint $table) {
            $table->id('store_state_id');
            $table->string('name');
            $table->dateTime('date_end_at');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('store_states');
    }
};
