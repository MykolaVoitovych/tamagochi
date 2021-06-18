<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributePetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_pet', function (Blueprint $table) {
            $table->id();
            $table->integer('pet_id');
            $table->integer('attribute_id');
            $table->integer('value');
            $table->timestamp('dt_increased');
            $table->timestamp('dt_decreased');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attribute_pet');
    }
}
