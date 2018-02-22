<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('areas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('countryId')->unsigned();
            $table->integer('regionId')->unsigned();
            $table->integer('cityId')->unsigned()->nullable();
            $table->string('name');
            $table->timestamps();
            $table->foreign('countryId')->references('id')->on('countries');
            $table->foreign('regionId')->references('id')->on('regions');
            $table->foreign('cityId')->references('id')->on('cities');
            $table->unique(['name', 'countryId', 'regionId', 'cityId']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('areas');
    }
}
