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
            $table->unsignedInteger('cohorte')->nullable();
            $table->string('resolucion')->nullable();
            $table->unsignedBigInteger('alumno_id');
            $table->string('matricula')->nullable();
            $table->string('libro')->nullable();
            $table->string('folio')->nullable();
            $table->unsignedInteger('operador_id');
            $table->float('promedio')->nullable();
            $table->string('fecha_egreso')->nullable();
            $table->unsignedInteger('preceptor_id')->nullable();
            $table->unsignedInteger('coordinator_id')->nullable();

            $table->foreign('sede_id')->references('id')->on('sedes');
            $table->foreign('carrera_id')->references('id')->on('carreras');
            $table->foreign('alumno_id')->references('id')->on('alumnos');
            $table->foreign('operador_id')->references('id')->on('users');
            $table->foreign('preceptor_id')->references('id')->on('users');
            $table->foreign('coordinator_id')->references('id')->on('users');
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
