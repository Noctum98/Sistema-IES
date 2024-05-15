<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('resoluciones', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('title');
            $table->unsignedInteger('duration');
            $table->string('resolution');
            $table->string('type');
            $table->string('vaccines')->nullable();
            $table->foreignUuid('tipo_carrera_id');
            $table->foreignId('estados_id');

            $table->foreign('tipo_carrera_id')
                ->references('id')->
                on('tipo_carreras');



            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resoluciones');
    }
};
