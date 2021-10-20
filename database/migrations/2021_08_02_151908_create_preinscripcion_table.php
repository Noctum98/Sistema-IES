<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreinscripcionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preinscripciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carrera_id')->constrained('carreras');
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('dni');
            $table->string('telefono');
            $table->string('email');
            $table->string('imagen')->nullable();
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
            $table->string('dni_archivo');
            $table->string('partida_archivo')->nullable();
            $table->string('titulo_archivo')->nullable();
            $table->string('certificado_archivo');
            $table->string('psicofisico_archivo')->nullable();
            $table->string('vacunacion')->nullable();
            $table->string('primario')->nullable();
            $table->string('ctrabajo')->nullable();
            $table->string('curriculum')->nullable();
            $table->string('nota')->nullable();
            $table->string('conexion');
            $table->string('trabajo');
            $table->string('estado');
            $table->integer('timecheck');
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
        Schema::dropIfExists('preinscripcion');
    }
}
