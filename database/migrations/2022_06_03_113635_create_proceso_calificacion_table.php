<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcesoCalificacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proceso_calificacion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('calificacion_id')->constrained('calificaciones');
            $table->foreignId('proceso_id')->constrained('procesos');
            $table->float('nota',10,2)->unsigned();
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
        Schema::dropIfExists('proceso_calificacion');
    }
}
