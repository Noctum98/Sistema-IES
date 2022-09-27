<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcesosCargosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procesos_cargos', function (Blueprint $table) {
            $table->id();
            $table->timestamp('cierre')->nullable();
            $table->unsignedInteger('operador_id')->unsigned();
            $table->bigInteger('proceso_id')->unsigned();
            $table->bigInteger('cargo_id')->unsigned();
            $table->timestamps();

            $table->foreign('operador_id')->references('id')->on('users');
            $table->foreign('proceso_id')->references('id')->on('procesos');
            $table->foreign('cargo_id')->references('id')->on('cargos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('procesos_cargos');
    }
}
