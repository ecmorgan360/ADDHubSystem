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
        Schema::create('sites', function (Blueprint $table) {
            $table->increments('site_id');
            $table->timestamps();
            $table->unsignedInteger('station_id');
            $table->foreign('station_id')->references('station_id')->on('stations');
            $table->decimal('latitude', 8, 6);
            $table->decimal('longitude', 9, 6);
            $table->integer('depth_min')->unsigned();
            $table->integer('depth_max')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sites');
    }
};
