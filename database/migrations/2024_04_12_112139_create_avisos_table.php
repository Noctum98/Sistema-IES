<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvisosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avisos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('creador_id')->unsigned();
            $table->text('mensaje');
            $table->timestamp('visible_desde')->nullable();
            $table->timestamp('visible_hasta')->nullable();
            $table->boolean('disabled')->default(false);
            $table->boolean('todos')->default(false);
            $table->timestamps();

            // Añadir FK relación con la tabla de usuarios
            $table->foreign('creador_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('avisos');
    }
}
