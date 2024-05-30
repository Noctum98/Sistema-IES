<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('agrupada_materias', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->foreignUuid('correlatividad_agrupada_id');
            $table->foreignUuid('master_materia_id');
            $table->foreignId('user_id');
            $table->boolean('disabled');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('correlatividad_agrupada_id')
                ->references('id')->
                on('correlatividad_agrupadas');

            $table->foreign('master_materia_id')
                ->references('id')->
                on('master_materias');


        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agrupada_materias');
    }
};
