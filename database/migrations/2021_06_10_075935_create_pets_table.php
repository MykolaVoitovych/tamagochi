<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->integer('food');
            $table->integer('sleep');
            $table->integer('care');
            $table->integer('fun');
            $table->integer('user_id');
            $table->timestamp('food_at');
            $table->timestamp('sleep_at');
            $table->timestamp('care_at');
            $table->timestamp('fun_at');
            $table->timestamp('lower_food_at');
            $table->timestamp('lower_sleep_at');
            $table->timestamp('lower_care_at');
            $table->timestamp('lower_fun_at');
            $table->boolean('is_died');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pets');
    }
}
