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
        Schema::create('collection_users', function (Blueprint $table) {
            $table->id();
            $table->string('sample_id', 30);
            $table->foreign('sample_id')->references('sample_id')->on('collections')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->unique(['sample_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('collection_users');
    }
};
