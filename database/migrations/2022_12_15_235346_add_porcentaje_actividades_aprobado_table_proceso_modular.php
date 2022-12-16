<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPorcentajeActividadesAprobadoTableProcesoModular extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proceso_modular', function (Blueprint $table) {
            $table->float('porcentaje_actividades_aprobado')->default(null)->nullable();
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
            $table->dropColumn('porcentaje_actividades_aprobado');
        });
    }
}
