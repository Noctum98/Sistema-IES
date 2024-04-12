<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInscripcionIdToActasVolantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('actas_volantes', function (Blueprint $table) {
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
        Schema::table('actas_volantes', function (Blueprint $table) {
            $table->dropColumn('inscripcion_id');
        });
    }
}
