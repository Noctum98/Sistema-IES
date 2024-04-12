<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToAlumnoCarreraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alumno_carrera', function (Blueprint $table) {
            $table->after('año',function($table){
                $table->string('fecha_primera_acreditacion')->nullable();
                $table->string('fecha_ultima_acreditacion')->nullable();
                $table->string('cohorte')->nullable();
                $table->boolean('legajo_completo')->default(false);
                $table->boolean('aprobado')->default(false);
                $table->string('regularidad')->nullable();
            });
           
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('alumno_carrera', function (Blueprint $table) {
            $table->dropColumn('fecha_primera_acreditacion');
            $table->dropColumn('fecha_ultima_acreditacion');
            $table->dropColumn('cohorte');
            $table->dropColumn('legajo_completo');
            $table->dropColumn('aprobado');
            $table->dropColumn('regularidad');
            $table->dropColumn('deleted_at');
        });
    }
}
