<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('model',191);
            $table->string('brand',191);
            $table->string('color',191);
            $table->string('agency',191);
            $table->string('agency_name',191);
            $table->boolean('isava');
            $table->dateTime('rent_start');
            $table->dateTime('rent_end');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cars');
    }
}
