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
            $table->foreignId('user_id')->constrained('users')->nullable();
            $table->integer('año');
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('telefono');
            $table->string('dni');
            $table->string('cuil');
            $table->string('imagen')->nullable();
            $table->string('fecha');
            $table->integer('edad');
            $table->string('genero');
            $table->string('regularidad');
            $table->string('nacionalidad');
            $table->string('domicilio');
            $table->integer('codigo_postal');
            $table->string('estado_civil');
            $table->string('ocupacion');
            $table->string('g_sanguineo');
            $table->string('escolaridad');
            $table->string('condicion_s')->nullable();
            $table->string('escuela_s')->nullable();
            $table->string('materias_s')->nullable();
            $table->boolean('articulo_septimo')->default(false);
            $table->boolean('privacidad')->nullable();
            $table->boolean('poblacion_indigena')->nullable();
            $table->boolean('discapacidad_mental');
            $table->string('discapacidad_intelectual');
            $table->string('discapacidad_visual');
            $table->string('discapacidad_auditiva');
            $table->string('discapacidad_motriz');
            $table->string('acompañamiento_motriz');
            $table->string('matriculacion');
            $table->string('pase')->nullable();
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
