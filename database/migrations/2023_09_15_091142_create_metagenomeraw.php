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
        Schema::create('metagenomeraw', function (Blueprint $table) {
            $table->increments('metagenome_id');
            $table->timestamps();
            $table->string('supplier_id', 30);
            $table->string('link_bam', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('metagenomeraw');
    }
};
