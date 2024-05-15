<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('master_materias', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name');
            $table->unsignedInteger('year');
            $table->boolean('field_stage');
            $table->boolean('delayed_closing');
            $table->foreignUuid('resoluciones_id');
            $table->foreignUuid('regimen_id');
            $table->primary('id');

            $table->foreign('resoluciones_id')
                ->references('id')->
                on('resoluciones');

            $table->foreign('regimen_id')
                ->references('id')->
                on('regimens');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_materias');
    }
};
