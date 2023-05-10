<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEtapaCampoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etapa_campo', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('proceso_id');
            $table->float('primera_evaluacion')->nullable();
            $table->float('segunda_evaluacion')->nullable();
            $table->float('tercera_evaluacion')->nullable();
            $table->float('porcentaje_final')->nullable();
            $table->integer('asistencia')->nullable();
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
        Schema::dropIfExists('etapa_campo');
    }
}
