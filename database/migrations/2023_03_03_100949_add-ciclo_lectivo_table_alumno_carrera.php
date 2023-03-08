<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddCicloLectivoTableAlumnoCarrera extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alumno_carrera', function (Blueprint $table) {
            Schema::table('alumno_carrera', function (Blueprint $table) {
                $table->integer('ciclo_lectivo')->unsigned()->nullable();
            });
            DB::statement('UPDATE alumno_carrera SET ciclo_lectivo = 2022');
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
            $table->dropColumn('ciclo_lectivo');

        });
    }
}
