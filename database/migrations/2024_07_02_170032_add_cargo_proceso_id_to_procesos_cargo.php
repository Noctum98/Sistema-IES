<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCargoProcesoIdToProcesosCargo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('procesos_cargos', function (Blueprint $table) {
            $table->unsignedBigInteger('cargo_proceso_id')->nullable();
            $table->foreign('cargo_proceso_id')->references('id')->on('cargo_procesos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('procesos_cargos', function (Blueprint $table) {
            $table->dropColumn('cargo_proceso_id');
        });
    }
}
