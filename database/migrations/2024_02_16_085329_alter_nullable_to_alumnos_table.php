<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterNullableToAlumnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alumnos', function (Blueprint $table) {
            $table->string('telefono_fijo')->nullable()->change();
            $table->string('cuil')->nullable()->change();
            $table->string('calle')->nullable()->change();
            $table->string('fecha')->nullable()->change();
            $table->string('edad')->nullable()->change();
            $table->string('genero')->nullable()->change();
            $table->string('regularidad')->nullable()->change();
            $table->string('nacionalidad')->nullable()->change();
            $table->string('localidad')->nullable()->change();
            $table->string('codigo_postal')->nullable()->change();
            $table->string('estado_civil')->nullable()->change();
            $table->string('ocupacion')->nullable()->change();
            $table->string('g_sanguineo')->nullable()->change();
            $table->string('articulo_septimo')->nullable()->change();
            $table->string('discapacidad_mental')->nullable()->change();
            $table->string('discapacidad_intelectual')->nullable()->change();
            $table->string('discapacidad_visual')->nullable()->change();
            $table->string('discapacidad_motriz')->nullable()->change();
            $table->string('discapacidad_auditiva')->nullable()->change();
            $table->string('acompañamiento_motriz')->nullable()->change();
            $table->string('matriculacion')->nullable()->change();
            $table->string('legajo_completo')->nullable()->change();
            $table->string('aprobado')->nullable()->change();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('alumnos', function (Blueprint $table) {
            $table->string('telefono_fijo')->change();
            $table->string('cuil')->change();
            $table->string('calle')->change();
            $table->string('fecha')->change();
            $table->string('edad')->change();
            $table->string('genero')->change();
            $table->string('regularidad')->change();
            $table->string('nacionalidad')->change();
            $table->string('localidad')->change();
            $table->string('codigo_postal')->change();
            $table->string('estado_civil')->change();
            $table->string('ocupacion')->change();
            $table->string('g_sanguineo')->change();
            $table->string('articulo_septimo')->change();
            $table->string('discapacidad_mental')->change();
            $table->string('discapacidad_intelectual')->change();
            $table->string('discapacidad_visual')->change();
            $table->string('discapacidad_motriz')->change();
            $table->string('discapacidad_auditiva')->change();
            $table->string('acompañamiento_motriz')->change();
            $table->string('matriculacion')->change();
            $table->string('legajo_completo')->change();
            $table->string('aprobado')->change();
        });
    }
}
