<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCamposToEncuestaSocioeconomicaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('encuestas_socioeconomicas', function (Blueprint $table) {
            $table->string('situacion_salud');
            $table->string('cud');
            $table->string('problemas_salud_mental');
            $table->string('dia_actividades');
            $table->string('horario_actividades');
            $table->string('otro_comentario');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('encuestas_socioeconomicas', function (Blueprint $table) {
            $table->dropColumn('situacion_salud');
            $table->dropColumn('cud');
            $table->dropColumn('problemas_salud_mental');
            $table->dropColumn('dia_actividades');
            $table->dropColumn('horario_actividades');
            $table->dropColumn('otro_comentario');
        });
    }
}
