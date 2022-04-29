<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsistenciaModularTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asistencias_modulares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asistencia_id')->constrained('asistencias');
            $table->foreignId('user_id')->constrained('users');
            $table->integer('porcentaje_presencial')->nullable();
            $table->integer('porcentaje_virtual')->nullable();
            $table->integer('porcentaje');
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
        Schema::dropIfExists('asistencia_modular');
    }
}
