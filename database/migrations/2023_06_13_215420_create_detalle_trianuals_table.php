<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleTrianualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_trianuals', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->unsignedBigInteger('trianual_id');
            $table->unsignedBigInteger('materia_id');
            $table->unsignedBigInteger('condicion_id');
            $table->unsignedBigInteger('equivalencia_id')->nullable();
            $table->unsignedBigInteger('proceso_id');
            $table->unsignedInteger('operador_id');
            $table->unsignedInteger('recursado')->default(0);

            $table->foreign('trianual_id')->references('id')->on('trianuals');
            $table->foreign('materia_id')->references('id')->on('materias');
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
        Schema::dropIfExists('detalle_trianuals');
    }
}
