<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActasVolantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actas_volantes', function (Blueprint $table) {
            $table->id();
            $table->integer('alumno_id');
            $table->integer('materia_id')->nullable();
            $table->integer('mesa_id')->nullable();
            $table->integer('instancia_id');
            $table->string('nota_escrito')->nullable();
            $table->string('nota_oral')->nullable();
            $table->string('promedio');
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
        Schema::dropIfExists('actas_volantes');
    }
}
