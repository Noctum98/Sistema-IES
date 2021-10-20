<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlumnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumnos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carrera_id')->constrained('carreras');
            $table->integer('año')->nullable();
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('dni');
            $table->string('telefono');
            $table->string('email');
            $table->string('imagen');
            $table->string('fecha');
            $table->string('cuil');
            $table->integer('edad');
            $table->string('nacionalidad');
            $table->string('domicilio');
            $table->string('residencia');
            $table->string('escolaridad');
            $table->string('condicion_s');
            $table->string('escuela_s');
            $table->string('materias_s');
            $table->string('dni_archivo')->nullable();
            $table->string('partida_archivo')->nullable();
            $table->string('titulo_archivo')->nullable();
            $table->string('certificado_archivo')->nullable();
            $table->string('psicofisico_archivo')->nullable();
            $table->string('vacunación')->nullable();
            $table->string('conexion');
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
        Schema::dropIfExists('alumnos');
    }
}
