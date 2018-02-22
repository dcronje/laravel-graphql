<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('countryId')->unsigned();
            $table->integer('regionId')->unsigned();
            $table->string('name');
            $table->timestamps();
            $table->foreign('countryId')->references('id')->on('countries');
            $table->foreign('regionId')->references('id')->on('regions');
            $table->unique(['name', 'countryId', 'regionId']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
}
