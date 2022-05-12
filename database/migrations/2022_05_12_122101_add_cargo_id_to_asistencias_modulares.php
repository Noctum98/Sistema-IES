<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCargoIdToAsistenciasModulares extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asistencias_modulares', function (Blueprint $table) {
            $table->foreignId('cargo_id')->after('asistencia_id')->constrained('cargos');
            $table->dropColumn('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asistencias_modulares', function (Blueprint $table) {
            //
        });
    }
}
