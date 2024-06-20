<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('libros_digitales', function (Blueprint $table) {
            $table->uuid('id');
            $table->text('acta_inicio')->nullable();
            $table->unsignedInteger('number');
            $table->string('romanos');
            $table->foreignUuid('resoluciones_id');
            $table->dateTime('fecha_inicio')->nullable();
            $table->unsignedInteger('sede_id');
            $table->string('resolucion_original')->nullable();
            $table->unsignedInteger('operador_id')->nullable();
            $table->string('observaciones');
            $table->unsignedInteger('user_id');
            $table->softDeletes();
            $table->timestamps();

            $table->primary('id');

            $table->foreign('resoluciones_id')->references('id')->on('resoluciones');
            $table->foreign('sede_id')->references('id')->on('sedes');
            $table->foreign('operador_id')->references('id')->on('users');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('libros_digitales');
    }
};
