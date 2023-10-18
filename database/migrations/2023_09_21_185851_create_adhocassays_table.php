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
        Schema::create('adhocassays', function (Blueprint $table) {
            $table->increments('adhoc_id');
            $table->string('pure_comp_id', 40);
            $table->foreign('pure_comp_id')->references('derivedpurecomp_id')->on('derivedpurecomps');
            $table->timestamps();
            $table->string('adhoc_type', 50);
            $table->string('link_report', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adhocassays');
    }
};
