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
        Schema::create('fractions', function (Blueprint $table) {
            // Create primary key which is a string (e.g. TIC2050-001AB01)
            $table->string('fraction_id', 40) -> primary();
            $table->timestamps();
            // Date sample submitted
            $table->date('date_sample_submitted');
            // Amount available (in mg)
            $table->float('amount_available', 4, 1);
            // Type of fractionation used
            $table->string('sample_type', 50);
            // Concentration (in mg/ml)
            $table->float('concentration', 5, 2)->unsigned();
            // Type of project fraction belongs to (Microbial/Bacterial)
            $table->string('project', 30);
            // Source ID (e.g. TIC2050-001AB)
            $table->string('source_id', 30);
            // Research group 
            $table->unsignedInteger('researchgroup_id');
            $table->foreign('researchgroup_id')->references('group_id')->on('groups');
            // ID of submitter
            $table->integer('submitter_id')->unsigned();
            // Solvent name for fractionation
            $table->string('solvent_used', 30);
            // Any comments
            $table->text('comments')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fractions');
    }
};
