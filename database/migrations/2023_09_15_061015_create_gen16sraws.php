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
        Schema::create('gen16sraws', function (Blueprint $table) {
            $table->increments('gen16s_id');
            $table->timestamps();
            $table->string('supplier_id', 30);
            $table->string('link_forward', 100);
            $table->string('link_reverse', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gen16sraws');
    }
};
