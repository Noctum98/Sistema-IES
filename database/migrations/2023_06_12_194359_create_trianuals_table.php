<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrianualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trianuals', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->unsignedInteger('sede_id');
            $table->unsignedBigInteger('carrera_id');
            $table->unsignedBigInteger('materia_id');
            $table->unsignedBigInteger('alumno_id');
            $table->unsignedBigInteger('condicion_id');
            $table->unsignedBigInteger('equivalencia_id');
            $table->unsignedBigInteger('proceso_id');
            $table->unsignedInteger('operador_id');
            $table->integer('recursado');
            $table->foreign('sede_id')->references('id')->on('sedes');
            $table->foreign('carrera_id')->references('id')->on('carreras');
            $table->foreign('materia_id')->references('id')->on('materias');
            $table->foreign('alumno_id')->references('id')->on('alumnos');
            $table->foreign('condicion_id')->references('id')->on('estados');
            $table->foreign('equivalencia_id')->references('id')->on('equivalencias');
            $table->foreign('proceso_id')->references('id')->on('procesos');
            $table->foreign('operador_id')->references('id')->on('users');
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
        Schema::dropIfExists('trianuals');
    }
}
