<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsMatriculacionPreinscripcionToCarrerasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carreras', function (Blueprint $table) {
            $table->boolean('preinscripcion_habilitada')->default(false);
            $table->boolean('matriculacion_habilitada')->default(false);
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
            $table->dropColumn('preinscripcion_habilitada');
            $table->dropColumn('matriculacion_habilitada');
        });
    }
}
