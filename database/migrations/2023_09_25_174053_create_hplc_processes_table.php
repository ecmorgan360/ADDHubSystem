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
        Schema::create('hplc_processes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedInteger('hplc_id');
            $table->foreign('hplc_id')->references('hplc_id')->on('hplcs');
            $table->string('process_id', 30);
            $table->foreign('process_id')->references('process_id')->on('processes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hplc_processes');
    }
};
