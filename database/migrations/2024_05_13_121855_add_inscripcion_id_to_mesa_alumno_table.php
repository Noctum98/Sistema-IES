<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInscripcionIdToMesaAlumnoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mesa_alumno', function (Blueprint $table) {
            
            $table->unsignedBigInteger('inscripcion_id')
                ->nullable();
            $table->foreign('inscripcion_id')
                ->references('id')->on('alumno_carrera');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mesa_alumno', function (Blueprint $table) {
            $table->dropColumn('inscripcion_id');
        });
    }
}
