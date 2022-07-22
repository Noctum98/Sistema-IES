<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcesoModularTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proceso_modular', function (Blueprint $table) {
            $table->id();
            $table->integer('promedio_final_porcentaje')->unsigned()->nullable();
            $table->float('promedio_final_nota')->unsigned()->nullable();
            $table->integer('ponderacion_promedio_final')->unsigned()->nullable();
            $table->integer('trabajo_final_porcentaje')->unsigned()->nullable();
            $table->float('trabajo_final_nota')->unsigned()->nullable();
            $table->integer('ponderacion_trabajo_final')->unsigned()->nullable();
            $table->integer('nota_final_porcentaje')->unsigned()->nullable();
            $table->float('nota_final_nota')->unsigned()->nullable();
            $table->boolean('cierre')->default(false);

            //Claves foráneas

            $table->foreignId('proceso_id')->nullable()->constrained('procesos');
            $table->foreignId('operador_id')->nullable()->constrained('users');

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
        Schema::dropIfExists('proceso_modular');
    }
}
