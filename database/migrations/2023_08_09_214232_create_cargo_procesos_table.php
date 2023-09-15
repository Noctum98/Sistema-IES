<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCargoProcesosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cargo_procesos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->unsignedInteger('user_id');
            $table->integer('cantidad_tp')->nullable();
            $table->integer('suma_tp')->nullable();
            $table->float('nota_tp')->nullable();
            $table->integer('cantidad_ps')->nullable();
            $table->integer('suma_ps')->nullable();
            $table->integer('ciclo_lectivo');
            $table->float('nota_ps')->nullable();
            $table->float('nota_cargo')->nullable();
            $table->float('nota_ponderada')->nullable();
            $table->unsignedBigInteger('proceso_id');
            $table->unsignedBigInteger('cargo_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('cargo_id')->references('id')->on('cargos');
            $table->foreign('proceso_id')->references('id')->on('procesos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cargo_procesos');
    }
}
