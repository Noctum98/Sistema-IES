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
            $table->foreignId('alumno_id')->constrained('alumnos');
            $table->foreignId('materia_id')->nullable()->constrained('materias');
            $table->foreignId('mesa_id')->nullable()->constrained('mesas');
            $table->foreignId('instancia_id')->constrained('instancias');
            $table->string('nota_escrito')->nullable();
            $table->string('nota_oral')->nullable();
            $table->string('promedio');
            $table->string('libro')->nullable();
            $table->string('folio')->nullable();
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
