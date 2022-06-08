<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarrerasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carreras', function (Blueprint $table) {
            $table->id();
//            $table->foreignId('sede_id')->constrained('sedes');
            $table->unsignedBigInteger('sede_id');
            $table->foreign('sede_id')->references('id')->on('sede');
            $table->unsignedBigInteger('coordinador')->nullable();
            $table->foreign('coordinador')->references('id')->on('personal');
            $table->unsignedBigInteger('referente_p')->nullable();
            $table->foreign('referente_p')->references('id')->on('personal');
            $table->unsignedBigInteger('referente_s')->nullable();
            $table->foreign('referente_s')->references('id')->on('personal');
            $table->string('nombre');
            $table->string('titulo');
            $table->integer('años');
            $table->string('resolucion');
            $table->string('modalidad');
            $table->string('turno');
            $table->string('vacunas');
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
        Schema::dropIfExists('carreras');
    }
}
