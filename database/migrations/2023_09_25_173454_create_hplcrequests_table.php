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
        Schema::create('hplcrequests', function (Blueprint $table) {
            $table->string('process_id', 30)->primary();
            $table->foreign('process_id')->references('process_id')->on('processes');
            $table->timestamps();
            $table->boolean('cancelled');
            $table->date('date_requested');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hplcrequests');
    }
};
