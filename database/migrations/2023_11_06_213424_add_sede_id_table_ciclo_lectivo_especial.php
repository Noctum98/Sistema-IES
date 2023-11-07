<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSedeIdTableCicloLectivoEspecial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ciclo_lectivo_especiales', function (Blueprint $table) {

            $table->unsignedInteger('sede_id');
            $table->foreign('sede_id')->references('id')->on('sedes');
            $table->string('regimen')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ciclo_lectivo_especiales', function (Blueprint $table) {
            $table->dropColumn('sede_id');
            $table->dropColumn('regimen');
        });
    }
}
