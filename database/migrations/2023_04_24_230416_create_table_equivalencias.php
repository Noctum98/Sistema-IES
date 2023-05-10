<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableEquivalencias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equivalencias', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
//            $table->foreignId('alumno_id')->constrained('alumnos');
            $table->unsignedBigInteger('materia_id');
            $table->unsignedInteger('user_id');
            $table->unsignedBigInteger('alumno_id');
            $table->integer('nota');
            $table->string('fecha');
            $table->string('resolution');
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
        Schema::dropIfExists('equivalencias');
    }
}
