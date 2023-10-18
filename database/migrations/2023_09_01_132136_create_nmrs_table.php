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
        Schema::create('nmrs', function (Blueprint $table) {
            $table->increments('nmr_id');
            $table->string('process_id', 30);
            $table->foreign('process_id')->references('process_id')->on('processes');
            $table->date('date_requested')->nullable();
            $table->boolean('cancelled');
            $table->string('link_folder', 100)->nullable();
            $table->date('date_submitted')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nmrs');
    }
};
