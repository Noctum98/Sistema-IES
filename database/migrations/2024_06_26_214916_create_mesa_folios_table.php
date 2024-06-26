<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('mesa_folios', function (Blueprint $table) {
            $table->uuid('id');
            $table->integer('numero');
            $table->string('turno')->nullable();
            $table->date('fecha');
            $table->integer('aprobados')->nullable();
            $table->integer('desaprobados')->nullable();
            $table->integer('ausentes')->nullable();
            $table->foreignUuid('libro_digital_id');
            $table->unsignedBigInteger('mesa_id')->nullable();
            $table->foreignUuid('master_materia_id');
            $table->unsignedInteger('presidente_id')->nullable();
            $table->unsignedInteger('vocal_1_id')->nullable();
            $table->unsignedInteger('vocal_2_id')->nullable();
            $table->unsignedInteger('coordinador_id')->nullable();
            $table->unsignedInteger('operador_id')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->primary('id');
            $table->foreign('libro_digital_id')->references('id')->on('libros_digitales');
            $table->foreign('mesa_id')->references('id')->on('mesas');
            $table->foreign('master_materia_id')->references('id')->on('master_materias');
            $table->foreign('presidente_id')->references('id')->on('users');
            $table->foreign('vocal_1_id')->references('id')->on('users');
            $table->foreign('vocal_2_id')->references('id')->on('users');
            $table->foreign('coordinador_id')->references('id')->on('users');
            $table->foreign('operador_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mesa_folios');
    }
};
