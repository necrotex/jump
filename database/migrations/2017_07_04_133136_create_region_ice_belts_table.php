<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegionIceBeltsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('region_ice_belts', function (Blueprint $table) {
            $table->integer('regionID');
            $table->integer('typeID');
            $table->float('maxSecurity');
            $table->float('minSecurity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('region_ice_belts');
    }
}
