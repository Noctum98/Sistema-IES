<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAsistenciaFinalPorcentajeTableProcesoModular extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proceso_modular', function (Blueprint $table) {
            $table->float('asistencia_final_porcentaje')->nullable()->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proceso_modular', function (Blueprint $table) {
            $table->dropColumn('asistencia_final_porcentaje');
        });
    }
}
