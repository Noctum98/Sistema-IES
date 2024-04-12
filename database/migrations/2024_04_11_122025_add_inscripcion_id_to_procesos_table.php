<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInscripcionIdToProcesosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('procesos', function (Blueprint $table) {
            $table->foreignId('inscripcion_id')->constrained('alumno_carrera')->nulable();
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
            $table->dropColumn('inscripcion_id');
        });
    }
}
