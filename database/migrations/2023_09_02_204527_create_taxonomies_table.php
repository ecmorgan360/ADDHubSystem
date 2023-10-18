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
        Schema::create('taxonomies', function (Blueprint $table) {
            $table->increments('taxonomy_id');
            $table->timestamps();
            $table->integer('parent_taxon_id')->unsigned();
            $table->unsignedInteger('rank_id');
            $table->foreign('rank_id')->references('rank_id')->on('taxonhierarchies');
            $table->string('taxon_name', 150);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('taxonomies');
    }
};
