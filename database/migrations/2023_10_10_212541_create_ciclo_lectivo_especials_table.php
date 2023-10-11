<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCicloLectivoEspecialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ciclo_lectivo_especiales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ciclo_lectivo_id')->constrained('ciclo_lectivos');
            $table->date('cierre_ciclo');
            $table->foreignId('materia_id')->constrained('materias');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ciclo_lectivo_especials');
    }
}
