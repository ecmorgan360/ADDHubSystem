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
        Schema::create('hplcs', function (Blueprint $table) {
            $table->increments('hplc_id');
            $table->timestamps();
            $table->string('link_uvtrace', 100);
            $table->string('link_report', 100);
            $table->string('diluent', 50);
            $table->date('date_submitted');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hplcs');
    }
};
