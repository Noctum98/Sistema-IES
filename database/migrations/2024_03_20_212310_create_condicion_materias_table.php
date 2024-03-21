<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('condicion_materias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('identificador');
            $table->boolean('habilitado');
            $table->foreignId('operador_id');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('condicion_materias');
    }
};
