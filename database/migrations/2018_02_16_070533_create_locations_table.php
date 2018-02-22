<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('countryId')->unsigned();
            $table->integer('regionId')->unsigned();
            $table->integer('cityId')->unsigned()->nullable();
            $table->integer('areaId')->unsigned()->nullable();
            $table->string('name');
            $table->string('address');
            $table->string('building');
            $table->string('timezone');
            $table->double('longitude');
            $table->double('latitude');
            $table->timestamps();
            $table->foreign('countryId')->references('id')->on('countries');
            $table->foreign('regionId')->references('id')->on('regions');
            $table->foreign('cityId')->references('id')->on('cities');
            $table->foreign('areaId')->references('id')->on('areas');
            $table->unique(['name', 'latitude', 'longitude']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locations');
    }
}
