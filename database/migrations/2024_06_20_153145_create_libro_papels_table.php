<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('libros_papeles', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name');
            $table->unsignedInteger('number');
            $table->string('roman');
            $table->string('acta_inicio')->nullable();
            $table->string('operador_inicio')->nullable();
            $table->dateTime('fecha_inicio')->nullable();
            $table->unsignedInteger('sede_id');
            $table->unsignedInteger('user_id');
            $table->softDeletes();
            $table->timestamps();

            $table->primary('id');

            $table->foreign('sede_id')->references('id')->on('sedes');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('libro_papel');
    }
};
