<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCargaHorariasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workloads', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->unsignedInteger('profesor_id')->unique();
            $table->foreign('profesor_id')->references('id')->on('users');
            $table->foreignId('materia_id')->nullable()->constrained('materias');
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
        Schema::dropIfExists('workloads');
    }
}
