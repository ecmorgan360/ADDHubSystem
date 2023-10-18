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
        Schema::create('collections', function (Blueprint $table) {
            $table->string('sample_id', 30)->primary();
            $table->timestamps();
            $table->text('other_ids')->nullable();
            $table->unsignedInteger('site_id');
            $table->foreign('site_id')->references('site_id')->on('sites');
            $table->date('date_collected');
            $table->unsignedBigInteger('identifier_id');
            $table->foreign('identifier_id')->references('id')->on('users');
            $table->string('classification', 40);
            $table->text('other_description')->nullable();
            $table->unsignedInteger('taxonomy_id');
            $table->foreign('taxonomy_id')->references('taxonomy_id')->on('taxonomies');
            $table->string('permit_no', 20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('collections');
    }
};
