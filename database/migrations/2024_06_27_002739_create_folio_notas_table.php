<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('folio_notas', function (Blueprint $table) {
            $table->uuid('id');
            $table->integer('orden');
            $table->integer('permiso')->nullable();
            $table->integer('escrito')->nullable();
            $table->integer('oral')->nullable();
            $table->integer('definitiva')->nullable();
            $table->unsignedInteger('operador_id');
            $table->foreignId('acta_volante_id')->nullable();
            $table->foreignUuid('mesa_folio_id');
            $table->foreignId('alumno_id')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->primary('id');

            $table->foreign('operador_id')->references('id')->on('users');
            $table->foreign('acta_volante_id')->references('id')->on('actas_volantes');
            $table->foreign('mesa_folio_id')->references('id')->on('mesa_folios');
            $table->foreign('alumno_id')->references('id')->on('alumnos');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('folio_notas');
    }
};
