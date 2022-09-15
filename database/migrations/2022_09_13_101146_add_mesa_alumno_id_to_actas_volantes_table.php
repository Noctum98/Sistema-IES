<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMesaAlumnoIdToActasVolantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('actas_volantes', function (Blueprint $table) {
            $table->integer('mesa_alumno_id');
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
            $table->dropColumn('mesa_alumno_id');
        });
    }
}
