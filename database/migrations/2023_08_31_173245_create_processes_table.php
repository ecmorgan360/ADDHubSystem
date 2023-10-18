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
        Schema::create('processes', function (Blueprint $table) {
            // Process ID
            $table->string('process_id', 30) -> primary();
            $table->timestamps();
            // Supplier ID
            $table->string('supplier_id', 50);
            // Assigner ID 
            $table->integer('assigner_id')->unsigned();
            // Date assigned
            $table->date('date_assigned');
            // Sample level
            $table->string('sample_level', 30);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('processes');
    }
};
