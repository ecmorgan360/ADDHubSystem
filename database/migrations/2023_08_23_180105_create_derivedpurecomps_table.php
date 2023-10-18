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
        Schema::create('derivedpurecomps', function (Blueprint $table) {
            // Create primary key which is a string (e.g. PC-TIC2050-001AB01ba)
            $table->string('derivedpurecomp_id', 40) -> primary();
            $table->timestamps();
            // Date sample submitted
            $table->date('date_sample_submitted');
            // Amount available (in mg)
            $table->float('amount_available', 4, 1);
            // Synthesis potential
            $table->boolean('synthesis_potential');
            // Source ID (e.g. TIC2050-001AB1b)
            $table->string('source_id', 30);
            // MS (True or False)
            $table->boolean('ms');
            // NMR (True or False)
            $table->boolean('nmr');
            // ID of submitter
            $table->integer('submitter_id')->unsigned();
            // Research group id
            $table->unsignedInteger('researchgroup_id');
            $table->foreign('researchgroup_id')->references('group_id')->on('groups');
            // Solubility (list of solvents)
            $table->string('solubility', 50);
            // Stereo Comments
            $table->string('stereo_comments', 30)->nullable();
            // SMILE structure
            $table->string('smile_structure', 50);
            // Molecular weight
            $table->integer('mw')->unsigned();
            // Additional metadata
            $table->boolean('additional_metadata');
            // Existing patent
            $table->boolean('existing_patent');
            // Existing literature True/False
            $table->boolean('existing_literature');
            // Literature hyperlink (if there)
            $table->text('literature_link')->nullable();
            // Solvent name 
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
        Schema::dropIfExists('derivedpurecomps');
    }
};
