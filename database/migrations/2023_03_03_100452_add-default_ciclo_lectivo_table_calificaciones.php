<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDefaultCicloLectivoTableCalificaciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('calificaciones', function (Blueprint $table) {
            //
        });
        DB::statement('UPDATE calificaciones SET ciclo_lectivo = 2022');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('calificaciones', function (Blueprint $table) {
            //
        });
        DB::statement('UPDATE calificaciones SET ciclo_lectivo = null');
    }
}
