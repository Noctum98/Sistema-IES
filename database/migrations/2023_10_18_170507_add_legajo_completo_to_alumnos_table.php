<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLegajoCompletoToAlumnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alumnos', function (Blueprint $table) {
            $table->boolean('legajo_completo')->after('fecha_ultima_acreditacion')->default(false);
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
            $table->dropColumn('legajo_completo');
        });
    }
}
