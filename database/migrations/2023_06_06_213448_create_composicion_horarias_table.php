<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComposicionHorariasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hourlies_compositions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->foreignId('carga_principal_id')->constrained('workloads');
            $table->foreignId('carrera_id')->nullable()->constrained('carreras');
            $table->foreignId('materia_id')->nullable()->constrained('materias');
            $table->foreignId('espacio_id')->nullable()->constrained('spaces');
            $table->integer('cantidad_horas')->nullable();
            $table->unsignedInteger('usuario_id')->unique();
            $table->foreign('usuario_id')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hourlies_compositions');
    }
}
