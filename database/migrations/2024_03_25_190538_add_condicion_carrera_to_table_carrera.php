<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCondicionCarreraToTableCarrera extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carreras', function (Blueprint $table) {
            $table->unsignedBigInteger('condicion_id')->nullable();
            $table->foreign('condicion_id')->references('id')->on('condicion_carreras');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('carreras', function (Blueprint $table) {
            $table->dropColumn('condicion_id');
        });
    }
}
