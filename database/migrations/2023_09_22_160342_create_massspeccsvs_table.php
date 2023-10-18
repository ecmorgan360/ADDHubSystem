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
        Schema::create('massspeccsvs', function (Blueprint $table) {
            $table->increments('csv_id');
            $table->unsignedInteger('massspec_id');
            $table->foreign('massspec_id')->references('massspec_id')->on('massspecs');
            $table->timestamps();
            $table->string('link_csv', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('massspeccsvs');
    }
};
