<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalificacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calificaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->unsignedInteger('tipo_id');
            $table->foreignId('cargo_id')->nullable()->constrained('cargos');
            $table->foreignId('materia_id')->constrained('materias');
            $table->string('nombre');
            $table->string('fecha');
            $table->timestamps();

            $table->foreign('tipo_id')
                ->references('id')
                ->on('tipo_calificaciones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calificaciones');
    }
}
