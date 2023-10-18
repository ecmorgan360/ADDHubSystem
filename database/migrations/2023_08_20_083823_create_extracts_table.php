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
        Schema::create('extracts', function (Blueprint $table) {
            // Create primary key which is a string (e.g. TIC2050-001AB)
            $table->string('extract_id', 40) -> primary();
            $table->timestamps();
            // Date sample submitted
            $table->date('date_sample_submitted');
            // Amount available (in mg)
            $table->float('amount_available', 4, 1);
            // MS (True or False)
            $table->boolean('ms');
            // NMR (True or False)
            $table->boolean('nmr');
            // Research group id
            $table->unsignedInteger('researchgroup_id');
            $table->foreign('researchgroup_id')->references('group_id')->on('groups');
            // ID of submitter
            $table->integer('submitter_id')->unsigned();
            // Existing literature (True/False)
            $table->boolean('existing_literature');
            // Literature hyperlink (if there)
            $table->text('literature_link')->nullable();
            // Source ID (e.g. TIC2050-001)
            $table->string('source_id', 30);
            // Source type
            $table->string('source_type', 30);
            // Solvent name for extraction
            $table->string('solvent_extraction', 30);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('extracts');
    }
};
