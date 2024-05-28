<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('correlatividad_agrupadas', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('Name');
            $table->string('Description');
            $table->string('Identifier');
            $table->unique('Identifier');
            $table->boolean('Disabled')->default(false);
            $table->foreignUuid('resoluciones_id');
            $table->foreignId('user_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('resoluciones_id')
                ->references('id')
                ->on('resoluciones');


        });
    }

    public function down(): void
    {
        Schema::dropIfExists('correlatividad_agrupadas');
    }
};
