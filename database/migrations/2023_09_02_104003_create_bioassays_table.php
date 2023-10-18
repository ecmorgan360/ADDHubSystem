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
        Schema::create('bioassays', function (Blueprint $table) {
            $table->string('process_id', 30)->primary();
            $table->foreign('process_id')->references('process_id')->on('processes');
            $table->timestamps();
            $table->unsignedInteger('responsible_pi_id')->nullable();
            $table->foreign('responsible_pi_id')->references('group_id')->on('groups');
            $table->unsignedBigInteger('researcher_id')->nullable();
            $table->foreign('researcher_id')->references('id')->on('users');
            $table->date('date_received')->nullable();
            $table->string('molecular_id', 50)->nullable();
            $table->string('diluent', 30)->nullable();
            $table->float('concentration', 5, 2)->nullable();
            $table->float('amount', 6, 2)->nullable();
            $table->float('ecoli_v', 9, 6)->nullable();
            $table->float('ecoli_sd', 9, 6)->nullable();
            $table->float('saureus_v', 9, 6)->nullable();
            $table->float('saureus_sd', 9, 6)->nullable();
            $table->float('pareu_v', 9, 6)->nullable();
            $table->float('pareu_sd', 9, 6)->nullable();
            $table->float('saureus_bio_v', 9, 6)->nullable();
            $table->float('saureus_bio_sd', 9, 6)->nullable();
            $table->float('pareu_bio_v', 9, 6)->nullable();
            $table->float('pareu_bio_sd', 9, 6)->nullable();
            $table->float('cytotox_v', 9, 6)->nullable();
            $table->float('cytotox_sd', 9, 6)->nullable();
            $table->float('pk_activity', 9, 6)->nullable();
            $table->float('dxr_activity', 9, 6)->nullable();
            $table->float('confirm_dxr_activity', 9, 6)->nullable();
            $table->float('hppk_activity', 9, 6)->nullable();
            $table->boolean('pk_requested');
            $table->boolean('cancelled');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bioassays');
    }
};
