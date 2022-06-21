<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFinalesToProcesosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('procesos', function (Blueprint $table) {
            $table->foreignId('estado_id')->after('alumno_id')->nullable()->constrained('estados');
            $table->boolean('cierre')->after('estado_id')->default(false);
            $table->integer('final_calificaciones')->after('final_parciales')->nullable();
            $table->integer('porcentaje_final_calificaciones')->after('final_calificaciones')->nullable();
            $table->integer('nota_global')->after('porcentaje_final_calificaciones')->nullable();
            $table->integer('nota_recuperatorio')->after('nota_global')->nullable();
            $table->dropColumn('estado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('procesos', function (Blueprint $table) {
            $table->dropColumn('estado_id');
            $table->dropColumn('cierre');
            $table->dropColumn('final_calificaciones')();
            $table->dropColumn('porcentaje_final_calificaciones');
            $table->dropColumn('nota_global')->after('porcentaje_final_calificaciones');
            $table->dropColumn('nota_recuperatorio')->after('nota_global');
            $table->string('estado');
        });
    }
}
