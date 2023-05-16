<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegularidadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regularidades', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->unsignedBigInteger('proceso_id');
            $table->unsignedInteger('operador_id');
            $table->unsignedBigInteger('estado_id');
            $table->date('fecha_regularidad');
            $table->date('fecha_vencimiento');
            $table->string('observaciones');
            $table->foreign('proceso_id')->references('id')->on('procesos');
            $table->foreign('operador_id')->references('id')->on('users');
            $table->foreign('estado_id')->references('id')->on('estados');
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
        Schema::dropIfExists('regularidades');
    }
}
