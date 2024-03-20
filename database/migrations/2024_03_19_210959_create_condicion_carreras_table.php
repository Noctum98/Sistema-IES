<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('condicion_carreras', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('identificador');
            $table->boolean('habilitado');
            $table->unsignedInteger('operador_id');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('operador_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('condicion_carreras');
    }
};
