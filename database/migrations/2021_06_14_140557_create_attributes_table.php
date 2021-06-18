<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->integer('increase_interval')->comment('minutes');
            $table->integer('decrease_interval')->comment('minutes');
            $table->tinyInteger('max_value')->default(100);
            $table->tinyInteger('min_value')->default(0);
            $table->tinyInteger('critical_value')->nullable();
            $table->tinyInteger('critical_interval')->nullable()->comment('minutes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attributes');
    }
}
