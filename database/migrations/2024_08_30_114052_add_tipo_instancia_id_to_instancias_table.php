<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTipoInstanciaIdToInstanciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('instancias', function (Blueprint $table) {

            $table->unsignedBigInteger('tipo_instancia_id')->nullable();
            $table->string('fecha_habilitacion')->nullable();
            $table->string('fecha_cierre')->nullable();
            $table->string('fecha_bajas')->nullable();
            $table->string('fecha_cierre_bajas')->nullable();
            $table->foreign('tipo_instancia_id')->references('id')->on('tipo_instancias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('instancias', function (Blueprint $table) {
            $table->dropColumn('tipo_instancia_id');
            $table->dropColumn('fecha_habilitiacion');
            $table->dropColumn('fecha_cierre');
            $table->dropColumn('fecha_bajas');
            $table->dropColumn('fecha_cierre_bajas');
        });
    }
}
