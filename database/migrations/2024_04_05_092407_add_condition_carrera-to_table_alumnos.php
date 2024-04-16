<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddConditionCarreraToTableAlumnos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alumnos', function (Blueprint $table) {
            $table->unsignedBigInteger('condicion_carrera_id')->nullable();

            $table->foreign('condicion_carrera_id')
                ->references('id')
                ->on('condicion_carreras')
            ;
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
            $table->dropForeign('alumnos_condicion_carrera_id_foreign');
            $table->dropColumn('condicion_carrera_id');
        });
    }
}
