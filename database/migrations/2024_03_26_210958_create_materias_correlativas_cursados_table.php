<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('materias_correlativas_cursados', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->foreignId('materia_id')->constrained('materias');
            $table->foreignId('previa_id')->constrained('materias');
            $table->unsignedInteger('operador_id');
            $table->foreign('operador_id')->references('id')->on('users');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materias_correlativas_cursados');
    }
};
