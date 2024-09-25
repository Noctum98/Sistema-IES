<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDerivacionesTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('derivaciones_tickets', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->foreignUuid('ticket_id')->constrained('tickets');
            $table->unsignedInteger('rol_id');
            $table->unsignedInteger('operador_id');
            $table->unsignedInteger('sede_id');
            $table->unsignedInteger('carrera_id');
            $table->boolean('general')->default(false);
            $table->boolean('activa')->default(true);
            $table->foreign('rol_id')->references('id')->on('roles');
            $table->foreign('operador_id')->references('id')->on('users');
            $table->foreign('sede_id')->references('id')->on('sedes');
            $table->foreign('carrera_id')->references('id')->on('carreras');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('derivaciones_tickets');
    }
}
