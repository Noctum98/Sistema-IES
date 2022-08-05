<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProcesoMateriaAsistenciaModular extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asistencias_modulares', function (Blueprint $table) {
            $table->unsignedBigInteger('proceso_id')->nullable();
            $table->unsignedBigInteger('materia_id')->nullable();

            $table->foreign('proceso_id')->references('id')->on('procesos');
            $table->foreign('materia_id')->references('id')->on('materias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asistencias_modulares', function (Blueprint $table) {
            $table->dropColumn('proceso_id');
            $table->dropColumn('materia_id');
        });
    }
}
